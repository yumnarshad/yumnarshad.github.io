<?php
$property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
//$property_rooms     =   get_post_meta($post->ID,'property_rooms',true);
$property_bedrooms  =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms  =   get_post_meta($post->ID,'property_bathrooms',true);

$prop_id            =   $post->ID;
?>

<div class="property_listing_details">
    <?php

        if($property_bedrooms!=''   && $property_bedrooms!=0 ){
            print '<div class="inforoom_unit_type3">';
            include (locate_template('templates/svg_icons/property_type3_bed.html'));
            print esc_html($property_bedrooms).' '.esc_html__('Beds','wpresidence').'</div>';
        }



        if($property_bathrooms!=''   && $property_bathrooms!=0 ){
            print '<div class="infobath_unit_type3">';
            include (locate_template('templates/svg_icons/property_type3_bath.html'));
            print esc_html($property_bathrooms).' '.esc_html__('Baths','wpresidence').'</div>';
        }


        if($property_size!=''   && $property_size!=0){
            print ' <div class="infosize_unit_type3">';
            include (locate_template('templates/svg_icons/property_type3_size.html'));
            print trim($property_size).'</div>';//escaped above
        }

    ?>
</div>
