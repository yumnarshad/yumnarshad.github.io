<?php
global $embed_video_id;
global $option_video;
global $wpestate_submission_page_fields;


$video_type                   =   '';
if( isset( $get_listing_edit ) && is_numeric( $get_listing_edit) ) {
    $edit_id    =   intval( $get_listing_edit );
    $video_type =   esc_html ( get_post_meta($edit_id, 'embed_video_type', true) );
}

if(isset($_POST['embed_video_type'])){
   $video_type  =   wp_kses( esc_html($_POST['embed_video_type']),$allowed_html);
}

$video_values  =   array('vimeo', 'youtube');
foreach ($video_values as $value) {
   $option_video.='<option value="' . $value . '"';
   if ($value == $video_type) {
       $option_video.='selected="selected"';
   }
   $option_video.='>' . $value . '</option>';
 }


?>


<?php if(   is_array($wpestate_submission_page_fields) &&
           (    in_array('embed_video_type', $wpestate_submission_page_fields) ||
                in_array('embed_video_id', $wpestate_submission_page_fields)
            )
        ) { ?>


    <div class="profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Video Option','wpresidence');?></div>


            <?php if(   is_array($wpestate_submission_page_fields) && in_array('embed_video_type', $wpestate_submission_page_fields)) { ?>

                  <div class="col-md-12">
                     <label for="embed_video_type"><?php esc_html_e('Video from','wpresidence');?></label>
                     <select id="embed_video_type" name="embed_video_type" class="select-submit2">
                         <?php print trim($option_video);?>
                     </select>
                  </div>

            <?php }?>


            <?php if(   is_array($wpestate_submission_page_fields) && in_array('embed_video_id', $wpestate_submission_page_fields)) { ?>

                    <div class="col-md-12">
                       <label for="embed_video_id"><?php esc_html_e('Embed Video id: ','wpresidence');?></label>
                       <input type="text" id="embed_video_id" class="form-control"  name="embed_video_id" size="40"
                        value="<?php print stripslashes(wpestate_submit_return_value('embed_video_id',$get_listing_edit,'') ) ; ?>">
                   </div>

            <?php }?>


    </div>
<?php }?>
