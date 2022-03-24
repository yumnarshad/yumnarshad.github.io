<?php
/**
* CHeck if category should show morgage
*
* @since    3.0.3
*
*/
if( !function_exists('wpestate_check_category_for_morgage') ):
function wpestate_check_category_for_morgage($post_id){
  $show_morgage_calculator= wpresidence_get_option('wp_estate_show_morg_calculator','');
  $wp_estate_excludeshow_morg_calculator= wpresidence_get_option('wp_estate_excludeshow_morg_calculator','');



  if($show_morgage_calculator==='yes'){
      if( is_array($wp_estate_excludeshow_morg_calculator) && !empty($wp_estate_excludeshow_morg_calculator) ):
          $result=array();
          $terms_category=get_the_terms($post_id,    'property_category');
          $terms_action_category=get_the_terms($post_id,    'property_action_category');
          if($terms_category!==false  ){
            $result = array_merge($result, $terms_category);
          }
          if($terms_action_category!==false  ){
              $result = array_merge($result, $terms_action_category);
          }


            foreach ($result as $key => $term) {
              $temp=(array) $term;
              $term_id=intval($temp['term_id']);
                if( in_array($term_id, $wp_estate_excludeshow_morg_calculator ) ){
                   return 'no';
                }
            }

      endif;
  }

  return $show_morgage_calculator;
}

endif;





/**
* Slider data
*
* @since    3.0.3
*
*/
if( !function_exists('wpestate_slider_enable_maps') ):
function wpestate_slider_enable_maps($header_type,$global_header_type){

    global $post;
    $return = '';

    $show_map_on_property           =   esc_html ( wpresidence_get_option('wp_estate_show_map_prop_page2','') );

    if($show_map_on_property==='no'){
      return;
    }


    if ( $header_type == 0 ){ // global
        if ($global_header_type != 4){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.intval($post->ID).'" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';

                $return.=' <div id="slider_enable_map" data-placement="bottom" data-original-title="'. esc_attr__('Map','wpresidence').'"> <i class="fas fa-map-marker-alt"></i> </div>';

                
                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    $return.= '<div id="slider_enable_street" class="'.wpresidence_return_class_leaflet().'" data-placement="bottom" data-original-title="'.esc_attr__('Street View','wpresidence').'"> <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street='';
                }

                $return.='
                <div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_attr__('Image Gallery','wpresidence').'" class="slideron '.esc_attr($no_street).'"> <i class="far fa-image"></i></div>

                <div id="gmapzoomplus"  class="smallslidecontrol"><i class="fas fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol"><i class="fas fa-minus"></i></div>
                '.wpestate_show_poi_onmap().'
                <div id="googleMapSlider"'.trim($property_add_on).' >
                </div>';

        }
    }else{
        if($header_type!=5){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.intval($post->ID).'" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';
                $return                     .=  '<div id="slider_enable_map" data-placement="bottom" data-original-title="'.esc_attr__('Map','wpresidence').'"><i class="fas fa-map-marker-alt"></i></div>';

                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    $return     .=  '  <div id="slider_enable_street" class="'.wpresidence_return_class_leaflet().'"  data-placement="bottom" data-original-title="'.esc_attr__('Street View','wpresidence').'" > <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street  =   '';
                }
                $return .= '<div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_attr__('Image Gallery','wpresidence').'" class="slideron '.esc_attr($no_street).'"> <i class="far fa-image"></i>         </div>

                <div id="gmapzoomplus"  class="smallslidecontrol" ><i class="fas fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol" ><i class="fas fa-minus"></i></div>
                '.wpestate_show_poi_onmap().'
                <div id="googleMapSlider" '.trim($property_add_on).' >
                </div>';

        }
    }

    return $return;
}
endif;




/**
* terms
*
* @since    3.0.3
*
*/


if( !function_exists('wpestate_return_first_term') ):
function wpestate_return_first_term($terms,$taxonomy){

    $terms_array=explode(",",$terms);

    if(isset($terms_array[0]) && $terms_array[0]!=''){
        $term = get_term_by('id',$terms_array[0],$taxonomy);
        return $term->name;
    }else{
        return 'all';
    }
}

endif;





/**
* Filter Bar
*
* @since    3.0.3
*
*/



