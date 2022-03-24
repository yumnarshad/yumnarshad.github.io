<?php
global $wpestate_submission_page_fields;
$energy_class_array = array( 'A+', 'A', 'B', 'C', 'D', 'E', 'F', 'G' ,'H');
$energy_class       = wpestate_submit_return_value('energy_class',$get_listing_edit,'');

?>



<?php if (is_array($wpestate_submission_page_fields) &&
            (
                in_array('energy_index', $wpestate_submission_page_fields) ||
                in_array('energy_class', $wpestate_submission_page_fields)
            )
        ) { ?>

    <div class="profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Select Energy Class', 'wpresidence');?></div>
          <?php
          if (is_array($wpestate_submission_page_fields) && in_array('energy_class', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6"><label for="energy_class"><?php esc_html_e('Energy Class', 'wpresidence');?></label>
                    	<select name="energy_class" id="energy_class">
            						<option value=""><?php esc_html_e('Select Energy Class (EU regulation)', 'wpresidence'); ?>
            						<?php
                            foreach ($energy_class_array as $single_class) {
                                print '<option value="'.$single_class.'"  '.($energy_class == $single_class ? ' selected ' : '').'  >'.$single_class;
                            }
                        ?>
            					</select>
                  </div>
         <?php }?>

         <?php if (is_array($wpestate_submission_page_fields) && in_array('energy_index', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6">
                    <label for="energy_index"> <?php esc_html_e('Energy Index in kWh/m2a', 'wpresidence');  ?>  </label>
                    <input type="text" id="energy_index" class="form-control" size="40" name="energy_index"
                    value="<?php print stripslashes(wpestate_submit_return_value('energy_index',$get_listing_edit,'') ) ; ?>">
                </div>
            <?php }?>

    </div>

<?php }?>
