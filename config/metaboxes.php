<?php

use NormanHuth\WpChild\MetaBox;

/**
 * Add custom MetBox fields
 * https://docs.metabox.io/fields/autocomplete/
 *
 * @var array
 */
return [
    /*
    |--------------------------------------------------------------------------
    | MetaBox ID Prefix
    |--------------------------------------------------------------------------
    |
    | null for using `ThemeSlug_`
    | Empty string for no prefix
    |
    */
    'prefix' => null,

    /*
    |--------------------------------------------------------------------------
    | Register Metaboxes
    |--------------------------------------------------------------------------
    |
    | Automatic use the `Creating a meta box manually` filter:
    | https://docs.metabox.io/quick-start/#creating-a-meta-box-manually
    | Metaboxes:
    | https://docs.metabox.io/fields/autocomplete/
    |
    */
    'metaboxes' => [
//        'title'      => __('Page Settings', 'text-domain'),
//        'post_types' => 'page',
//        'fields'     => [
//            [
//                'name' => __('Remove Header Margin', 'text-domain'),
//                'id'   => MetaBox::mbField('header-bottom-margin'),
//                'type' => 'checkbox',
//                'std'  => 1,
//            ],
//        ],
    ],
];
