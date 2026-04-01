<?php

use Livewire\Component;
use Statamic\Facades\Entry;

new class extends Component {
    public $category = 'all';

    public $categoryOptions = [
        [
            'key' => 'all',
            'value' => 'Alle',
        ],
        [
            'key' => 'handel',
            'value' => 'Handel',
        ],
        [
            'key' => 'gastronomie',
            'value' => 'Gastronomie',
        ],
    ];

    public function render()
    {
        $query = $suppliers = Entry::query()->where('collection', 'suppliers')->whereStatus('published');

        if ($this->category !== 'all') {
            $query->where('supplier_category', $this->category);
        }

        $suppliers = $query
            ->get()
            ->filter(fn($entry) => !empty($entry->get('lat_lng')))
            ->map(function ($entry) {
                $coords = json_decode($entry->get('lat_lng'), true);

                return [
                    'title' => (string) $entry->get('title'),
                    'street' => (string) $entry->get('street'),
                    'postcode' => (string) $entry->get('postcode'),
                    'city' => (string) $entry->get('city'),
                    'phone' => (string) $entry->get('phone'),
                    'lat' => $coords['lat'] ?? null,
                    'lng' => $coords['lng'] ?? null,
                ];
            })
            ->filter(fn($s) => $s['lat'] && $s['lng'])
            ->values()
            ->toArray();

        return $this->view([
            'suppliers' => $suppliers,
        ]);
    }
};

?>

<div
    class="flex flex-col gap-4"
    x-data="suppliersMap({{ json_encode($suppliers) }})"
    x-init="init()"
>
    <div class="flex justify-center">
        <div>
            <x-forms.radios-field
                :inline="true"
                :options="$this->categoryOptions"
                wire:model.live="category"
            />
        </div>
    </div>

    <div
        id="suppliers-map"
        wire:ignore
        data-api-key="{{ config('googlemaps.key') }}"
        class="w-full rounded-lg overflow-hidden"
        style="height: 600px;"
    ></div>

    <script>
        function suppliersMap(suppliers) {
            return {
                suppliers: suppliers,
                map: null,
                openInfoWindow: null,

                init() {
                    const wait = setInterval(() => {
                        if (typeof google !== 'undefined' && google.maps && google.maps.Map && google.maps.LatLngBounds) {
                            clearInterval(wait)
                            this.setupMap()
                        }
                    }, 50)
                },

                setupMap() {
                    const bounds = new google.maps.LatLngBounds()

                    this.map = new google.maps.Map(document.getElementById('suppliers-map'), {
                        zoom: 7,
                        center: {
                            lat: 51.165691,
                            lng: 10.451526
                        },
                        mapTypeControl: false,
                        streetViewControl: false,
                        fullscreenControl: true,
                        zoomControl: true,
                    })

                    const markers = []

                    this.suppliers.forEach(supplier => {
                        const lat = parseFloat(supplier.lat)
                        const lng = parseFloat(supplier.lng)

                        if (isNaN(lat) || isNaN(lng)) return

                        const position = { lat, lng }
                        bounds.extend(position)

                        const marker = new google.maps.Marker({
                            position,
                            title: supplier.title,
                        })

                        const addressLines = [
                            supplier.street,
                            [supplier.postcode, supplier.city].filter(Boolean).join(' '),
                        ].filter(Boolean).join('<br>')

                        const infoWindow = new google.maps.InfoWindow({
                            content: `<div style="font-family: sans-serif; font-size: 14px; max-width: 200px;">
                            <div style="font-weight: bold; margin-bottom: 4px;">${supplier.title}</div>
                            <div style="color: #555; line-height: 1.4;">${addressLines}</div>
                            ${supplier.phone ? `<div style="margin-top: 4px; color: #555;"><a href="tel:${supplier.phone}" style="color: inherit;">${supplier.phone}</a></div>` : ''}
                        </div>`,
                        })

                        marker.addListener('click', () => {
                            if (this.openInfoWindow) {
                                this.openInfoWindow.close()
                            }
                            infoWindow.open(this.map, marker)
                            this.openInfoWindow = infoWindow
                        })

                        markers.push(marker)
                    })

                    new markerClusterer.MarkerClusterer({ map: this.map, markers })

                    if (!bounds.isEmpty()) {
                        this.map.fitBounds(bounds)

                        google.maps.event.addListenerOnce(this.map, 'bounds_changed', () => {
                            if (this.map.getZoom() > 14) {
                                this.map.setZoom(14)
                            }
                        })
                    }
                },
            }
        }
    </script>
</div>
