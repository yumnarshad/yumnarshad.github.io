<?php

/*
*
* Full width slider
*
*
*/



if( !function_exists('wpestate_listing_full_width_slider') ):
function wpestate_listing_full_width_slider($prop_id){
    $background_image_style='';
    $counter_lightbox=0;
    if( has_post_thumbnail($prop_id) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
        $thumb              =   wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');
    }

    $items = '<div class="item active">
            <div class="propery_listing_main_image lightbox_trigger" style="background-image:url('.$full_prty[0].')" data-slider-no="'.$counter_lightbox.'"></div>
            <div class="carousel-caption">
            </div>
        </div>';
    $indicator = '<li data-target="#carousel-property-page-header" data-slide-to="0" class="active"><div class="carousel-property-page-header-overalay"></div><img src="'.$thumb[0].'"></li>';

    $post_attachments   =   wpestate_return_property_images($prop_id);
    $slides='';

    $no_slides = 0;
    foreach ($post_attachments as $attachment) {
        $no_slides++;
        $counter_lightbox++;
        $preview    =   wp_get_attachment_image_src($attachment->ID, 'full');
        $thumb      =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $indicator .= '<li data-target="#carousel-property-page-header" data-slide-to="'.$no_slides.'" class=""><div class="carousel-property-page-header-overalay"></div><img src="'.$thumb[0].'"></li>';
        $items .= '<div class="item ">
            <div class="propery_listing_main_image lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">
            </div>
        </div>';
    }



    print '<div id="carousel-property-page-header" class="carousel slide propery_listing_main_image" data-interval="false" data-ride="carousel">



    <div class="carousel-inner" role="listbox">
        '.$items.'
    </div>

    <div class="carousel-indicators-wrapper-header-prop">
        <ol class="carousel-indicators">
            '.$indicator.'
        </ol>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-property-page-header" role="button" data-slide="prev">
       <i class="demo-icon icon-left-open-big"></i>
    </a>
    <a class="right carousel-control" href="#carousel-property-page-header" role="button" data-slide="next">
       <i class="demo-icon icon-right-open-big"></i>
    </a>

    </div>';

}
endif;
/*
*
* Multi image slider
*
*
*/

if( !function_exists('wpestate_multi_image_slider') ):
function wpestate_multi_image_slider($prop_id,$display_slides=3){

    wp_enqueue_script('slick.min');
    $post_attachments   =   wpestate_return_property_images($prop_id);
    $counter_lightbox   =   0;
    $slides             =   '';
    $items              =   '';
    $no_slides          =   0;
    $attach_src        =    '';
    $post_thumbnail_id=0;
    if( has_post_thumbnail($prop_id) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
        $attach_src         =   $full_prty[0];

    }


    $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$attach_src.')" ></div>
            <div class="carousel-caption">';

    if ( has_excerpt( $post_thumbnail_id ) ) {
                   $caption=get_the_excerpt($post_thumbnail_id);
                } else {
                    $caption='';
                }

                if($caption!=''){
                    $items .= '<div class="carousel-caption_underlay"></div>
                    <div class="carousel_caption_text">'.$caption.'</div>';
                }
    $items .= '
            </div>
        </div>';

    foreach ($post_attachments as $attachment) {
        $no_slides++;

        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $preview            =   wp_get_attachment_image_src($attachment->ID, 'full');
        $thumb              =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $attachment_meta    =   wp_get_attachment($post_thumbnail_id);
        $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">';
            if($attachment->post_excerpt !=''){
                $items .='<div class="carousel-caption_underlay"></div>
                <div class="carousel_caption_text">'.$attachment->post_excerpt.'</div>';
            }
        $items .='
            </div>
        </div>';
    }

    echo '<div class="property_multi_image_slider" data-auto="0">'.$items.'</div>';

    print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_enable_slick_theme_slider('.$display_slides.');
                });
                //]]>
            </script>';
}
endif;


/*
*
* Horizontal Slider
*
*
*/