if( !function_exists('wpestate_filter_bar') ):
function wpestate_filter_bar($filter_data){
    $return_string='';
    ob_start();
    $is_shortcode='yes';

    include( locate_template('templates/property_list_filters.php') );
    $filters = ob_get_contents();
    ob_end_clean();

    $return_string.=$filters;
    return $return_string;
}
endif;


/**
*
* add global details to transient name
*
*@since    3.0.7
*
*/
if( !function_exists('wpestate_add_global_details_transient') ):
function wpestate_add_global_details_transient($transient_name){
  if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
      $transient_name.='_'. ICL_LANGUAGE_CODE;
  }

  if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
      $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
  }

  if(isset($_COOKIE['my_measure_unit'])){
      $transient_name.= $_COOKIE['my_measure_unit'];
  }
  return   $transient_name;
}
endif;




/**
*
* return what type of property card
*
*@since    3.0.3
*
*/

if( !function_exists('wpestate_return_property_card_type') ):
function wpestate_return_property_card_type($attributes){
  $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
  $property_card_type_string  =   '';

  if(isset( $attributes['card_version']) && is_numeric( $attributes['card_version']) ){
        $property_card_type  =  intval($attributes['card_version']);
  }

  if($property_card_type==0){
      $property_card_type_string='';
  }else{
      $property_card_type_string='_type'.$property_card_type;
  }

  return $property_card_type_string;

}
endif;









