<div class="property_listing_details">
    <?php
    $property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
    $property_bedrooms  =   get_post_meta($post->ID,'property_bedrooms',true);
    $property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
    $garage_no          =   get_post_meta($post->ID, 'property-garage', true) ;
    $prop_id            =   $post->ID;  
    ?>
    <?php 
        if($property_bedrooms!=''  && $property_bedrooms!=0 ){
            print ' <span class="inforoom_unit_type2">'.esc_html($property_bedrooms).'</span>';
        }

        if($property_bathrooms!=''  && $property_bathrooms!=0 ){
            print '<span class="infobath_unit_type2">'.esc_html($property_bathrooms).'</span>';
        }
        if ($garage_no != ''  && $garage_no!=0 ) {
            print ' <span class="infogarage_unit_type2">'.esc_html($garage_no).'</span>';
        }
        if($property_size!=''  && $property_size!=0){
            print ' <span class="infosize_unit_type2">'.$property_size.'</span>';//escaped above
        }

      ?>           
</div>