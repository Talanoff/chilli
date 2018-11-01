<?php

if (!function_exists('phone_icon')) {
    function phone_icon($phone)
    {
        $operator = substr($phone, 0, 3);

        $kyivstar = ['067', '068', '098'];
        $vodafone = ['066', '095', '099'];
        $lifecell = ['063'];

        switch ($operator) {
            case in_array($operator, $kyivstar):
                $icon = 'kyivstar';
                break;
            case in_array($operator, $vodafone):
                $icon = 'vodafone';
                break;
            case in_array($operator, $lifecell):
                $icon = 'lifecell';
                break;
            default:
                $icon = 'phone';
        }

        return $icon;
    }
}

if (!function_exists('phone_link')) {
    function phone_link($phone)
    {
        return '+38' . str_replace(['(', ')', '-', ' '], '', $phone);
    }
}

if (!function_exists('build_filter_url')) {
    function build_filter_url($array, $route = null)
    {
        if (!$array || !is_array($array)) {
            return null;
        }

        return route($route ?? app('router')->currentRouteName(), array_merge(request()->except('page'), $array));
    }
}
