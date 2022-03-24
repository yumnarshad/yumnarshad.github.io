<?php
$agent_id       =   intval( get_post_meta($post->ID, 'property_agent', true) );


?>
<div class="mobile_agent_area_wrapper">
<?php

$prop_id        =   $post->ID;
$realtor_details    =   wpestate_return_agent_details($prop_id);

$whatsup_mess='https://api.whatsapp.com/send?phone='.esc_html($realtor_details['realtor_mobile']).'&text='.esc_html__('Hello I\'m interested in ','wpresidence').'['.get_the_title($prop_id).'] '.get_permalink($prop_id);
?>

    <div class="agent-listing-img-wrapper" data-link="<?php print esc_attr($realtor_details['link']); ?>">
            <div class="agentpict" style="background-image:url(<?php echo esc_url($realtor_details['agent_face_img']); ?>)"> </div>
             <a href="<?php echo esc_url($realtor_details['link']);?>"><?php echo esc_html($realtor_details['realtor_name']);?></a>
    </div>


    <div class="mobile_agent_area_details_wrapper">
        <?php
        if ($realtor_details['email']!='') {
            print '<div class="agent_detail agent_email_class"><a href="#agent_contact_name"><i class="far fa-envelope"></i></a></div>';
        }

        if ($realtor_details['realtor_mobile']!='') {
            print '<div class="agent_detail agent_phone_class"><a href="tel:'.esc_html($realtor_details['realtor_mobile']).'"><i class="fas fa-phone"></i></a></div>';
        }

        if ($realtor_details['realtor_mobile']!='') {
            print '<div class="agent_detail agent_phone_class"><a href="'.esc_url($whatsup_mess).'"><i class="fab fa-whatsapp"></i></a></div>';
        }
        ?>
    </div>
</div>
<?php

?>
