<?php
global $wpestate_options;
global $prop_id;

$pict_size=5;
$content_size=7;

if ($wpestate_options['content_class']=='col-md-12'){
   $pict_size=5; 
   $content_size=7; 
}

if ( get_post_type($prop_id) == 'estate_property' ){
    $pict_size=5;
    $content_size=7;
    if ($wpestate_options['content_class']=='col-md-12'){
       $pict_size=3; 
       $content_size=9;
    }   
}

?>
<div class="wpestate_agent_details_wrapper">
    <div class="col-md-<?php print esc_attr($pict_size);?> agentpic-wrapper">
            <div class="agent-listing-img-wrapper" data-link="<?php print esc_attr($realtor_details['link']); ?>">
                <div class="agentpict" style="background-image:url(<?php echo esc_url($realtor_details['realtor_image']); ?>)"> </div>
            </div>

            <div class="agent_unit_social_single">
              
                    <?php
                    if($realtor_details['realtor_facebook']!=''){
                        print ' <a href="'. esc_url($realtor_details['realtor_facebook']).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                    }

                    if($realtor_details['realtor_twitter']!=''){
                        print ' <a href="'.esc_url($realtor_details['realtor_twitter']).'" target="_blank"><i class="fab fa-twitter"></i></a>';
                    }
                    if($realtor_details['realtor_linkedin']!=''){
                        print ' <a href="'.esc_url($realtor_details['realtor_linkedin']).'" target="_blank"><i class="fab fa-linkedin"></i></a>';
                    }
                    if($realtor_details['realtor_pinterest']!=''){
                        print ' <a href="'. esc_url($realtor_details['realtor_pinterest']).'" target="_blank"><i class="fab fa-pinterest"></i></a>';
                    }
                    if($realtor_details['realtor_instagram']!=''){
                        print ' <a href="'. esc_url($realtor_details['realtor_instagram']).'" target="_blank"><i class="fab fa-instagram"></i></a>';
                    }
                    ?>

             
            </div>
    </div>  

    <div class="col-md-<?php print esc_html($content_size);?> agent_details">    
           
            <?php   
            
            $author         = get_post_field( 'post_author', $post->ID) ;
            $agency_post    = get_the_author_meta('user_agent_id',$author);
             
            print '<h3><a href="'.esc_url($realtor_details['link']).'">'.esc_html($realtor_details['realtor_name']).'</a></h3>
            <div class="agent_position">'.esc_html($realtor_details['realtor_position']);
            if(is_singular('estate_agent') && $agency_post!=''){
                print ',<a href="'.esc_url(get_permalink($agency_post)).'"> '.get_the_title($agency_post).'</a>';
            }
            print'</div>';
 
            if ($realtor_details['realtor_phone']!='') {
                print '<div class="agent_detail agent_phone_class"><i class="fas fa-phone"></i><a href="tel:'.esc_html($realtor_details['realtor_phone']).'">'.esc_html($realtor_details['realtor_phone']).'</a></div>';
            }
            if ($realtor_details['realtor_mobile']!='') {
                print '<div class="agent_detail agent_mobile_class"><i class="fas fa-mobile"></i></i><a href="tel:'.esc_html($realtor_details['realtor_mobile']). '">'.esc_html($realtor_details['realtor_mobile']).'</a></div>';
            }

            if ($realtor_details['email']!='') {
                print '<div class="agent_detail agent_email_class"><i class="far fa-envelope"></i><a href="mailto:' .esc_html( $realtor_details['email']) . '">' . esc_html($realtor_details['email']).'</a></div>';
            }

            if ($realtor_details['realtor_skype']!='') {
                print '<div class="agent_detail agent_skype_class"><i class="fab fa-skype"></i>' . esc_html($realtor_details['realtor_skype'] ). '</div>';
            }

            if ($realtor_details['realtor_urlc']!='') {
                print '<div class="agent_detail agent_web_class"><i class="fas fa-desktop"></i><a href="'.esc_url($realtor_details['realtor_urlc']).'" target="_blank">'.esc_html($realtor_details['realtor_urlc']).'</a></div>';
            }
            
            if($realtor_details['member_of']!=''){
                print '<div class="agent_detail agent_web_class"><strong>'.esc_html__('Member of:','wpresidence').'</strong> '.esc_html($realtor_details['member_of']).'</div>';
          
            }
            ?>

    </div>
    
    <div class="row custom_details_container">
     
    
    <?php 
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( !is_singular('estate_property')) {
        if( is_plugin_active( 'elementor/elementor.php' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
        
            // do nothing
        }else{
            get_template_part('templates/realtor_templates/agent_contact_bar');
            get_template_part('templates/realtor_templates/agent_custom_data'); 
            get_template_part('templates/realtor_templates/agent_taxonomies');
        }
    }
    ?> 
  
    </div>

</div>


<?php  get_template_part('templates/realtor_templates/agent_about_me'); ?>