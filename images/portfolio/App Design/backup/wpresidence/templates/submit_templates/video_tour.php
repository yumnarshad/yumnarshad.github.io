<?php
global $virtual_tour;
global $wpestate_submission_page_fields;
$iframe = array( 'iframe' => array(
                 'src' => array (),
                 'width' => array (),
                 'height' => array (),
                 'name'=> array(),
                 'frameborder' => array(),
                 'style' => array(),
                 'allowFullScreen' => array() // add any other attributes you wish to allow
                  ) );
$virtual_tour                   =   '';

if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit']) ) {
   $edit_id = intval( $_GET['listing_edit'] );
   $virtual_tour                   =   get_post_meta($edit_id, 'embed_virtual_tour', true);
}

if(isset($_POST['embed_virtual_tour'])){
   $virtual_tour                   =   wp_kses (trim($_POST['embed_virtual_tour']),$iframe) ;
}
?>

<?php if(   is_array($wpestate_submission_page_fields) && in_array('embed_virtual_tour', $wpestate_submission_page_fields)) { ?>
  <div class="profile-onprofile row">
      <div class="wpestate_dashboard_section_title"><?php esc_html_e('Virtual Tour','wpresidence');?></div>
      <div class="col-md-12">
            <label for="embed_virtual_tour"><?php esc_html_e('Virtual Tour: ','wpresidence');?></label>
            <textarea id="embed_virtual_tour" class="form-control"  name="embed_virtual_tour"> <?php echo wp_kses($virtual_tour,$iframe);?></textarea>
      </div>

  </div>
<?php } ?>