///////////////////////////////////////////////////////////////////////////////////////////
// floor plans
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('estate_floor_plan') ):
    function estate_floor_plan($post_id,$is_print=0,$wpestate_prop_all_details=''){

        $is_print_class='';
        if($is_print==1){
            $is_print_class=' floor_print_class ';
        }

        $unit               = wpestate_get_meaurement_unit_formated( );

        if($wpestate_prop_all_details==''){
            $plan_title_array           = get_post_meta($post_id, 'plan_title', true);
            $plan_desc_array            = get_post_meta($post_id, 'plan_description', true) ;
            $plan_image_array           = get_post_meta($post_id, 'plan_image', true) ;
            $plan_size_array            = get_post_meta($post_id, 'plan_size', true) ;
            $plan_image_attach_array    = get_post_meta($post_id, 'plan_image_attach', true) ;
            $plan_rooms_array           = get_post_meta($post_id, 'plan_rooms', true) ;
            $plan_bath_array            = get_post_meta($post_id, 'plan_bath', true);
            $plan_price_array           = get_post_meta($post_id, 'plan_price', true) ;
        }else{
            $plan_title_array           = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_title'));
            $plan_desc_array            = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_description'));
            $plan_image_array           = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_image'));
            $plan_size_array            = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_size'));
            $plan_image_attach_array    = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_image_attach'));
            $plan_rooms_array           = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_rooms'));
            $plan_bath_array            = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_bath'));
            $plan_price_array           = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_price'));
        }


        $wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        global $lightbox;
        $lightbox                   =   '';
        $show= ' style="display:block"; ';
        $counter=0;


        if (is_array($plan_title_array)){
            foreach ($plan_title_array as $key=> $plan_name) {

                $counter++;
                if ( isset($plan_desc_array[$key])){
                    $plan_desc=$plan_desc_array[$key];
                }else{
                    $plan_desc='';
                }

                if ( isset($plan_image_attach_array[$key])){
                    $plan_image_attach=$plan_image_attach_array[$key];
                }else{
                    $plan_image_attach='';
                }

                if ( isset($plan_image_array[$key])){
                    $plan_img=$plan_image_array[$key];
                }else{
                    $plan_img='';
                }

                if ( isset($plan_size_array[$key]) && $plan_size_array[$key]!=''){
                    $plan_size='<span class="bold_detail">'.esc_html__('size:','wpresidence').'</span> '.wpestate_convert_measure($plan_size_array[$key]).' '.$unit;
                }else{
                    $plan_size='';
                }

                if ( isset($plan_rooms_array[$key]) && $plan_rooms_array[$key]!=''){
                    $plan_rooms= '<span class="bold_detail">'.esc_html__('rooms: ','wpresidence').'</span> '.$plan_rooms_array[$key];
                }else{
                    $plan_rooms='';
                }

                if ( isset($plan_bath_array[$key]) && $plan_bath_array[$key]!=''){
                    $plan_bath='<span class="bold_detail">'.esc_html__('baths:','wpresidence').'</span> '.$plan_bath_array[$key];
                }else{
                    $plan_bath='';
                }
                $price='';
                if ( isset($plan_price_array[$key]) && $plan_price_array[$key]!=''){
                    $plan_price=$plan_price_array[$key];
                }else{
                    $plan_price='';
                }
                $full_img           = wp_get_attachment_image_src($plan_image_attach, 'full');
                $full_img_path      ='';
                if($full_img){
                  $full_img_path=$full_img[0];
                }

                print '
                <div class="front_plan_row '.esc_attr($is_print_class).'">
                    <div class="floor_title">'.esc_html($plan_name).'</div>
                    <div class="floor_details">'.trim($plan_size).'</div>
                    <div class="floor_details">'.trim($plan_rooms).'</div>
                    <div class="floor_details">'.trim($plan_bath).'</div>
                    <div class="floor_details floor_price_details">';
                        if($plan_price!=''){
                            print '<span class="bold_detail">'. esc_html__('price: ','wpresidence').'</span> '.wpestate_show_price_floor($plan_price,$wpestate_currency,$where_currency,1);
                        }
                        print'</div>
                </div>
                <div class="front_plan_row_image '.esc_attr($is_print_class).'"   '.trim($show).'>
                    <div class="floor_image">
                        <a href="'.esc_url($full_img_path).'" rel="prettyPhoto" title="'.esc_attr($plan_desc).'"><img class="lightbox_trigger_floor" data-slider-no="'.$counter.'" src="'.esc_url($full_img_path).'"  alt="'.esc_attr($plan_name).'"></a>
                    </div>
                    <div class="floor_description">'.esc_html($plan_desc).'</div>
                </div>';
                $show='';


                $lightbox.='<div class="item" href="#'.$counter.'"  >
                                <div class="itemimage">
                                    <img src="'.esc_url($full_img_path).'" alt="'.esc_html($plan_name).'">
                                </div>

                                <div class="lightbox_floor_details">
                                    <div class="floor_title">'.esc_html($plan_name).'</div>
                                    <div class="floor_light_desc">'.esc_html($plan_desc).'</div>
                                    <div class="floor_details">'.trim($plan_size).'</div>
                                    <div class="floor_details">'.trim($plan_rooms).'</div>
                                    <div class="floor_details">'.trim($plan_bath).'</div>
                                    <div class="floor_details">';
                                    if($plan_price!=''){
                                        $lightbox.= '<span class="bold_detail">'. esc_html__('price: ','wpresidence').'</span> '.wpestate_show_price_floor($plan_price,$wpestate_currency,$where_currency,1);
                                    }
                                    $lightbox.='</div>
                                </div>
                        </div>';


            }


         include( locate_template('templates/floorplans_gallery.php') );
        }
    }
endif;





