<?php
$show_sticky_footer_select  =   wpresidence_get_option('wp_estate_show_sticky_footer','');
$footer_background          =   wpresidence_get_option('wp_estate_footer_background','url');
$repeat_footer_back_status  =   wpresidence_get_option('wp_estate_repeat_footer_back','');
$logo_header_type           =   wpresidence_get_option('wp_estate_logo_header_type','');
$footer_style               =   '';
$footer_back_class          =   '';

if ($footer_background!=''){
    $footer_style='style=" background-image: url('.esc_url($footer_background).') "';
}

if( $repeat_footer_back_status=='repeat' ){
    $footer_back_class = ' footer_back_repeat ';
}else if( $repeat_footer_back_status=='repeat x' ){
    $footer_back_class = ' footer_back_repeat_x ';
}else if( $repeat_footer_back_status=='repeat y' ){
    $footer_back_class = ' footer_back_repeat_y ';
}else if( $repeat_footer_back_status=='no repeat' ){
    $footer_back_class = ' footer_back_repeat_no ';
}

if($show_sticky_footer_select=='yes'){
    $footer_back_class.=' sticky_footer ';
}

if($logo_header_type=='type4'){
    $footer_back_class.= ' footer_header4 ';
}

$show_foot          =   wpresidence_get_option('wp_estate_show_footer','');
$wide_footer        =   wpresidence_get_option('wp_estate_wide_footer','');
$wide_footer_class  =   '';

if($show_foot==''){
    $show_foot='yes';
}

$post_id='';
if( isset($post->ID) ){
   $post_id =$post->ID;
}


  $wide_status     =   esc_html(wpresidence_get_option('wp_estate_wide_status',''));
  if($wide_status==''){
      $wide_status=1;
  }
  if($wide_status==2 || $wide_status==''){
      $footer_back_class.=" boxed_footer ";
  }


 ?>
 <footer id="colophon" <?php print wp_kses_post($footer_style); ?> class=" <?php print esc_attr($footer_back_class);?> ">

     <?php
     if($wide_footer=='yes'){
         $wide_footer_class=" wide_footer ";
     }
     ?>

     <div id="footer-widget-area" class="row <?php print esc_attr($wide_footer_class);?>">
        <?php get_sidebar('footer');?>
     </div>


     <?php
     $show_show_footer_copy_select  =   wpresidence_get_option('wp_estate_show_footer_copy','');
     if($show_show_footer_copy_select=='yes'){
     ?>
         <div class="sub_footer">
             <div class="sub_footer_content <?php print esc_attr($wide_footer_class);?>">
                 <span class="copyright">
                     <?php
                     $message = stripslashes( esc_html (wpresidence_get_option('wp_estate_copyright_message', '')) );
                     if (function_exists('icl_translate') ){
                         $property_copy_text      =   icl_translate('wpestate','wp_estate_copyright_message', $message );
                         print esc_html($property_copy_text);
                     }else{
                         print esc_html($message);
                     }
                     ?>
                 </span>

                 <div class="subfooter_menu">
                     <?php
                         show_support_link();
                         wp_nav_menu( array(
                             'theme_location'    => 'footer_menu',
                         ));
                     ?>
                 </div>
             </div>
         </div>
     <?php
     }// end show subfooter
     ?>


 </footer><!-- #colophon -->
