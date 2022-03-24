<?php
if(is_singular('estate_agent')){
    $realtor_details    =   wpestate_return_agent_details('',$post->ID);
    $whatsup_mess       =   'https://api.whatsapp.com/send?phone='.esc_html($realtor_details['realtor_mobile']).'&text='.esc_html__('Hello I\'m interested in one of your listings.','wpresidence');
    ?>
    <a  class="wpresidence_button send_email_agent"  href="#show_contact" >
        <?php esc_html_e('Send Email', 'wpresidence');?>
    </a>

<?php }else if(is_singular('estate_property')){

     $realtor_details    =   wpestate_return_agent_details($post->ID);
     $whatsup_mess='https://api.whatsapp.com/send?phone='.esc_html($realtor_details['realtor_mobile']).'&text='.esc_html__('Hello I\'m interested in ','wpresidence').'['.get_the_title($post->ID).'] '.get_permalink($post->ID);

}
?>



<a class="wpresidence_button wpresidence_button_inverse realtor_call" href="tel:<?php echo esc_html($realtor_details['realtor_mobile']);?> ">
    <i class="fas fa-phone"></i>
    <?php esc_html_e('Call','wpresidence');echo ' <span class="agent_call_no">'.esc_html($realtor_details['realtor_mobile']).'</span>';?>
</a>

<a class="wpresidence_button wpresidence_button_inverse realtor_whatsapp" href="<?php echo esc_url($whatsup_mess);?>">
    <i class="fab fa-whatsapp"></i>
    <?php esc_html_e('WhatsApp','wpresidence');?>
</a>
