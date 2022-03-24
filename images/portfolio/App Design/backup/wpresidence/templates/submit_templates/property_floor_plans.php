<?php
global $post;

$use_floor_plans='';
$plan_title_array='';
$plan_desc_array='';
$plan_image_array='';
$plan_size_array='';
$plan_rooms_array='';
$plan_bath_array='';
$plan_price_array='';

if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit']) ) {
  $edit_id                = intval($_GET['listing_edit']);
  $use_floor_plans        = get_post_meta($edit_id, 'use_floor_plans', true);
  $plan_title_array       = get_post_meta($edit_id, 'plan_title', true);
  $plan_desc_array        = get_post_meta($edit_id, 'plan_description', true) ;
  $plan_image_array       = get_post_meta($edit_id, 'plan_image', true) ;
  $plan_size_array        = get_post_meta($edit_id, 'plan_size', true) ;
  $plan_rooms_array       = get_post_meta($edit_id, 'plan_rooms', true) ;
  $plan_bath_array        = get_post_meta($edit_id, 'plan_bath', true);
  $plan_price_array       = get_post_meta($edit_id, 'plan_price', true) ;
  $plan_image_attach_array=get_post_meta($edit_id,'plan_image_attach',true);

}



if(isset($_POST['use_floor_plans']) && $_POST['use_floor_plans']==1){
  $use_floor_plans=1;
}

if(isset($_POST['plan_title']) ){
  $plan_title_array=$_POST['plan_title'];
}


if(isset($_POST['plan_description']) ){
  $plan_desc_array=$_POST['plan_description'];
}


if(isset($_POST['floor_plan_image']) ){
  $plan_image_array=$_POST['floor_plan_image'];
}
if(isset($_POST['plan_size']) ){
  $plan_size_array=$_POST['plan_size'];
}

if(isset($_POST['plan_rooms']) ){
  $plan_rooms_array=$_POST['plan_rooms'];
}

if(isset($_POST['plan_bath']) ){
  $plan_bath_array=$_POST['plan_bath'];
}


if(isset($_POST['plan_price']) ){
  $plan_price_array=$_POST['plan_price'];
}


if(isset($_POST['plan_image_attach']) ){
  $plan_image_attach_array=$_POST['plan_image_attach'];
}
?>


<div class="profile-onprofile row ">
    <div class="wpestate_dashboard_section_title"><?php esc_html_e('Floor Plans','wpresidence');?></div>
      <div class="col-md-12">
        <label class="use_floor_plans_label" for="use_floor_plans"><?php esc_html_e('Use Floor Plans','wpresidence');?> </label>
         <input type="hidden"    name="use_floor_plans" value="">
        <input type="checkbox" id="use_floor_plans" name="use_floor_plans" value="1"';
        <?php
            if($use_floor_plans==1){
                print ' checked="checked" ';
            }
            ?>
        />
      </div>

      <div class="section_floor_plan_unit_wrapper ">
      <?php
      $plan_count=1;
      if(is_array($plan_title_array)){
            foreach ($plan_title_array as $key=> $plan_name) {

                if ( isset($plan_desc_array[$key])){
                    $plan_desc=$plan_desc_array[$key];
                }else{
                    $plan_desc='';
                }

                if ( isset($plan_image_array[$key])){
                    $plan_img=$plan_image_array[$key];
                }else{
                    $plan_img='';
                }

                if ( isset($plan_size_array[$key])){
                    $plan_size=$plan_size_array[$key];
                }else{
                    $plan_size='';
                }

                if ( isset($plan_rooms_array[$key])){
                    $plan_rooms=$plan_rooms_array[$key];
                }else{
                    $plan_rooms='';
                }

                if ( isset($plan_bath_array[$key])){
                    $plan_bath=$plan_bath_array[$key];
                }else{
                    $plan_bath='';
                }

                if ( isset($plan_price_array[$key])){
                    $plan_price=$plan_price_array[$key];
                }else{
                    $plan_price='';
                }


                if(isset($plan_image_attach_array[$key])){
                $plan_image_attach=  $plan_image_attach_array[$key];
                }else{
                  $plan_image_attach='';
                }



                if($plan_name!=''):
                ?>
                <div class="floor_plan_unit_wrapper">
                   <div class="col-md-12">
                     <label for="plan_title"><?php esc_html_e('Plan Title','wpresidence');?> </label>
                     <a class="wpestate_dash_delete_plan" onclick="return confirm('<?php echo esc_html__('Are you sure you wish to delete ?','wpresidence'); ?>');"><?php esc_html_e('Delete Plan','wpresidence');?></a>
                     <input id="plan_title" type="text" size="36" name="plan_title[]" value="<?php echo esc_html($plan_name); ?>" >
                   </div>

                   <div class="col-md-12">
                     <label for="plan_description"><?php esc_html_e('Plan Description','wpresidence');?> </label>
                     <textarea class="plan_description" type="text" size="36" name="plan_description[]" ><?php echo esc_html($plan_desc);?></textarea>
                   </div>

                   <div class="col-md-6">
                     <label for="plan_size"><?php esc_html_e('Plan Size','wpresidence');?> </label>
                     <input id="plan_size" type="text" size="36" name="plan_size[]" value="<?php echo esc_html($plan_size);?>">
                   </div>

                   <div class="col-md-6">
                     <label for="plan_rooms"><?php esc_html_e('Plan Rooms','wpresidence');?> </label>
                     <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="<?php echo esc_html($plan_rooms);?>">
                   </div>

                   <div class="col-md-6">
                     <label for="plan_bath"><?php esc_html_e('Plan Bathrooms','wpresidence');?> </label>
                     <input id="plan_bath" type="text" size="36"name="plan_bath[]" value="<?php  echo esc_html($plan_bath); ?>">
                   </div>

                   <div class="col-md-6">
                     <label for="plan_price"><?php esc_html_e('Price in ','wpresidence');echo 'c'.esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );?></label><br>
                     <input id="plan_price" type="text" size="36" name="plan_price[]" value="<?php echo esc_html($plan_price); ?>">
                   </div>


                   <div class="col-md-6">
                     <div id="upload-container">
                       <div id="aaiu-upload-container">

                         <div class="aaiu-upload-imagelist-floor-plan">
                         </div>

                          <div id="imagelist">
                              <img src="<?php echo esc_url($plan_img); ?>" class="floor_plan_image_thumb">
                              <input class="floor_plan_image" type="hidden" size="36" name="floor_plan_image[]" value="<?php echo esc_url($plan_img); ?>">
                              <input type="hidden" class="plan_image_attach" name="plan_image_attach[]" value="<?php echo esc_html($plan_image_attach);?>">
                           </div>
                           <div id="aaiu-uploader-floor-plans-<?php echo intval($plan_count);?>"  class=" aaiu-uploader-floor-plans wpresidence_button wpresidence_success"><?php esc_html_e('Upload Plan Image','wpresidence');?></div>

                       </div>
                     </div>
                   </div>
               </div>

             <?php
             $plan_count++;
             endif;
            }
        }
       ?>
     </div>

     <div id="add_new_floor_plan" class="wpresidence_button wpresidence_success"><?php esc_html_e('Add another plan','wpresidence');?></div>

 </div>
