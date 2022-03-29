<?php

namespace NormanHuth\WpChild;

class MetaBox extends Kernel
{
    protected static ?string $metaBoxIdPrefix = null;
    protected static array $config;

    /**
     * @param string|null $key
     * @return array|string|null
     */
    public static function getConfig(?string $key = null)
    {
        if (empty(static::$config)) {
            static::$config = require static::getThemePath('config/metaboxes.php');
        }

        if ($key) {
            return static::$config[$key];
        }

        return static::$config;
    }

    /**
     * @return string
     */
    public static function getMetaIdPrefix(): string
    {
        if (empty(static::$metaBoxIdPrefix)) {
            if (is_null(static::getConfig('prefix'))) {
                static::$metaBoxIdPrefix = static::getThemeSlug().'_';
            }
            static::$metaBoxIdPrefix = static::getConfig()['prefix'];
        }

        return static::$metaBoxIdPrefix;
    }

    /**
     * @param string $id
     * @return string
     */
    public static function mbField(string $id): string
    {
        return static::getMetaIdPrefix().$id;
    }

    /**
     * https://docs.metabox.io/rwmb-get-value/
     *
     * @param string $fieldId
     * @param array $args
     * @param int|null $postId
     * @return mixed
     */
    public static function mbValue(string $fieldId, array $args = [], ?int $postId = null)
    {
        return rwmb_get_value(static::mbField($fieldId), $args, $postId);
    }

    /**
     * https://docs.metabox.io/rwmb-meta/
     *
     * @param string $fieldId
     * @param array $args
     * @param int|null $postId
     * @return mixed
     */
    public static function mbMeta(string $fieldId, array $args = [], ?int $postId = null)
    {
        return rwmb_meta(static::mbField($fieldId), $args, $postId);
    }

    /**
     * @return array
     */
    protected function getShopCategoriesToArray(): array
    {
        $options = [];
        $categories = get_terms( [
            'orderby'    => 'title',
            'order'      => 'ASC',
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ]);

        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }

        return $options;
    }
}
