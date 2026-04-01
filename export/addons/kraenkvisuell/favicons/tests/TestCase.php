<?php

namespace Kraenkvisuell\Favicons\Tests;

use Kraenkvisuell\Favicons\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
