<div class="add-estate profile-page profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Change Password','wpresidence');?></div>

        <div id="profile_pass"></div>
        <p  class="col-md-12">
            <label for="oldpass"><?php esc_html_e('Old Password','wpresidence');?></label>
            <input  id="oldpass" value=""  class="form-control" name="oldpass" type="password">
        </p>

        <p  class="col-md-6">
            <label for="newpass"><?php esc_html_e('New Password ','wpresidence');?></label>
            <input  id="newpass" value="" class="form-control" name="newpass" type="password">
        </p>
        <p  class="col-md-6">
            <label for="renewpass"><?php esc_html_e('Confirm New Password','wpresidence');?></label>
            <input id="renewpass" value=""  class="form-control" name="renewpass"type="password">
        </p>

        <?php   wp_nonce_field( 'pass_ajax_nonce', 'security-pass' );   ?>
        <p class="fullp-button">
            <button class="wpresidence_button" id="change_pass"><?php esc_html_e('Reset Password','wpresidence');?></button>

        </p>
</div>
