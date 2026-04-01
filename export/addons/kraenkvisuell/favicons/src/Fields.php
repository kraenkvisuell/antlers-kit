<?php

namespace Kraenkvisuell\Favicons;

class Fields
{
    protected $data;

    /**
     * Instantiate Favicons fields config.
     *
     * @param  mixed  $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Instantiate Favicons fields config.
     *
     * @return static
     */
    public static function new($data = null)
    {
        return new static($data);
    }

    /**
     * Favicons field config.
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            [
                'fields' => $this->getFields(),
            ],
        ];
    }

    public function getFields()
    {
        return [
            [
                'handle' => 'light_512',
                'field' => [
                    'display' => '512px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.512_instructions'),
                    'type' => 'assets',
                    'max_files' => 1,
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,
                    'inline' => true,
                ],
            ],

            [
                'handle' => 'dark_512',
                'field' => [
                    'display' => '512px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'light_192',
                'field' => [
                    'display' => '192px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.192_instructions'),
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'dark_192',
                'field' => [
                    'display' => '192px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'light_180',
                'field' => [
                    'display' => '180px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.180_instructions'),
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'dark_180',
                'field' => [
                    'display' => '180px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'light_48',
                'field' => [
                    'display' => '48px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.48_instructions'),
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'dark_48',
                'field' => [
                    'display' => '48px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'light_32',
                'field' => [
                    'display' => '32px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.32_instructions'),
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'dark_32',
                'field' => [
                    'display' => '32px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'light_16',
                'field' => [
                    'display' => '16px (light mode)',
                    'instructions' => __('favicons::fieldsets/content.16_instructions'),
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],

            [
                'handle' => 'dark_16',
                'field' => [
                    'display' => '16px (dark mode)',
                    'type' => 'assets',
                    'localizable' => true,
                    'container' => 'assets',
                    'show_set_alt' => false,
                    'full_width_setting' => false,

                ],
            ],
        ];
    }
}
