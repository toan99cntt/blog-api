<?php

use App\Services\ResponseService;
use Illuminate\Support\Carbon;

if (! function_exists('responder')) {
    function responder(): ResponseService
    {
        return app(ResponseService::class);
    }
}

if (! function_exists('convert_date_vn_to_en')) {
    function convert_date_vn_to_en($dateVN) {
        if (is_null($dateVN)) {
            return null;
        }

        return Carbon::parse($dateVN)->format(config('format.date_en'));
    }
}

if (! function_exists('convert_date_en_to_vn')) {
    function convert_date_en_to_vn($dateEN) {
        if (is_null($dateEN)) {
            return null;
        }

        return Carbon::parse($dateEN)->format(config('format.date_vn'));
    }
}
