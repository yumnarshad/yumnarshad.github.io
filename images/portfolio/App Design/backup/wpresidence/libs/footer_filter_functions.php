<?php

/*
*
* Add footer buttons, navigations and nounces
*
*/

add_action( 'wp_footer', 'wpresidence_footer_includes',10 );

if(!function_exists('wpresidence_footer_includes')):
  function wpresidence_footer_includes(){

    $ajax_nonce_log_reg = wp_create_nonce( "wpestate_ajax_log_reg" );
    print'<input type="hidden" id="wpestate_ajax_log_reg" value="'.esc_html($ajax_nonce_log_reg).'" />    ';

    get_template_part('templates/footer_buttons');
    get_template_part('templates/navigational');
    wp_get_schedules();

    global $wpestate_logo_header_align;
    $logo_header_type            =   wpresidence_get_option('wp_estate_logo_header_type','');
    $wpestate_logo_header_align  =   wpresidence_get_option('wp_estate_logo_header_align','');

    if($logo_header_type=='type3'){
         include( locate_template( 'templates/top_bar_sidebar.php') );
    }

    get_template_part('templates/compare_list');
    //get_template_part('templates/login_register_modal');
    if(is_singular('estate_property')){
        include( locate_template ('/templates/image_gallery.php') );
        include( locate_template ('/templates/realtor_templates/mobile_agent_area.php' ) );
    }

    $ajax_nonce = wp_create_nonce( "wpestate_ajax_filtering" );
    print'<input type="hidden" id="wpestate_ajax_filtering" value="'.esc_html($ajax_nonce).'" />    ';

    $ajax_nonce_pay = wp_create_nonce( "wpestate_payments_nonce" );
    print'<input type="hidden" id="wpestate_payments_nonce" value="'.esc_html($ajax_nonce_pay).'" />    ';

    if(wpestate_is_property_modal()){
        get_template_part('templates/property_details_modal');
    }

  }
endif;
