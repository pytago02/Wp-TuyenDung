<?php

function joblook_sanitize_checkbox( $input ) {
    if ( true === $input ) {
        return 1;
     } else {
        return 0;
     }
}
function joblook_sanitize_url( $url ) {
  return esc_url_raw( $url );
}


if (!function_exists('joblook_get_categories_select')):
    function joblook_get_categories_select()
    {
        $joblook_categories = get_categories();
        $results = [];

        if (!empty($joblook_categories)):
            $results[''] = __('Select Category', 'joblook');
            foreach ($joblook_categories as $result) {
                $results[$result->slug] = $result->name;
            }
        endif;
        return $results;
    }
endif;

function joblook_sanitize_select($input, $setting)
{
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control($setting->id)->choices;

    return array_key_exists($input, $choices) ? $input : $setting->default;
}
