<?php
$property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
$property_bedrooms  =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
$prop_id            =   $post->ID;  
?>
<div class="property_unit_type5_content_details_second_row">
    <?php 
        if($property_bedrooms!='' && $property_bedrooms!=0 ){
            print '<div class="inforoom_unit_type5">'.esc_html($property_bedrooms).' '.esc_html__('BD','wpresidence').'</div>';
        }

        if($property_bathrooms!='' && $property_bathrooms!=0 ){
            print '<div class="inforoom_unit_type5">'.esc_html($property_bathrooms).' '.esc_html__('BA','wpresidence').'<span></span></div>';
        }

        if($property_size!='' && $property_size!=0){
            print '<div class="inforoom_unit_type5">'.trim($property_size).'</div>';//escaped above
        }

    ?>
</div>
        