if( !function_exists('wpestate_vertical_slider') ):
function wpestate_vertical_slider($prop_id,$slider_size="full"){

  $slider_components          =   wpestate_slider_slide_generation($prop_id,$slider_size);
  $video_id       =   '';
  $video_thumb    =   '';
  $video_alone    =   0;
  $full_img       =   '';

  $wp_estate_kind_of_map  = esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
  if($wp_estate_kind_of_map==2){
      $wp_estate_kind_of_map='open_street';
  }
  $wp_estate_kind_of_map_class= $wp_estate_kind_of_map.'_carousel';
      print '<div id="carousel-listing" class=" slide post-carusel carouselvertical  '.esc_attr($wp_estate_kind_of_map_class).'" data-touch="true" data-interval="false">';
      print wpestate_return_property_status($prop_id,'verticalstatus');
      $header_type                =   get_post_meta ( $prop_id, 'header_type', true);
      $global_header_type         =   esc_html ( wpresidence_get_option('wp_estate_header_type_property_page','') );
      print wpestate_slider_enable_maps($header_type,$global_header_type);
      print'
      <!-- Wrapper for slides -->
      <div class="carousel-inner owl-carousel owl-theme carouselvertical" id="property_slider_carousel">
       '.trim($slider_components['slides']).'
      </div>

      <!-- Indicators -->
      <ol  id="carousel-indicators-vertical" class="carousel-indicators-vertical">
         '.trim($slider_components['indicators']).'
      </ol>

      <div class="caption-wrapper vertical-wrapper">
          <div class="vertical-wrapper-back"></div>
          '.trim($slider_components['captions']).'
      </div>

  </div>';

  print '
  <script type="text/javascript">
      //<![CDATA[
      jQuery(document).ready(function(){
         wpestate_property_slider();
      });
      //]]>
  </script>';

}
endif;






/*
*
* Horizontal Slider
*
*
*/

if( !function_exists('wpestate_horizontal_slider') ):
function wpestate_horizontal_slider($prop_id,$slider_size="full"){

    $post_attachments           =   wpestate_return_property_images($prop_id);
    $slider_components          =   wpestate_slider_slide_generation($prop_id,$slider_size);
    $wp_estate_kind_of_map      =   esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
    if($wp_estate_kind_of_map==2){
        $wp_estate_kind_of_map='open_street';
    }

    $wp_estate_kind_of_map_class=$wp_estate_kind_of_map.'_carousel';

    if ($post_attachments || has_post_thumbnail($prop_id) || get_post_meta($prop_id, 'embed_video_id', true)) {
        print '<div id="carousel-listing" class=" slide post-carusel  '.esc_attr($wp_estate_kind_of_map_class).'" data-interval="false">';
        print wpestate_return_property_status($prop_id,'horizontalstatus');

        $header_type                =   get_post_meta ( $prop_id, 'header_type', true);
        $global_header_type         =   esc_html ( wpresidence_get_option('wp_estate_header_type_property_page','') );

        print wpestate_slider_enable_maps($header_type,$global_header_type);

        print '
        <!-- Wrapper for slides -->
        <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
          '.trim($slider_components['slides']).'
        </div>

        <!-- Indicators -->
        <div class="carusel-back"></div>
        <ol class="carousel-indicators">
          '.trim($slider_components['indicators']).'
        </ol>

        <ol class="carousel-round-indicators">
            '.trim($slider_components['round_indicators']).'
        </ol>

        <div class="caption-wrapper">
          '. trim($slider_components['captions']).'
            <div class="caption_control"></div>
        </div>

        </div>';

        print '
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function(){
               wpestate_property_slider();
            });
            //]]>
        </script>';


    } // end if post_attachments

}
endif;

/*
*
* Classic Slider
*
*
*/

