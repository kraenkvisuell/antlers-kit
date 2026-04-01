<?php

use Illuminate\Support\Str;
use App\Services\EditorService;

function cdnImage($image, array $options = [])
{
    if (!$image) {
        return '';
    }

    $output = $options['fileformat'] ?? 'webp';

    if ($output === 'svg') {
        return config('app.image_cdn')
            . '/' . config('filesystems.disks.assets.root') . '/' . $image['path'];
    }

    $transformations = [];
    $transformations[] = 'output=' . $output;

    $crop = $options['crop'] ?? false;

    $quality = $options['quality'] ?? 75;
    $transformations[] = 'quality=' . $quality;


    if (@$options['focus']) {
        $focusArr = array_map(fn($item) => intval($item) . 'p', array_filter(explode(' ', $options['focus'])));

        if (count($focusArr) === 2) {
            $transformations[] = 'focus=' . implode('x', $focusArr);
        }
    }

    if ($crop && isset($options['fit']) && is_array($options['fit']) && count($options['fit']) === 2) {
        $transformations[] = 'refit-cover=' . implode('x', $options['fit']);
    } elseif (isset($options['fit']) && is_array($options['fit']) && count($options['fit']) === 2) {
        $transformations[] = 'contain-max=' . implode('x', $options['fit']);
    } elseif (isset($options['width']) && !isset($options['height'])) {
        $transformations[] = 'resize-max=' . $options['width'];
    } elseif (!isset($options['width']) && isset($options['height'])) {
        $transformations[] = 'resize-max=-x' . $options['height'];
    } elseif (isset($options['width']) && isset($options['height'])) {
        $transformations[] = 'resize-max=' . $options['width'] . 'x' . $options['height'];
    }

    return config('app.image_cdn')
        . '/' . config('filesystems.disks.assets.root') . '/' . $image['path']
        . '?twic=v1/' . implode('/', $transformations);
}

function cdnVideo($video, array $options = [])
{
    //return $video['url'];
    if (!$video) {
        return '';
    }

    $transformations = [];
    if (isset($options['output'])) {
        $transformations[] = 'output=' . $options['output'];
    }
    if (isset($options['cover'])) {
        $transformations[] = 'refit-cover=' . $options['cover'];
    }



    return config('app.video_cdn')
        . '/' . config('filesystems.disks.assets.root') . '/' . $video['path']
        . '?twic=v1/quality=90/' . implode('/', $transformations);
}

function ensureUrl($str)
{
    $str = trim($str);

    if (
        !Str::startsWith($str, '/')
        && !Str::startsWith($str, 'http://')
        && !Str::startsWith($str, 'https://')
        && !Str::startsWith($str, 'mailto:')
        && !Str::startsWith($str, 'tel:')
    ) {
        $str = 'https://' . $str;
    }

    return $str;
}

function transformText($str)
{
    if (is_array($str)) {
        $str = bardify($str);
    }

    $replacer = '<span class="text-[0.6em] leading-[0.5em] inline-block flex-shrink-0 whitespace-nowrap relative top-[-0.15em]"><i class="fa-kit fa-play mr-[-0.1em]"></i><i class="fa-kit fa-play"></i></span>';

    $str = str_replace('»', $replacer, $str);

    $str = str_replace('$gt;$gt;', $replacer, $str);

    $str = str_replace('№', '<span class="whitespace-nowrap">N<sup class="underline decoration-2">o</sup></span>', $str);

    $str = str_replace('®', '<sup class="relative top-[-0.3em]">®</sup>', $str);

    return $str;
}

function fakeHeadlines($str)
{
    $pattern = '/<p><strong(.*?)>(.*?)<\/strong><\/p>/i';
    $replace = '<h2>$2</h2>';
    $str = preg_replace($pattern, $replace, $str);

    return $str;
}

function emojify($str)
{
    //$str = str_replace('💪', '<i class="fa-kit fa-power text-task3 text-[80%]"></i>', $str);

    return $str;
}

function localifyUrls($str)
{
    $str = str_replace('https://kinderschauspielschule.de/', '/', $str);

    $str = str_replace('https://www.kinderschauspielschule.de/', '/', $str);

    return $str;
}

function whatsappize($number, $text = '')
{
    $str = str_replace('+', '', $number);
    $str = str_replace(' ', '', $str);
    $str = 'https://wa.me/' . $str;

    if ($text) {
        $str .= '?text=' . urlencode($text);
    }

    return $str;
}

function bardify($text)
{
    if (!$text) {
        return '';
    }

    if (is_string($text) && Str::startsWith(trim($text), '<')) {
        return $text;
    }

    if (!is_string($text) && !is_array($text) && @$text->raw()) {
        if (is_string(@$text->raw())) {
            $text = json_decode($text->raw());
        } else {
            $text = $text->raw();
        }
    } elseif (is_string($text)) {
        $text = json_decode($text);
    }

    return (new EditorService)->editor()->setContent(['content' => $text])->getHTML();
}

function refererIsLocal()
{
    return stristr(request()->headers->get('referer'), config('app.url'));
}

function float2rat($n, $tolerance = 1.e-6)
{
    $h1 = 1;
    $h2 = 0;
    $k1 = 0;
    $k2 = 1;
    $b = 1 / $n;
    do {
        $b = 1 / $b;
        $a = floor($b);
        $aux = $h1;
        $h1 = $a * $h1 + $h2;
        $h2 = $aux;
        $aux = $k1;
        $k1 = $a * $k1 + $k2;
        $k2 = $aux;
        $b = $b - $a;
    } while (abs($n - $h1 / $k1) > $n * $tolerance);

    return "$h1/$k1";
}
