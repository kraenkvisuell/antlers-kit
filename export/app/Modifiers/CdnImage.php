<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class CdnImage extends Modifier
{
    public function index($value, $params, $context)
    {
        if (!$value) {
            return '#';
        }

        if ($value['extension'] === 'svg') {
            return config('site.image_cloud')
                . '/' . config('filesystems.disks.assets.root') . '/' . $value['path'];
        }

        $allowedKeys = [
            'achromatopsia' => '',
            'background' => '',
            'border' => '',
            'colorize' => '',
            'contain' => '',
            'contain-max' => '',
            'contain-min' => '',
            'cover' => '',
            'cover-max' => '',
            'cover-min' => '',
            'crop' => '',
            'deuteranopia' => '',
            'download' => '',
            'duration' => '',
            'flip' => '',
            'focus' => '',
            'from' => '',
            'inside' => '',
            'max' => '',
            'min' => '',
            'noop' => '',
            'output' => '',
            'protanopia' => '',
            'quality' => '',
            'quality-max' => '',
            'quality-min' => '',
            'refit' => '',
            'refit-cover' => '',
            'refit-inside' => '',
            'resize' => '',
            'resize-max' => '',
            'resize-min' => '',
            'to' => '',
            'tritanopia' => '',
            'truecolor' => '',
            'turn' => '',
            'zoom' => '',
        ];


        $transformations = [];

        if (!$value) {
            return '';
        }

        foreach (array_map('trim', $params) as $param) {
            if (strpos($param, '=') > 0) {
                [$key, $val] = explode('=', $param);
                if (array_key_exists($key, $allowedKeys)) {
                    $transformations[$key] = $val;
                }
            }
        }

        if (!isset($transformations['output'])) {
            $transformations['output'] = 'webp';
        }

        if (!isset($transformations['quality'])) {
            $transformations['quality'] = '90';
        }

        $transformationStrings = [];
        foreach ($transformations as $key => $val) {
            $transformationStrings[] = $key . '=' . $val;
        }

        return config('site.image_cdn')
            . '/' . config('filesystems.disks.assets.root') . '/' . $value['path']
            . '?twic=v1/' . implode('/', $transformationStrings);
        return $value;
    }
}
