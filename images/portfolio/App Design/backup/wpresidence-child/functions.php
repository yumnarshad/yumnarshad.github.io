<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

 
if ( !function_exists( 'wpestate_chld_thm_cfg_parent_css' ) ):
    function wpestate_chld_thm_cfg_parent_css() {
        $parent_style = 'wpestate_style'; 
        wp_enqueue_style('bootstrap.min',get_theme_file_uri('/css/bootstrap.min.css'), array(), '1.0', 'all');  
        wp_enqueue_style('bootstrap-theme.min',get_theme_file_uri('/css/bootstrap-theme.min.css'), array(), '1.0', 'all');  
        
        $use_mimify     =   wpresidence_get_option('wp_estate_use_mimify','');
        $mimify_prefix  =   '';
        if($use_mimify==='yes'){
            $mimify_prefix  =   '.min';    
        }
        
        if($mimify_prefix===''){
            wp_enqueue_style($parent_style,get_template_directory_uri().'/style.css', array('bootstrap.min','bootstrap-theme.min'), '1.0', 'all');  
        }else{
            wp_enqueue_style($parent_style,get_template_directory_uri().'/style.min.css', array('bootstrap.min','bootstrap-theme.min'), '1.0', 'all');  
        }
        
        if ( is_rtl() ) {
           wp_enqueue_style( 'chld_thm_cfg_parent-rtl',  trailingslashit( get_template_directory_uri() ). '/rtl.css' );
	}
        wp_enqueue_style( 'wpestate-child-style',
            get_stylesheet_directory_uri() . '/style.css',
                array( $parent_style ),
                wp_get_theme()->get('Version')
        );
        
    }
endif;

load_child_theme_textdomain('wpresidence', get_stylesheet_directory().'/languages');
add_action( 'wp_enqueue_scripts', 'wpestate_chld_thm_cfg_parent_css' );