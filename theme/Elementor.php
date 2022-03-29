<?php

namespace NormanHuth\WpChild;


class Elementor extends Kernel
{
    protected static ?array $elementorSettings = null;

    /**
     * @return array|null
     */
    public static function getSettings(): ?array
    {
        if (!static::$elementorSettings) {
            $id = get_option('elementor_active_kit');
            static::$elementorSettings = get_post_meta($id, '_elementor_page_settings', true);
        }

        return static::$elementorSettings;
    }

    /**
     * @return array
     */
    public static function getColors(): array
    {
        $settings = static::getSettings();
        $array = [];

        foreach ($settings['system_colors'] as $color) {
            $array[] = $color['color'];
        }
        if (!empty($settings['custom_colors'])) {
            foreach ($settings['custom_colors'] as $color) {
                $array[] = $color['color'];
            }
        }

        return array_unique($array);
    }

    /**
     * @param string|array $type
     * @return array
     */
    public static function getTemplates($type = 'section'): array
    {
        $args = [
            'numberposts' => -1,
            'post_status' => 'publish',
            'post_type'   => 'elementor_library',
            'meta_query'  => [
                'key'     => '_elementor_template_type',
                'value'   => (array)$type,
                'compare' => 'IN'
            ],
        ];

        $posts = get_posts($args);
        $array = [];
        foreach ($posts as $post) {
            $array[$post->ID] = $post->post_title;
        }

        return $array;
    }
}
