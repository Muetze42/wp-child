<?php
/*
|--------------------------------------------------------------------------
| Remove „rel="nofollow"“ attribute from „Add to Cart“ Buttons
|--------------------------------------------------------------------------
*/
//add_filter('woocommerce_loop_add_to_cart_args', function ($args, $product) {
//    $args['attributes']['rel'] = 'nofollow noindex';
//
//    return $args;
//}, 10, 2);

/*
|--------------------------------------------------------------------------
| Make the input of the phone number optional
|--------------------------------------------------------------------------
*/
//add_filter('woocommerce_billing_fields', function ($address_fields) {
//    if (isset($address_fields['billing_phone']['required'])) {
//        $address_fields['billing_phone']['required'] = false;
//    }
//
//    return $address_fields;
//}, 10, 1);

/*
|--------------------------------------------------------------------------
| Change number of products displayed per page
|--------------------------------------------------------------------------
|
| Source:
| https://woocommerce.com/document/change-number-of-products-displayed-per-page/
|
*/
//add_filter('loop_shop_per_page', function ($cols) {
//    return 12;
//}, 20);

/*
|--------------------------------------------------------------------------
| Disable Product Zoom
|--------------------------------------------------------------------------
*/
//add_filter('woocommerce_single_product_zoom_enabled', '__return_false');