if( !function_exists('wpestate_classic_slider') ):
function wpestate_classic_slider($prop_id,$slider_size="full"){

    $post_attachments   =   wpestate_return_property_images($prop_id);
  $slider_components          =   wpestate_slider_slide_generation($prop_id,$slider_size,'yes');
  $wp_estate_kind_of_map  =   esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
  if($wp_estate_kind_of_map==2){
      $wp_estate_kind_of_map='open_street';
  }

  $wp_estate_kind_of_map_class=$wp_estate_kind_of_map.'_carousel';
  if ($post_attachments || has_post_thumbnail($prop_id) || get_post_meta($prop_id, 'embed_video_id', true)) {

      print '<div id="carousel-listing" class="classic-carousel slide post-carusel '.esc_attr($wp_estate_kind_of_map_class).' " data-interval="false">';
        print wpestate_return_property_status($prop_id,'horizontalstatus');



        print '
        <!-- Wrapper for slides -->
        <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
          '. trim($slider_components['slides']).'
        </div>

        <!-- Indicators -->
        <ol class="carousel-indicators carousel-indicators-classic ">
          '.trim($slider_components['indicators']).'
        </ol>

      </div>';

      print '
      <script type="text/javascript">
          //<![CDATA[
          jQuery(document).ready(function(){
             wpestate_property_slider();
          });
          //]]>
      </script>';


  } // end if post_attachments
}
endif;


/*
*
* Header masonary type 2
*
*
*/

if( !function_exists('wpestate_header_masonry_gallery_type2') ):
function wpestate_header_masonry_gallery_type2($prop_id,$is_shortcode=""){
  print'<div class="gallery_wrapper">';

      $post_attachments   =   wpestate_return_property_images($prop_id);
      $count              =   0;
      $total_pictures     =   count ($post_attachments);
      if($count == 0 ){
          $full_prty          = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'listing_full_slider');
          print wpestate_return_property_status($prop_id,'horizontalstatus');
          print '<div class="col-md-8 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url('.esc_attr($full_prty[0]).')  ">   <div class="img_listings_overlay" ></div></div>';
      }


      foreach ($post_attachments as $attachment) {
          $count++;
          $special_border='  ';
          if($count==0){
              $special_border=' special_border ';
          }

          if($count==1){
              $special_border=' special_border_top ';
          }

          if($count==3){
              $special_border=' special_border_left ';
          }

          if($count <= 4 && $count !=0){
              $full_prty          = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
              print '<div class="col-md-4 image_gallery lightbox_trigger '.esc_attr($special_border).' " data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')"> <div class="img_listings_overlay" ></div> </div>';
          }

          if($count ==5 ){
              $full_prty          = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
              print '<div class="col-md-4 image_gallery last_gallery_item lightbox_trigger" data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')  ">
                  <div class="img_listings_overlay img_listings_overlay_last" ></div>
                  <span class="img_listings_mes">'.esc_html__( 'See all','wpresidence').' '.esc_html($total_pictures).' '.esc_html__( 'photos','wpresidence').'</span></div>';
          }
      }

  print '</div>';
}
endif;

/*
*
* Header masonary type 1
*
*
*/

if( !function_exists('wpestate_header_masonry_gallery') ):
function wpestate_header_masonry_gallery($prop_id,$is_shortcode=""){
    print'<div class="gallery_wrapper property_header_gallery_wrapper">';


    $post_attachments   =   wpestate_return_property_images($prop_id);
    print wpestate_return_property_status($prop_id,'horizontalstatus');

    $count              =   0;
    $total_pictures     =   count ($post_attachments);

    if($count == 0 ){
        $full_prty          = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'listing_full_slider_1');
        print '<div class="col-md-6 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url('.esc_attr($full_prty[0]).')  ">   <div class="img_listings_overlay" ></div></div>';
    }


    foreach ($post_attachments as $attachment) {
        $count++;
        $special_border='  ';
        if($count==0){
            $special_border=' special_border ';
        }

        if($count>=1 && $count<=2){
            $special_border=' special_border_top ';
        }



        if($count <= 3 && $count !=0){
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            print '<div class="col-md-3 image_gallery lightbox_trigger '.esc_attr($special_border).' " data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')"> <div class="img_listings_overlay" ></div> </div>';
        }

        if($count == 4 ){
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            print '<div class="col-md-3 image_gallery last_gallery_item lightbox_trigger" data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')  ">
                <div class="img_listings_overlay img_listings_overlay_last" ></div>';

                if($is_shortcode!='yes'){
                    print '<span class="img_listings_mes">'.esc_html__( 'See all','wpresidence').' '.esc_html($total_pictures).' '.esc_html__( 'photos','wpresidence').'</span>';
                }

                print '</div>';
        }
        if($count >=5 ){
            break;
        }
    }

    print '</div>';

}
endif;


