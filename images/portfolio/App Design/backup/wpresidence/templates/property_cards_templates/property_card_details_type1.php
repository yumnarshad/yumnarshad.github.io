<div class="property_details_type1_wrapper">
    <?php
    $property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
    $property_rooms     =   get_post_meta($post->ID,'property_rooms',true);
    $property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
    $prop_id            =   $post->ID;

    if($property_rooms!=''  && $property_rooms!=0){
        $string=sprintf( ( _n( '<span class="property_details_type1_value">%d</span> Room', '<span class="property_details_type1_value">%d</span> Rooms', $property_rooms, 'wpresidence'  ) ), $property_rooms );
        print ' <span class="property_details_type1_rooms">'.$string.'</span>';
    }

    if($property_bathrooms!=''  && $property_bathrooms!=0){
        $string=sprintf( ( _n( '<span class="property_details_type1_value">%d</span> Bath', '<span class="property_details_type1_value">%d</span> Baths', $property_bathrooms, 'wpresidence'  ) ), $property_bathrooms );
        print '<span class="property_details_type1_baths"><span class="property_details_type1_value">'.$string.'</span>';
    }


    if($prop_id !=''  && $prop_id!=0 ){
        print ' <span class="property_details_type1_id">'.__('ID','wpresidence').' <span class="property_details_type1_value">'.$prop_id.'</span></span>';
    }

    if($property_size!=''  && $property_size!=0 ){
        print ' <span class="property_details_type1_size"><span class="property_details_type1_value">'.$property_size.'</span>';
    }

    ?>

</div>