///////////////////////////////////////////////////////////////////////////////////////////
// listing video
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_listing_video') ):
function wpestate_listing_video($post_id,$wpestate_prop_all_details=''){
    $full_img_path='';
    if($wpestate_prop_all_details==''){
        $full_img_path  = get_post_meta($post_id, 'property_custom_video', true);
        $video_id           =   esc_html( get_post_meta($post_id, 'embed_video_id', true) );
        $video_type         =   esc_html( get_post_meta($post_id, 'embed_video_type', true) );
    }else{
        $full_img_path      =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'property_custom_video') );
        $video_id           =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'embed_video_id') );
        $video_type         =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'embed_video_type') );
    }

    if($full_img_path==''){
        $thumb_id           =   get_post_thumbnail_id($post_id);
        $full_img           =   wp_get_attachment_image_src( $thumb_id, 'listing_full_slider_1' );
        if(isset($full_img[0])){
            $full_img_path      =   $full_img[0];
        }
    }


    $video_link         =   '';
    $protocol           =   is_ssl() ? 'https' : 'http';
    if($video_type=='vimeo'){
        $video_link .=  $protocol.'://player.vimeo.com/video/' . $video_id . '?api=1&amp;player_id=player_1';
    }else{
        $video_link .=  $protocol.'://www.youtube.com/embed/' . $video_id  . '?wmode=transparent&amp;rel=0';
    }
    return '<div class="property_video_wrapper" ><div id="property_video_wrapper_player"></div><a href="'.esc_url($video_link).'"  data-autoplay="true" data-vbtype="video" class="venobox"><img  src="'.esc_url($full_img_path).'"  alt="'.esc_html__('video image','wpresidence').'" /></a></div>';

}
endif;
///////////////////////////////////////////////////////////////////////////////////////////
// List features and ammenities
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_build_terms_array') ):
    function wpestate_build_terms_array(){
        $parsed_features = wpestate_request_transient_cache( 'wpestate_get_features_array' );
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            $parsed_features=false;
        }
            if($parsed_features===false){

                $parsed_features=array();
                $terms = get_terms( array(
                    'taxonomy' => 'property_features',
                    'hide_empty' => false,
                    'parent'=> 0

                ));


                foreach($terms as $key=>$term){
                    $temp_array=array();
                    $child_terms = get_terms( array(
                        'taxonomy' => 'property_features',
                        'hide_empty' => false,
                        'parent'=> $term->term_id
                    ));

                    $children=array();
                    if(is_array($child_terms)){
                        foreach($child_terms as $child_key=>$child_term){
                            $children[]=$child_term->name;
                        }
                    }

                    $temp_array['name']=$term->name;
                    $temp_array['childs']=$children;

                    $parsed_features[]=$temp_array;
                }
                if ( !defined( 'ICL_LANGUAGE_CODE' ) ) {
                    wpestate_set_transient_cache('wpestate_get_features_array',$parsed_features,60*60*4);
                }
            }

            return $parsed_features;
    }
endif;




if( !function_exists('estate_listing_features') ):
function estate_listing_features($post_id,$col=3,$is_print=0){

    $property_features  =   get_the_terms($post_id,'property_features');
    $show_no_features   =   esc_html ( wpresidence_get_option('wp_estate_show_no_features','') );
    $parsed_features    =   wpestate_build_terms_array();
    $multi_return_string=   '';
    $single_return_string=  '';

    if(is_array($parsed_features)){

            foreach($parsed_features as $key => $item){

                if( count( $item['childs']) >0 ){

                    $multi_return_string_part=  '<div class="listing_detail col-md-12 feature_block_'.$item['name'].' ">';
                    $multi_return_string_part.=  '<div class="feature_chapter_name col-md-12">'.$item['name'].'</div>';

                    $multi_return_string_part_check='';
                    if( is_array($item['childs']) ){
                        foreach($item['childs'] as $key_ch=>$child){
                            $temp   = wpestate_display_feature($show_no_features,$child,$post_id,$property_features,$is_print,$col);
                            $multi_return_string_part .=$temp;
                            $multi_return_string_part_check.=$temp;
                        }
                    }
                    $multi_return_string_part.=  '</div>';

                    if($multi_return_string_part_check!=''){
                        $multi_return_string.=$multi_return_string_part;
                    }


                }else{
                    $single_return_string .= wpestate_display_feature($show_no_features,$item['name'],$post_id,$property_features,$is_print,$col);
                }

            }

        }
        if($single_return_string!=''){
            $multi_return_string.='<div class="listing_detail col-md-12 feature_block_others "><div class="feature_chapter_name col-md-12">'.esc_html__('Other Features','wpresidence').'</div>'.$single_return_string.'</div>';
        }
        return $multi_return_string;



}
endif; // end   estate_listing_features


