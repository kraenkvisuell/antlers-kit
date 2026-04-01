<?php

namespace App\Fieldtypes;

use App\Fieldtypes\Link\TypedArrayableLink;
use Facades\Statamic\Routing\ResolveRedirect;
use Statamic\Fieldtypes\Link as BaseLink;

class Link extends BaseLink
{
    public function augment($value)
    {
        $linkType = match (true) {
            str_starts_with((string) $value, 'entry::') => 'entry',
            str_starts_with((string) $value, 'asset::') => 'asset',
            default => 'url',
        };

        $selectAcrossSites = $this->config('select_across_sites', false);

        return new TypedArrayableLink(
            $value ? ResolveRedirect::item($value, $this->field->parent(), ! $selectAcrossSites) : null,
            ['select_across_sites' => $selectAcrossSites],
            $linkType,
        );
    }
}
