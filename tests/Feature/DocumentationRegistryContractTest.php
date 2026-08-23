<?php

use App\Support\DocumentationComponents;
use SampaUI\Support\ComponentRegistry;

it('uses the package registry as the public API source for every documentation page', function () {
    $documentation = DocumentationComponents::all();

    foreach (ComponentRegistry::all() as $slug => $component) {
        expect($documentation)->toHaveKey($slug);

        $props = array_map(
            static fn (array $prop): string => $prop['name'],
            $documentation[$slug]['props'],
        );

        expect($documentation[$slug]['tag'])->toBe($component['tag'])
            ->and($props)->toBe($component['props']);
    }
});
