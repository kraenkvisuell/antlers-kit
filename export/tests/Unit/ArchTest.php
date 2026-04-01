<?php

test('no dump, dd, sleep or ray left')
    ->expect(['dd', 'dump', 'ray', 'sleep'])
    ->not->toBeUsed();