if(!function_exists('wpestate_display_feature')):
    function wpestate_display_feature($show_no_features,$term_name,$post_id,$property_features,$is_print,$col=3){

        $return_string  =   '';
        $term_object    =   get_term_by('name',$term_name,'property_features');
        if( isset($term_object->term_id)):
            $term_meta      =   get_option( "taxonomy_$term_object->term_id");
            $term_icon      =   '';
            $colmd          =   wpestat_get_content_comuns($col);
            $term_icon_wp='';

            if($term_meta!=''){
                $term_icon =  '<img class="property_features_svg_icon" src="'.$term_meta['category_featured_image'].'" >';
              

                
                if( $term_meta['category_featured_image'] !='' ){
                      $term_icon_wp = wp_remote_get($term_meta['category_featured_image']);
                }
                
                if( is_wp_error( $term_icon_wp ) ) {
                    $term_icon='';
                }else{
                    $term_icon=wp_remote_retrieve_body($term_icon_wp);
                }
            }

            if($show_no_features!='no' && $is_print==0){
                if ( is_array($property_features) && array_search($term_name, array_column($property_features, 'name')) !== FALSE ) {
                    if($term_icon=='')$term_icon='<i class="fas fa-check checkon"></i>';

                    $return_string .= '<div class="listing_detail col-md-'.$colmd.'">'.$term_icon. trim($term_name) . '</div>';
                }else{
                    if($term_icon=='')$term_icon='<i class="fas fa-times"></i>';
                    $return_string  .=  '<div class="listing_detail not_present col-md-'.$colmd.'">'.$term_icon. trim($term_name). '</div>';
                }
            }else{
                if ( is_array($property_features) &&  array_search($term_name, array_column($property_features, 'name')) !== FALSE ) {
                    if($term_icon=='') $term_icon='<i class="fas fa-check checkon"></i>';
                    $return_string .=  '<div class="listing_detail col-md-'.$colmd.'">'.$term_icon. trim($term_name) .'</div>';
                }
            }

            return $return_string;
        endif;
    }
endif;









if( !function_exists('estate_listing_content') ):
function estate_listing_content($post_id){
    $content='';
    $args= array(
        'post_type'         => 'estate_property',
        'post_status'       => 'publish',
        'p' => $post_id
    );
    $the_query = new WP_Query( $args);


       while ($the_query->have_posts()) :
            $the_query->the_post();

            $content= get_the_content();
        endwhile;

        wp_reset_postdata();

   // $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = wpautop($content, false);
   $content=apply_filters( 'the_content', $content );
    $args = array(  'post_mime_type'    => 'application/pdf',
                'post_type'         => 'attachment',
                'numberposts'       => -1,
                'post_status'       => null,
                'post_parent'       => $post_id
        );

    $attachments = get_posts($args);

    if ($attachments) {

        $content.= '<div class="download_docs">'.esc_html__('Documents','wpresidence').'</div>';
        foreach ( $attachments as $attachment ) {
            $content.= '<div class="document_down"><a href="'. esc_url(wp_get_attachment_url($attachment->ID)).'" target="_blank">'.$attachment->post_title.'<i class="fas fa-download"></i></a></div>';
        }
    }

    wp_reset_postdata();


    return $content;

}
endif;




if( !function_exists('estate_listing_address') ):
function estate_listing_address($post_id,$wpestate_prop_all_details='',$columns=''){


    $property_city      = get_the_term_list($post_id, 'property_city', '', ', ', '');
    $property_area      = get_the_term_list($post_id, 'property_area', '', ', ', '');
    $property_county    = get_the_term_list($post_id, 'property_county_state', '', ', ', '') ;

    $colmd              = intval( wpresidence_get_option('wp_estate_details_colum', '') );

    if($wpestate_prop_all_details!=''){
       $property_address   = esc_html( wpestate_return_custom_field( $wpestate_prop_all_details, 'property_address') );
       $property_zip       = esc_html( wpestate_return_custom_field( $wpestate_prop_all_details, 'property_zip') );
       $property_country   = esc_html( wpestate_return_custom_field( $wpestate_prop_all_details, 'property_country') );

    }else{
        $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
        $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
        $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );
    }



    $colmd=wpestat_get_content_comuns($columns);

    $return_string='';

    if ($property_address != ''){
        $return_string.='<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Address','wpresidence').':</strong> ' . $property_address . '</div>';
    }
    if ($property_city != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('City','wpresidence').':</strong> ' .$property_city. '</div>';
    }
    if ($property_area != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Area','wpresidence').':</strong> ' .$property_area. '</div>';
    }
    if ($property_county != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('State/County','wpresidence').':</strong> ' . $property_county . '</div>';
    }
    if ($property_zip != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Zip','wpresidence').':</strong> ' . $property_zip . '</div>';
    }
    if ($property_country != '') {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Country','wpresidence').':</strong> ' . $property_country . '</div>';
    }

    $property_city      =   strip_tags (  get_the_term_list($post_id, 'property_city', '', ', ', '') );
    $url                =   urlencode($property_address.','.$property_city);
    $google_map_url     =   "http://maps.google.com/?q=".$url;

    $return_string.= ' <a href="'.esc_url($google_map_url).'" target="_blank" class="acc_google_maps">'.esc_html__('Open In Google Maps','wpresidence').'</a>';

    return  $return_string;
}
endif; // end   estate_listing_address



