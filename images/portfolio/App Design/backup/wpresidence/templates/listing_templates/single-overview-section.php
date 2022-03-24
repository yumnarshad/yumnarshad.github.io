<?php

$property_size          =   wpestate_get_converted_measure( $post->ID, 'property_size' );
$property_bedrooms      =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms     =   get_post_meta($post->ID,'property_bathrooms',true);
$property_rooms         =   get_post_meta($post->ID,'property_rooms',true);
$property_year          =   get_post_meta($post->ID,'property-year',true);
$property_garage        =   get_post_meta($post->ID,'property-garage',true);
?>

<div class="single-overview-section panel-group property-panel">
    <h4 class="panel-title" id=""><?php esc_html_e('Overview','wpresidence');?></h4>
    
    <ul class="overview_element">
        <li class="first_overview">
            <?php esc_html_e('Updated On:','wpresidence'); ?>
        </li>
        <li class="first_overview_date"><?php print get_the_modified_date('F j, Y'); ?></li>
        
    </ul>
    
    <?php if($property_bedrooms!='' && $property_bedrooms!=0) { ?>
        <ul class="overview_element">
            <li class="first_overview">
                <?php include (locate_template('templates/svg_icons/single_bedrooms.html'))?>
            </li>
            <li><?php print esc_html($property_bedrooms).' '.esc_html__('Bedrooms','wpresidence'); ?></li>

        </ul>
    <?php } ?>
    
    
    <?php if($property_bathrooms!='' && $property_bathrooms!=0) { ?>
        <ul class="overview_element">
            <li class="first_overview">
               <?php include (locate_template('templates/svg_icons/single_bath.html'))?>
            </li>
            <li><?php print esc_html($property_bathrooms).' '.esc_html__('Bathrooms','wpresidence'); ?></li>
        </ul>
    <?php } ?>
    
    
    
    <?php if($property_garage!='' && $property_garage!=0) { ?>
        <ul class="overview_element">
            <li class="first_overview">
                <?php include (locate_template('templates/svg_icons/single_garage.html'))?>
            </li>
            <li><?php print esc_html($property_garage).' '.esc_html__('Garages','wpresidence'); ?></li>
        </ul>
    <?php } ?>
   
    
    <?php if($property_size!='' && $property_size!=0) { ?>
        <ul class="overview_element">
            <li class="first_overview">
                <?php include (locate_template('templates/svg_icons/single_floor_plan.html'))?>
            </li>
            <li><?php print trim($property_size); ?></li>
        </ul>
    <?php } ?>
    
    
    <?php if($property_year!='' ) { ?>
        <ul class="overview_element">
            <li class="first_overview">
                <?php include (locate_template('templates/svg_icons/single_calendar.html'))?>
            </li>
            <li><?php print esc_html__('Year Built:','wpresidence').' '.$property_year; ?></li>
        </ul>
    <?php } ?>

</div>