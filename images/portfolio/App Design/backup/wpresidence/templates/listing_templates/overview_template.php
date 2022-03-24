<?php
 $property_address =esc_html( get_post_meta($post->ID, 'property_address', true) );

$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.intval($userID);
$curent_fav             =   get_option($user_option);

$favorite_class     =   'isnotfavorite';
$fav_mes            =   esc_html__('add to favorites','wpresidence');
$fav_icon           =   'far fa-heart';
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'isfavorite';
    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
    $fav_icon           ='fas fa-heart';
    }
}




$property_address_show='';

if($property_address!=''){
    $property_address_show.= esc_html($property_address);
}

if($property_city!=''){
    if($property_address!=''){
        $property_address_show.= ', ';
    }
    $property_address_show.= wp_kses_post($property_city);
}

if($property_area!=''){
    if($property_address!='' || $property_city!=''){
        $property_address_show.= ', ';
    }
    $property_address_show.= wp_kses_post($property_area);
}
    $email_link     =   'subject='.urlencode ( get_the_title() ) .'&body='. urlencode( esc_url(get_permalink()));






?>
<div class="notice_area col-md-12 ">




    <?php  include(locate_template('templates/listing_templates/title_section.php')); ?>

    <div class="property_categs">
        <i class="fas fa-map-marker-alt"></i>
        <?php print wp_kses_post($property_address_show); ?>
    </div>


        <div class="prop_social">


            <?php   print wpestate_share_unit_desing($post->ID,1);?>
            <div class="title_share share_list single_property_action"  data-original-title="<?php esc_attr_e('share this page','wpresidence');?>" >
                <i class="fas fa-share-alt"></i><?php esc_html_e('Share','wpresidence'); ?>
            </div>

            <div id="add_favorites" class="title_share single_property_action <?php echo esc_attr($favorite_class);?>" data-postid="<?php echo intval($post->ID);?>" data-original-title="<?php echo esc_attr($fav_mes);?>" >
                <i class="<?php echo esc_attr($fav_icon); ?>"></i><?php esc_html_e('Favorite','wpresidence'); ?>
            </div>

            <div id="print_page" class="title_share single_property_action"   data-propid="<?php echo intval($post->ID);?>" data-original-title="<?php esc_attr_e('print page','wpresidence');?>" >
                <i class="fas fa-print"></i><?php esc_html_e('Print','wpresidence'); ?>
            </div>
        </div>
</div>
