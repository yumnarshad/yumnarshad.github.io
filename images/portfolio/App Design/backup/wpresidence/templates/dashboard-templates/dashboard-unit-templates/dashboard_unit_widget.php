<?php
  $item_id  =   get_the_ID();
  $preview  =   wp_get_attachment_image_src(get_post_thumbnail_id($item_id), 'widget_thumb');
  $link     =   get_permalink($item_id);
  $title    =   get_the_title($item_id);

 ?>
<div class="dashboard_widget_unit">
  <a class="dashbard_unit_image" href="<?php print esc_url($link); ?>"><img  src="<?php  print esc_url($preview[0]); ?>" /></a>

  <div class="property_dashboard_location_wrapper">
    <a class="dashbard_unit_title" href="<?php print esc_url($link); ?>"><?php echo esc_html($title); ?></a>

    <div class="property_dashboard_location">
        <?php
         print esc_html($action_status);
         ?>
    </div>
  </div>
</div>
