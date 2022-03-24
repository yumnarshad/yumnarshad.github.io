<?php
// Template Name: Properties list
// Wp Estate Pack
if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}
get_header();
$wpestate_options        =   wpestate_page_details($post->ID);
$filtred        =   0;
$compare_submit =   wpestate_get_template_link('compare_listings.php');

// get curency , currency position and no of items per page
global $order;
global $custom_post_type;
$current_user               =   wp_get_current_user();
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$prop_no                    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
$curent_fav                 =   wpestate_return_favorite_listings_per_user();
$icons                      =   array();
$taxonomy                   =   'property_action_category';
$tax_terms                  =   get_terms($taxonomy);
$taxonomy_cat               =   'property_category';
$categories                 =   get_terms($taxonomy_cat);
$show_compare               =   1;
$align_class                =   '';
$wpestate_prop_unit         =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_unit_class            =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$current_adv_filter_search_action       = get_post_meta ( $post->ID, 'adv_filter_search_action', true);
$current_adv_filter_search_category     = get_post_meta ( $post->ID, 'adv_filter_search_category', true);
$current_adv_filter_area                = get_post_meta ( $post->ID, 'current_adv_filter_area', true);
$current_adv_filter_city                = get_post_meta ( $post->ID, 'current_adv_filter_city', true);
$current_adv_filter_county              = get_post_meta ( $post->ID, 'current_adv_filter_county', true);
$show_featured_only                     = get_post_meta($post->ID, 'show_featured_only', true);
$show_filter_area                       = get_post_meta($post->ID, 'show_filter_area', true);
$transient_appendix                     ='';

$custom_post_type='estate_property';

$tax_arguments=array(
    'property_action_category'=>  $current_adv_filter_search_action,
    'property_category'       =>  $current_adv_filter_search_category,
    'property_city'           =>  $current_adv_filter_city,
    'property_area'           =>  $current_adv_filter_area,
    'property_county_state'   =>  $current_adv_filter_county,
);

$order=get_post_meta($post->ID, 'listing_filter',true );
if(isset($_GET['order']) && is_numeric($_GET['order']) ){
    $order=intval($_GET['order']);
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if( is_front_page() ){
    $paged= (get_query_var('page')) ? get_query_var('page') : 1;
}

$meta_query=array();
if($show_featured_only=='yes'){
    $compare_array=array();
    $compare_array['key']        = 'prop_featured';
    $compare_array['value']      = 1;
    $compare_array['type']       = 'numeric';
    $compare_array['compare']    = '=';
    $meta_query[]                = $compare_array;
    $transient_appendix.='_show_featured';
}

$temp_arguments=array(
  'post_type'         => 'estate_property',
  'post_status'       => 'publish',
  'order'             =>  $order,
  'paged'             =>  $paged,
  'posts_per_page'    =>  $prop_no,
  'tax_arguments'     =>  $tax_arguments,
  'meta_query'        =>  $meta_query
);



$arguments_array = wpestate_create_query_arguments($temp_arguments);

$args               = $arguments_array['query_arguments'];
$transient_appendix = $arguments_array['transient_appendix'];



$prop_selection=wpestate_request_transient_cache( 'wpestate_prop_list'.$transient_appendix);
if($prop_selection==false){
    if( $order==0 ){
        $prop_selection = wpestate_return_filtered_by_order($args);
    }else{
        $prop_selection = new WP_Query($args);
    }
    wpestate_set_transient_cache(  'wpestate_prop_list'.$transient_appendix, $prop_selection, 60*60*4 );
}

include( locate_template('templates/normal_map_core.php') );

if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    $mapargs                    =   $args;
    $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    $mapargs['fields']          =   'ids';

    $transient_appendix.='normal_list_maxpins'.$max_pins.'_offset_'.($paged-1)*$prop_no;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1);//call the new pins
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2',
                array('markers2'          =>  $selected_pins));
}

get_footer(); ?>
