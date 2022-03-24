<?php
$property_size          =   wpestate_get_converted_measure( $post->ID, 'property_size' );
$property_bedrooms      =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms     =   get_post_meta($post->ID,'property_bathrooms',true);
$property_rooms         =   get_post_meta($post->ID,'property_rooms',true);
$prop_id                =   $post->ID;  
?>



<div class="property_listing_details6_grid_view">
    <?php
    
    if($property_rooms!='' && $property_rooms!=0  ){ ?>
        <div class="inforoom_unit_type6">
            <?php include (locate_template('templates/svg_icons/single_rooms.html'))?>
            <?php echo esc_html($property_rooms).' '.esc_html__('Rooms','wpresidence'); ?>
        </div>
    <?php }
        
    if($property_bedrooms!='' && $property_bedrooms!=0){ ?>
        <div class="inforoom_unit_type6">
            <?php include (locate_template('templates/svg_icons/single_bedrooms.html'))?>

            <?php echo esc_html($property_bedrooms).' '.esc_html__('Beds','wpresidence');?> 
        </div>
    <?php 
    }

    if($property_bathrooms!=''&& $property_bathrooms!=0 ){?>
        <div class="inforoom_unit_type6">
            <?php include (locate_template('templates/svg_icons/single_bath.html'))?>
            
            <?php echo esc_html($property_bathrooms).' '.esc_html__('Baths','wpresidence');?> 
        </div>
    <?php }

    if($property_size!=''&& $property_size!=0 ){ ?>
        <div class="inforoom_unit_type6">
            <?php include (locate_template('templates/svg_icons/single_floor_plan.html'))?>
            <?php echo trim($property_size); //escaped above ?> 
        </div>
    <?php
    }

    ?>
</div>

