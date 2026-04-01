<?php

namespace App\Fieldtypes\Link;

use Statamic\Fieldtypes\Link\ArrayableLink;

class TypedArrayableLink extends ArrayableLink
{
    public readonly string $link_type;

    public function __construct($value, array $extra = [], string $linkType = 'url')
    {
        parent::__construct($value, $extra);
        $this->link_type = $linkType;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['link_type' => $this->link_type]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if ($offset === 'link_type') {
            return $this->link_type;
        }

        return parent::offsetGet($offset);
    }
}
