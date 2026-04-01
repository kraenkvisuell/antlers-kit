<x-mail::message>
# Formular auf Website ausgefüllt

Jemand hat ein Formular auf Ihrer Website ausgefüllt. Hier sind die Details:

<x-mail::panel>
@foreach ($fields as $item)
<strong>{{ $item['handle'] }}:</strong> {{ $item['value'] }}<br>
@endforeach
</x-mail::panel>
</x-mail::message>
