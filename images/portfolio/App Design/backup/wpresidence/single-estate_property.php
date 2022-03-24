<?php
// Index Page
// Wp Estate Pack
$status = get_post_status($post->ID);

if ( !is_user_logged_in() ) {
    if($status==='expired'){
        wp_redirect(  esc_url( home_url('/') ) );
        exit;
    }
}else{
    if(!current_user_can('administrator') ){
        if(  $status==='expired'){
            wp_redirect(  esc_url( home_url('/') ) );
            exit;
        }
    }
}

get_header();
global $current_user;
global $propid ;
global $show_compare_only;
global $wpestate_currency;
global $where_currency;

$show_compare_only  =   'no';
$current_user       =   wp_get_current_user();
$wpestate_prop_all_details = get_post_custom($post->ID) ;





wp_estate_count_page_stats($post->ID);

$propid                     =   $post->ID;
$wpestate_options           =   wpestate_page_details($post->ID);
$gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
$gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
$unit                       =   esc_html( wpresidence_get_option('wp_estate_measure_sys', '') );
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$use_floor_plans            =   intval( get_post_meta($post->ID, 'use_floor_plans', true) );


if (function_exists('icl_translate') ){
    $where_currency             =   icl_translate('wpestate','wp_estate_where_currency_symbol', esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') ) );
    $property_description_text  =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( wpresidence_get_option('wp_estate_property_description_text') ) );
    $property_details_text      =   icl_translate('wpestate','wp_estate_property_details_text', esc_html( wpresidence_get_option('wp_estate_property_details_text') ) );
    $property_features_text     =   icl_translate('wpestate','wp_estate_property_features_text', esc_html( wpresidence_get_option('wp_estate_property_features_text') ) );
    $property_adr_text          =   icl_translate('wpestate','wp_estate_property_adr_text', esc_html( wpresidence_get_option('wp_estate_property_adr_text') ) );
    $property_video_text        =   icl_translate('wpestate','wp_estate_property_video_text', esc_html( wpresidence_get_option('wp_estate_property_video_text') ) );

}else{
    $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $property_description_text  =   esc_html( wpresidence_get_option('wp_estate_property_description_text') );
    $property_details_text      =   esc_html( wpresidence_get_option('wp_estate_property_details_text') );
    $property_features_text     =   esc_html( wpresidence_get_option('wp_estate_property_features_text') );
    $property_adr_text          =   stripslashes ( esc_html( wpresidence_get_option('wp_estate_property_adr_text') ) );
    $property_video_text        =   esc_html( wpresidence_get_option('wp_estate_property_video_text') );
}


$agent_id                   =   '';
$content                    =   '';
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.intval($userID);

$pinteres                   =   array();
$property_city              =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area              =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_category          =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
$property_action            =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');
$slider_size                =   'small';
$thumb_prop_face            =   wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'property_full');



if (has_post_thumbnail()){
    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
}


if($wpestate_options['content_class']=='col-md-12'){
    $slider_size='full';
}
?>

<?php
// custom template loading
$wp_estate_global_page_template               = intval  ( wpresidence_get_option('wp_estate_global_property_page_template') );
$wp_estate_local_page_template                = intval  ( get_post_meta($post->ID, 'property_page_desing_local', true));
if($wp_estate_global_page_template!=0 || $wp_estate_local_page_template!=0 ){
    global $wp_estate_global_page_template;
    global $wp_estate_local_page_template;
    global $wpestate_options;
    include( locate_template('templates/property_desing_loader.php') );
}

$sticky_menu_array=array();
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>


