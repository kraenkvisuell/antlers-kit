<?php

namespace Kraenkvisuell\Favicons\Events;

use Statamic\Events\Event;
use Kraenkvisuell\Favicons\SiteDefaults\LocalizedSiteDefaults;

class SiteDefaultsSaved extends Event
{
    public function __construct(public LocalizedSiteDefaults $defaults) {}
}
