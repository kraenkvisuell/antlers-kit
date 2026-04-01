<?php

namespace Kraenkvisuell\Favicons;

use Statamic\Events;

class Blueprint
{
    const DATA_PROPERTY = [
        Events\EntryBlueprintFound::class => 'entry',
        Events\TermBlueprintFound::class => 'term',
    ];

    protected $blueprint;
    protected $data;

    protected static $addingField = false;

    /**
     * Instantiate blueprint found event handler.
     *
     * @param  mixed  $event
     */
    public function __construct($event)
    {
        $this->blueprint = $event->blueprint;
        $this->data = $this->getEventData($event);
    }

    /**
     * Instantiate blueprint found event handler.
     *
     * @param  mixed  $event
     * @return static
     */
    public static function on($event)
    {
        return new static($event);
    }

    /**
     * Ensure Favicons section and fields are added to (or removed from) blueprint.
     *
     * @param  bool  $isEnabled
     */
    public function ensureFaviconFields($isEnabled = true)
    {
        $isEnabled
            ? $this->addFaviconsFields()
            : $this->removeFaviconsFields();
    }

    /**
     * Add Favicons section and fields to blueprint.
     */
    public function addFaviconsFields()
    {
        if (static::$addingField) {
            return;
        }

        static::$addingField = true;

        $this->blueprint->ensureFieldInTab(
            handle: 'favicons',
            config: [
                'type' => 'favicons',
                'listable' => false,
                'display' => 'Favicons',
            ],
            tab: 'Favicons'
        );

        static::$addingField = false;
    }

    /**
     * Remove Favicons section and fields from blueprint.
     */
    public function removeFaviconsFields()
    {
        $this->blueprint->removeTab('Favicons');
    }

    /**
     * Get event data.
     *
     * @param  mixed  $event
     * @return mixed
     */
    protected function getEventData($event)
    {
        $eventClass = get_class($event);

        $dataProperty = static::DATA_PROPERTY[$eventClass];

        return $event->{$dataProperty};
    }
}