<div class="row">
    <?php  get_template_part('templates/breadcrumbs'); ?>


    <?php  include(locate_template('templates/listing_templates/overview_template.php')); ?>





    <div class=" <?php print esc_html($wpestate_options['content_class']);?> full_width_prop">
        <?php get_template_part('templates/ajax_container'); ?>



        <div class="single-content listing-content">


        <?php
        $local_pgpr_slider_type_status  =   get_post_meta($post->ID, 'local_pgpr_slider_type', true);
        $prpg_slider_type_status        =   esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') );


    $show_slider=1;
    if ( $local_pgpr_slider_type_status=='full width header' || $local_pgpr_slider_type_status=='header masonry gallery' ){
        $show_slider=0;
    }

    if( $local_pgpr_slider_type_status=='global' && ( $prpg_slider_type_status == 'full width header'  || $prpg_slider_type_status=='header masonry gallery') )  {
        $show_slider=0;
    }

    if ( $local_pgpr_slider_type_status=='multi image slider'){
        $show_slider=0;
    }

    if( $local_pgpr_slider_type_status=='global' && $prpg_slider_type_status == 'multi image slider')  {
        $show_slider=0;
    }


    if ( $show_slider==1 ){

            if ($local_pgpr_slider_type_status=='global'){
                $prpg_slider_type_status= esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') );
                if($prpg_slider_type_status=='classic'){
                     wpestate_classic_slider($post->ID,$slider_size);
                }else if($prpg_slider_type_status=='vertical'){
                     wpestate_vertical_slider($post->ID,$slider_size);
                }else if($prpg_slider_type_status=='gallery'){
                    wpestate_header_masonry_gallery_type2($post->ID);
                }else{
                     wpestate_horizontal_slider($post->ID,$slider_size);
                }
            }elseif($local_pgpr_slider_type_status=='vertical') {
                   wpestate_vertical_slider($post->ID,$slider_size);
            }elseif($local_pgpr_slider_type_status=='gallery') {
                wpestate_header_masonry_gallery_type2($post->ID);
            }else if($local_pgpr_slider_type_status=='classic'){
                wpestate_classic_slider($post->ID,$slider_size);
            }else{
                wpestate_horizontal_slider($post->ID,$slider_size);
            }


    }
    global $property_subunits_master;
    $has_multi_units=intval(get_post_meta($post->ID, 'property_has_subunits', true));
    $property_subunits_master=intval(get_post_meta($post->ID, 'property_subunits_master', true));

    if($has_multi_units==1){
        include( locate_template ('/templates/multi_units.php') );
    }else{
        if($property_subunits_master!=0){
            include( locate_template ('/templates/multi_units.php') ) ;
        }
    }
    ?>


    <?php
    // content type -> tabs or accordion

    $local_pgpr_content_type_status     =  get_post_meta($post->ID, 'local_pgpr_content_type', true);
    if($local_pgpr_content_type_status =='global'){
        $global_prpg_content_type_status= esc_html ( wpresidence_get_option('wp_estate_global_prpg_content_type','') );
        if($global_prpg_content_type_status=='tabs'){
            include( locate_template ('/templates/property_page_tab_content.php') );
        }else{
            include( locate_template ('/templates/property_page_acc_content.php') );
        }
    }elseif ($local_pgpr_content_type_status =='tabs') {
        include( locate_template ('/templates/property_page_tab_content.php') );
    }else{
        include( locate_template ('/templates/property_page_acc_content.php') );
    }

    ?>

    <?php
    wp_reset_query();
    ?>

        <?php
       // endwhile; // end of the loop
        $show_compare=1;



        $sidebar_agent_option_value=    get_post_meta($post->ID, 'sidebar_agent_option', true);
        $enable_global_property_page_agent_sidebar= esc_html ( wpresidence_get_option('wp_estate_global_property_page_agent_sidebar','') );
        if ( $sidebar_agent_option_value=='global' ){
            if($enable_global_property_page_agent_sidebar!='yes'){
                include( locate_template ('/templates/agent_area.php' ) );
                $sticky_menu_array['prop agent']= esc_html__('Agent', 'wpresidence');
            }

        }else if($sidebar_agent_option_value !='yes'){
            include( locate_template ('/templates/agent_area.php' ) );
            $sticky_menu_array['prop agent']= esc_html__('Agent', 'wpresidence');
        }

        include( locate_template ('/templates/other_agents.php') );

        if(wpresidence_get_option('wp_estate_show_reviews_prop','')=='yes'){
            include( locate_template ('/templates/property_reviews.php' ) );
        }
        include( locate_template ('/templates/similar_listings.php' ) );


        ?>
        </div><!-- end single content -->
    </div><!-- end 9col container-->
<?php
include get_theme_file_path('sidebar.php');
?>
</div>
<?php } // end elementor location ?>




<?php
$mapargs = array(
        'post_type'         =>  'estate_property',
        'post_status'       =>  'publish',
        'p'                 =>  $post->ID ,
        'fields'            =>    'ids');

$selected_pins  =   wpestate_listing_pins('blank_single',0,$mapargs,1);

wp_localize_script('googlecode_property', 'googlecode_property_vars2',
            array('markers2'          =>  $selected_pins));


get_footer(); ?>