if( !function_exists('estate_listing_address_printing') ):
function estate_listing_address_printing($post_id){

    $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      = strip_tags (  get_the_term_list($post_id, 'property_city', '', ', ', '') );
    $property_area      = strip_tags ( get_the_term_list($post_id, 'property_area', '', ', ', '') );
    $property_county    = strip_tags ( get_the_term_list($post_id, 'property_county_state', '', ', ', '')) ;
    //$property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );
    $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
    //$property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );

    $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );

    $return_string='';

    if ($property_address != ''){
        $return_string.='<div class="listing_detail col-md-4"><strong>'.esc_html__('Address','wpresidence').':</strong> ' . $property_address . '</div>';
    }
    if ($property_city != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('City','wpresidence').':</strong> ' .$property_city. '</div>';
    }
    if ($property_area != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Area','wpresidence').':</strong> ' .$property_area. '</div>';
    }
    if ($property_county != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('State/County','wpresidence').':  </strong> ' . $property_county . '</div>';
    }
   /* if ($property_state != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('State','wpresidence').':</strong> ' . $property_state . '</div>';
    }

    */
    if ($property_zip != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Zip','wpresidence').':</strong> ' . $property_zip . '</div>';
    }
    if ($property_country != '') {
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Country','wpresidence').':</strong> ' . $property_country . '</div>';
    }


    return  $return_string;
}
endif; // end   estate_listing_address

if( !function_exists('wpestat_get_content_comuns') ):
    function wpestat_get_content_comuns($columns){

        if($columns==''){ // not custom template
            $colmd              =   intval( wpresidence_get_option('wp_estate_details_colum', '') );
            if($colmd=='') {
                $colmd=4;
            }
        }else{
            $col_args=array(
                '1' => '12',
                '2' => '6',
                '3' => '4',
                '4' => '3',
                '5' => '2',
                '6'=>'2',
            );
            $colmd=$col_args[$columns];

        }
        return $colmd;

    }
endif;


