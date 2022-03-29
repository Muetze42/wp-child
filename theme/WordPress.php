<?php

namespace NormanHuth\WpChild;

class WordPress
{
    public static array $plugins;

    /**
     * Check if Plugin is active with Plugin folder name
     *
     * @param string $folderName
     * @return bool
     */
    public static function isPluginActive(string $folderName): bool
    {
        if (empty(static::$plugins)) {
            $array = get_option('active_plugins', []);

            static::$plugins = array_map(function ($value) {
                return explode('/', $value)[0];
            }, $array);
        }

        return in_array($folderName, static::$plugins);
    }

    /**
     * Registers a Custom Post Type.
     *
     * @param string $name cpt name (technical)
     * @param string $slug cpt name rewrite slug
     * @param string $singular singular name (frontend)
     * @param string $plural plural name
     * @param array $additionalOptions additional options
     */
    public static function registerPostType(string $name, string $slug, string $singular, string $plural, $createCategory = false, array $additionalOptions = [], $categoryMerge = [])
    {
        $labels = [
            'name'               => _x($plural, 'Post Type General Name', 'child-theme'),
            'singular_name'      => _x($singular, 'Post Type Singular Name', 'child-theme'),
            'menu_name'          => __($plural, 'child-theme'),
            'parent_item_colon'  => __('Parent item', 'child-theme'),
            'all_items'          => sprintf(__('All %s', 'child-theme'), $plural),
            'view_item'          => sprintf(__('View %s', 'child-theme'), $singular),
            'add_new_item'       => sprintf(__('Add %s', 'child-theme'), $singular),
            'add_new'            => sprintf(__('Add %s', 'child-theme'), $singular),
            'edit_item'          => sprintf(__('Edit %s', 'child-theme'), $singular),
            'update_item'        => sprintf(__('Edit %s', 'child-theme'), $singular),
            'search_items'       => __('Search', 'child-theme'),
            'not_found'          => sprintf(__('No %s available', 'child-theme'), $plural),
            'not_found_in_trash' => sprintf(__('No %s available in trash', 'child-theme'), $plural)
        ];

        $params = [
            'label'               => $name,
            'description'         => '',
            'labels'              => $labels,
            'supports'            => [
                'title',
                'editor',
                'excerpt',
                'author',
                'thumbnail',
                'comments',
                'revisions',
                'custom-fields',
                'page-attributes',
            ],
            'taxonomies'          => [],
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => $name,
            'rewrite'             => [
                'slug' => $slug
            ],
            'map_meta_cap'        => true
        ];

        $params = array_merge($params, $additionalOptions);

        register_post_type($name, $params);

        if ($createCategory) {
            $categoryName = $name.'-category';

            if (isset($categoryMerge['name'])) {
                $categoryName = $categoryMerge['name'];
                unset($categoryMerge['name']);
            }

            register_taxonomy($categoryName, $name, array_merge([
                'label'        => sprintf(__('%s category', 'child-theme'), $singular),
                'rewrite'      => ['slug' => strtolower($plural)],
                'hierarchical' => true,
            ], $categoryMerge));
        }

        // assign new capability to administrator
        if (is_admin()) {
            $administrator = get_role('administrator');
            foreach (['publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private'] as $capability) {
                $administrator->add_cap($capability.'_'.$name.'s'); // plural: WordPress adds an "s"
            }
        }
    }
}
