<?php
$price_label                =   esc_html ( get_post_meta($post_id, 'property_label', true) );
$price_label_before         =   esc_html ( get_post_meta($post_id, 'property_label_before', true) );
$price                      =   floatval ( get_post_meta($post_id, 'property_price', true) );
$wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

$show_price =  wpestate_show_price($post_id,$wpestate_currency,$where_currency,1);
print strip_tags($show_price);