if( !function_exists('estate_listing_details') ):
function estate_listing_details($post_id,$wpestate_prop_all_details='',$columns=''){

    $wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $measure_sys        =   esc_html ( wpresidence_get_option('wp_estate_measure_sys','') );
    $property_size      =   wpestate_get_converted_measure( $post_id, 'property_size',$wpestate_prop_all_details );
    $property_lot_size  =   wpestate_get_converted_measure( $post_id, 'property_lot_size',$wpestate_prop_all_details );

    $colmd=wpestat_get_content_comuns($columns);


    if($wpestate_prop_all_details==''){
        $property_rooms     = floatval ( get_post_meta($post_id, 'property_rooms', true) );
        $property_bedrooms  = floatval ( get_post_meta($post_id, 'property_bedrooms', true) );
        $property_bathrooms = floatval ( get_post_meta($post_id, 'property_bathrooms', true) );
        $price              = floatval ( get_post_meta($post_id, 'property_price', true) );
        $energy_index       = get_post_meta($post_id, 'energy_index', true) ;
        $energy_class       = get_post_meta($post_id, 'energy_class', true);
    }else{
        $property_rooms     = floatval (  wpestate_return_custom_field( $wpestate_prop_all_details,'property_rooms') );
        $property_bedrooms  = floatval (  wpestate_return_custom_field( $wpestate_prop_all_details,'property_bedrooms'));
        $property_bathrooms = floatval (  wpestate_return_custom_field( $wpestate_prop_all_details,'property_bathrooms') );
        $price              = floatval (  wpestate_return_custom_field( $wpestate_prop_all_details,'property_price') );
        $energy_index       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_index') ;
        $energy_class       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_class');
    }









    if ($price != 0) {
        $price =wpestate_show_price_from_all_details($wpestate_currency,$where_currency,1,$wpestate_prop_all_details);
    }else{
        $price='';
    }

    $return_string='';
    $return_string.='<div class="listing_detail col-md-'.$colmd.'" id="propertyid_display"><strong>'.esc_html__('Property Id ','wpresidence'). ':</strong> '.$post_id.'</div>';
    if ($price !='' ){
        $return_string.='<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Price','wpresidence'). ':</strong> '. $price.'</div>';
    }

    if ($property_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Size','wpresidence').':</strong> ' . $property_size . '</div>';
    }
    if ($property_lot_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Lot Size','wpresidence').':</strong> ' . $property_lot_size . '</div>';
    }
    if ($property_rooms != '' && $property_rooms != 0 ){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Rooms','wpresidence').':</strong> ' . $property_rooms . '</div>';
    }
    if ($property_bedrooms != ' '&& $property_bedrooms != 0 ){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Bedrooms','wpresidence').':</strong> ' . $property_bedrooms . '</div>';
    }
    if ($property_bathrooms != '' && $property_bathrooms != 0)    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Bathrooms','wpresidence').':</strong> ' . $property_bathrooms . '</div>';
    }

    // energy saving
    if ($energy_index != '')    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Energy index','wpresidence').':</strong> ' . $energy_index . ' kWh/m²a</div>';
    }
    if ($energy_class != '')    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Energy class','wpresidence').':</strong> ' . $energy_class . '</div>';
    }
    // ee end


    // Custom Fields
    $i=0;
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');

    if( !empty($custom_fields)){
        while($i< count($custom_fields) ){
            if($custom_fields[$i][0]!=''){
                $name   =   $custom_fields[$i][0];
                $prslig =   str_replace(' ','_',$name);
                $label  =   stripslashes($custom_fields[$i][1]);
                $type   =   $custom_fields[$i][2];
                $slug   =   wpestate_limit45(sanitize_title( $name ));
                $slug   =   sanitize_key($slug);

                $wpestate_submission_page_fields         =   wpresidence_get_option('wp_estate_submission_page_fields','');
                $value  =   esc_html( wpestate_return_custom_field( $wpestate_prop_all_details,$slug));
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_property_custom_'.$label, $label ) ;
                    $value     =   icl_translate('wpestate','wp_estate_property_custom_'.$value, $value ) ;
                }

                if( $value!='' && $value!= esc_html__('Not Available','wpresidence') ){
                   $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.trim($label).':</strong> ' .$value. '</div>';
                }
            }
            $i++;
        }
    }
    //END Custom Fields
    return $return_string;
}
endif; // end   estate_listing_details



