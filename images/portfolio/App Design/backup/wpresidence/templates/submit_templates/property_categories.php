<?php
if( isset($_POST['prop_category']) ) {
   $prop_category_selected  =   intval($_POST['prop_category']);
}

if( isset($_POST['prop_action_category']) ) {
    $prop_action_category_selected  =   intval($_POST['prop_action_category']);
}



if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit']) ) {

  $edit_id = intval( $_GET['listing_edit'] );

  $prop_category                  =   get_the_terms( $edit_id, 'property_category');
  if(!empty($prop_category)){
       foreach ($prop_category as $key=>$term){
           $prop_category_selected=intval($term->term_id);
       }
   }else{
     $prop_category_selected = -1;
   }

   $prop_category                  =   get_the_terms( $edit_id, 'property_action_category');
   if(!empty($prop_category)){
        foreach ($prop_category as $key=>$term){
            $prop_action_category_selected=intval($term->term_id);
        }
    }else{
      $prop_action_category_selected = -1;
    }




}

?>



<?php if(   is_array($wpestate_submission_page_fields) &&
            (   in_array('prop_action_category', $wpestate_submission_page_fields) ||
                in_array('prop_category', $wpestate_submission_page_fields)
            )
        ) { ?>

      <div class="profile-onprofile row">
            <div class="wpestate_dashboard_section_title"><?php esc_html_e('Select Categories','wpresidence');?></div>



            <?php if(   is_array($wpestate_submission_page_fields) && in_array('prop_category', $wpestate_submission_page_fields)) { ?>
                <p class="col-md-6"><label for="prop_category"><?php esc_html_e('Category','wpresidence');?></label>
                    <?php
                        $args=array(
                                'class'       => 'select-submit2',
                                'hide_empty'  => false,
                                'selected'    => $prop_category_selected,
                                'name'        => 'prop_category',
                                'id'          => 'prop_category_submit',
                                'orderby'     => 'NAME',
                                'order'       => 'ASC',
                                'show_option_none'   => esc_html__('None','wpresidence'),
                                'taxonomy'    => 'property_category',
                                'hierarchical'=> true
                            );
                        wp_dropdown_categories( $args ); ?>
                </p>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('prop_action_category', $wpestate_submission_page_fields)) { ?>
                <p class="col-md-6"><label for="prop_action_category"> <?php esc_html_e('Listed In ','wpresidence'); $prop_action_category;?></label>
                    <?php
                    $args=array(
                            'class'       => 'select-submit2',
                            'hide_empty'  => false,
                            'selected'    => $prop_action_category_selected,
                            'name'        => 'prop_action_category',
                            'id'          => 'prop_action_category_submit',
                            'orderby'     => 'NAME',
                            'order'       => 'ASC',
                            'show_option_none'   => esc_html__('None','wpresidence'),
                            'taxonomy'    => 'property_action_category',
                            'hierarchical'=> true
                        );

                       wp_dropdown_categories( $args );  ?>
                </p>
            <?php }?>

    </div>

<?php }?>