/*
*
* Slider data
*
*
*
*/
if( !function_exists('wpestate_slider_slide_generation') ):
function wpestate_slider_slide_generation($prop_id,$slider_size,$use_captions_on_slide=''){

        $post_attachments   =   wpestate_return_property_images($prop_id);
        $has_video          =   0;
        $indicators         =   '';
        $round_indicators   =   '';
        $slides             =   '';
        $captions           =   '';
        $counter            =    0;
        $slider_components =    array();
        $slider_components['has_info']=0;


        if( has_post_thumbnail($prop_id) ){
            $counter++;

            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id( $prop_id );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');

            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider');
            }

            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);

            $captions_on_slide='';
            if($attachment_meta['caption']!='' && $use_captions_on_slide=='yes'){
                $captions_on_slide='<div class="caption_on_slide">'.$attachment_meta['caption'].'</div>';
            }


            $indicators.= ' <li  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. esc_attr($active).'">
                                <a href="#item'.esc_attr($counter).'">'
                                .'<img  src="'.esc_url($preview[0]).'"  alt="'.esc_html__('image','wpresidence').'" /></a>
                            </li>';

            $round_indicators   .= '<a  href="#item'.esc_attr($counter).'"  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'"></a>';

            $slides .= '<div class="item '.esc_attr($active).'" data-number="'.$counter.'" data-hash="item'.esc_attr($counter).'" >
                            <a href="'.esc_url($full_prty[0]).'" title="'.esc_attr($attachment_meta['caption']).'" rel="prettyPhoto" class="prettygalery" >
                                <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                                '.$captions_on_slide.'
                            </a>
                        </div>';

            if( trim ( $attachment_meta['caption']=='') ){
                $active.=' blank_caption ';
            }

            $captions .= '<span data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'"> '. $attachment_meta['caption'].'</span>';
        }



        if($post_attachments){
          $slider_components['has_info']=1;
        }

        foreach ($post_attachments as $attachment) {
            $counter++;

            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            }
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);



            $captions_on_slide='';
            if($attachment_meta['caption']!='' && $use_captions_on_slide=='yes'){
                $captions_on_slide='<div class="caption_on_slide">'.$attachment_meta['caption'].'</div>';
            }

            $indicators.= ' <li  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. esc_attr($active).'">
                                <a href="#item'.esc_attr($counter).'">'
                                .'<img  src="'.esc_url($preview[0]).'"  alt="'.esc_html__('image','wpresidence').'" /></a>
                            </li>';
            $round_indicators   .= '<a  href="#item'.esc_attr($counter).'"  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'"></a>';

            $slides .= '<div class="item '.esc_attr($active).'" data-number="'.$counter.'" data-hash="item'.esc_attr($counter).'" >
                            <a href="'.esc_url($full_prty[0]).'" title="'.esc_attr($attachment_meta['caption']).'" rel="prettyPhoto" class="prettygalery" >
                                <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                                '.$captions_on_slide.'
                            </a>
                        </div>';

            if( trim ( $attachment_meta['caption']=='') ){
                $active.=' blank_caption ';
            }

            $captions .= '<span data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'"> '. $attachment_meta['caption'].'</span>';
        }// end foreach




        $slider_components['indicators']        =   $indicators;
        $slider_components['round_indicators']  =   $round_indicators;
        $slider_components['slides']            =   $slides;
        $slider_components['captions']          =   $captions;

        return $slider_components;
}
endif;



/*
*
* return poperty attachemnts
*
*
*/

if( !function_exists('wpestate_return_property_images') ):
function wpestate_return_property_images($prop_id){

        $arguments      = array(
            'numberposts'       => -1,
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_parent'       => $prop_id,
            'post_status'       => null,
            'exclude'           => get_post_thumbnail_id($prop_id),
            'orderby'           => 'menu_order',
            'order'             => 'ASC'
        );

        $post_attachments   =   get_posts($arguments);

        return $post_attachments;
}
endif;


 ?>
