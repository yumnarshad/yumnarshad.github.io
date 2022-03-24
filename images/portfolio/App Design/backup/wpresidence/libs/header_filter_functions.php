<?php

add_action( 'wp_body_open', 'wpresidence_wp_body_open' );

if(!function_exists('wpresidence_wp_body_open')):
function wpresidence_wp_body_open(){

  
}
endif;





if(!function_exists('wpresidence_show_header_wrapper')):
  function wpresidence_show_header_wrapper($header_classes,$logo_header_type){
    ?>
    <div class="master_header <?php echo esc_attr($header_classes['master_header_class']); ?>">
        <?php
            if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes" && !is_page_template( 'splash_page.php' ) ){
                get_template_part( 'templates/top_bar' );
            }
            get_template_part('templates/mobile_menu_header' );
        ?>


        <div class="header_wrapper <?php echo esc_attr($header_classes['header_wrapper_class']);?> ">
            <?php

            if($logo_header_type  =='type5' && !wpestate_is_user_dashboard() ){
                include( locate_template('templates/header5.php') );
            }else{
            ?>

            <div class="header_wrapper_inside <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
                 data-logo="<?php print esc_attr($header_classes['logo']);?>"
                 data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">

                <?php
                print wpestate_display_logo($header_classes['logo']);
                if(  $logo_header_type!='type3'){
                    get_template_part('templates/top_user_menu');
                }

                if($logo_header_type!='type3'){
                ?>
                    <nav id="access">
                        <?php
                            wp_nav_menu(
                                array(  'theme_location'    => 'primary' ,
                                        'walker'            => new wpestate_custom_walker
                                    )
                            );
                        ?>
                    </nav><!-- #access -->
                <?php }else{ ?>
                    <a class="navicon-button header_type3_navicon" id="header_type3_trigger">
                        <div class="navicon"></div>
                    </a>
                <?php }


                if($logo_header_type=='type4'){
                    if ( is_active_sidebar( 'header4-widget-area' ) ) {
                        print '<div id="header4_footer"><ul class="xoxo">';
                            dynamic_sidebar('header4-widget-area');
                        print'</ul></div>';
                    }
                }
                ?>

            </div>
            <?php } ?>
        </div>

     </div>
   <?php
  }
endif;