if( !function_exists('wpestate_energy_save_features') ):
function wpestate_energy_save_features($post_id,$wpestate_prop_all_details=''){

        $energy_index = null;
	$energy_class = null;
	$return_string =  '';

        if($wpestate_prop_all_details!=''){
            $energy_index       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_index');
            $energy_class       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_class');
        }else{
            $energy_index       = get_post_meta($post_id, 'energy_index', true) ;
            $energy_class       = get_post_meta($post_id, 'energy_class', true) ;
        }



     //END Custom Fields

	$energy_class_array = array(
		array( 'value' => 'A+', 'from' => 0, 'to' => 14 ),
		array( 'value' => 'A', 'from' => 14, 'to' => 29 ),
		array( 'value' => 'B', 'from' => 29, 'to' => 58 ),
		array( 'value' => 'C', 'from' => 58, 'to' => 87 ),
		array( 'value' => 'D', 'from' => 87, 'to' => 116 ),
		array( 'value' => 'E', 'from' => 116, 'to' => 145 ),
		array( 'value' => 'F', 'from' => 145, 'to' => 175 ),
		array( 'value' => 'G', 'from' => 175, 'to' => 1000 ),
                array( 'value' => 'H', 'from' => 1000, 'to' => 2000 ),
	);
	 $default_energy_class = '';
	if ($energy_index != '')    {
		// getting class by index

		foreach( $energy_class_array as $single_row ){

			if( (int)$energy_index > $single_row['from'] && (int)$energy_index <= $single_row['to'] ){
				$default_energy_class = $single_row['value'];
			}
		}
    }


	if ($energy_class != '')    {

		if( $default_energy_class != $energy_class ){
			$default_energy_class = $energy_class;
		}

		if( $default_energy_class == '' ){
			$default_energy_class = $energy_class;
		}
		$out_msg_array = array();
		$message_pop = array( 'Aplus' => null, 'A' => null, 'B' => null, 'C' => null, 'D' => null, 'E' => null, 'F' => null,  'G' => null ,'H'=>null);



		switch( $default_energy_class ){
			case "A+":
				if( $energy_index ){
					$message_pop['Aplus'] = '<div class="indicator-energy" data-energyclass="A+">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' A+</div>';
				}else{
					$message_pop['Aplus'] = '<div class="indicator-energy" data-energyclass="A+">
								 '.esc_html__('Your energy class is ','wpresidence').' A+</div>';
				}
			break;
			case "A":
				if( $energy_index ){
					$message_pop['A'] = '<div class="indicator-energy" data-energyclass="A">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class ','wpresidence').' A</div>';
				}else{
					$message_pop['A'] = '<div class="indicator-energy" data-energyclass="A">
								 '.esc_html__('Your energy class is ','wpresidence').' A</div>';
				}
			break;
			case "B":
				if( $energy_index ){
					$message_pop['B'] = '<div class="indicator-energy" data-energyclass="B">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class ','wpresidence').' B</div>';
				}else{
					$message_pop['B'] = '<div class="indicator-energy" data-energyclass="B">
								 '.esc_html__('Your energy class is ','wpresidence').' B</div>';
				}
			break;
			case "C":
				if( $energy_index ){
					$message_pop['C'] = '<div class="indicator-energy" data-energyclass="C">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is','wpresidence').' C</div>';
				}else{
					$message_pop['C'] = '<div class="indicator-energy" data-energyclass="C">
								 '.esc_html__('Your energy class is','wpresidence').' C</div>';
				}
			break;
			case "D":
				if( $energy_index ){
					$message_pop['D'] = '<div class="indicator-energy" data-energyclass="D">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' D</div>';
				}else{
					$message_pop['D'] = '<div class="indicator-energy" data-energyclass="D">
								 '.esc_html__('Your energy class ','wpresidence').' D</div>';
				}
			break;
			case "E":
				if( $energy_index ){
					$message_pop['E'] = '<div class="indicator-energy" data-energyclass="E">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' E</div>';
				}else{
					$message_pop['E'] = '<div class="indicator-energy" data-energyclass="E">
								 '.esc_html__('Your energy class ','wpresidence').' E</div>';
				}
			break;
			case "F":
				if( $energy_index ){
					$message_pop['F'] = '<div class="indicator-energy" data-energyclass="F">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' F</div>';
				}else{
					$message_pop['F'] = '<div class="indicator-energy" data-energyclass="F">
								 '.esc_html__('Your energy class ','wpresidence').' F</div>';
				}
			break;
			case "G":
				if( $energy_index ){
					$message_pop['G'] = '<div class="indicator-energy" data-energyclass="G">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' G</div>';
				}else{
					$message_pop['G'] = '<div class="indicator-energy" data-energyclass="G">
								 '.esc_html__('Your energy class is ','wpresidence').' G</div>';
				}
                        break;
                        case "H":
				if( $energy_index ){
					$message_pop['H'] = '<div class="indicator-energy" data-energyclass="H">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' H</div>';
				}else{
					$message_pop['H'] = '<div class="indicator-energy" data-energyclass="H">
								 '.esc_html__('Your energy class is ','wpresidence').' H</div>';
				}
			break;
		}



        $return_string .=
		'
		<div class="listing_detail col-md-12">

			<div class="energy_class_container">
				<div class="col-xs-extra">
					<div class="row class-energy">
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['Aplus'].'
								<p class="energy-Aplus">A+</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['A'].'
								<p class="energy-A">A</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['B'].'
								<p class="energy-B">B</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['C'].'
								<p class="energy-C">C</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['D'].'
								<p class="energy-D">D</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['E'].'
								<p class="energy-E">E</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['F'].'
								<p class="energy-F">F</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								 '.$message_pop['G'].'
								<p class="energy-G">G</p>
							</div>
                                                        <div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['H'].'
								<p class="energy-H">H</p>
							</div>
					</div>
				</div>
			</div>
		</div>';
    }


    return $return_string;
}
endif; // end   energy save
?>
