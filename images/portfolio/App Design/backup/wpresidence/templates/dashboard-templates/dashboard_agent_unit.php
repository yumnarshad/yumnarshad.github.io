<?php
global $post;
$thumb_id           =   get_post_thumbnail_id($post->ID);
$agent_phone        =   esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       =   esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        =   esc_html( get_post_meta($post->ID, 'agent_email', true) );
$agent_posit        =   esc_html( get_post_meta($post->ID, 'agent_position', true) );
$name               =   get_the_title();
$link               =   esc_url( get_permalink() );

$extra= array(
        
        'class'	=> 'lazyload img-responsive',
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'widget_thumb',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
}

?>


<div class="row property_wrapper_dash">

    <div class="blog_listing_image col-md-4">
        <div class="dashboard_agent_listing_image">
        <?php
          print trim($thumb_prop);
        ?>
      </div>
        <div class="property_dashboard_location_wrapper">
          <a class="dashbard_unit_title" href="<?php print esc_url($link); ?>"><?php echo esc_html($name); ?></a>
          <div class="property_dashboard_location">
            <?php print esc_html($agent_posit).'</br>'; ?>
            <?php print esc_html__('user id:','wpresidence').' '.get_post_meta($post->ID, 'user_meda_id',true ); ?>
          </div>
        </div>
    </div>

    <div class="col-md-2 property_dashboard_types"><?php
        print esc_html($agent_phone );
        print ' / ';
        print esc_html($agent_mobile);
       ?>
    </div>

    <div class="col-md-2 property_dashboard_types"><?php echo esc_html($agent_email);?>
    </div>

    <div class="col-md-2 property_dashboard_status"><?php $status =   get_post_status($post->ID);
      if($status=='publish') $status='published';
      print '<div class=" property_list_status_label '.sanitize_key($status).'">'.esc_html($status).'</div>';
     ?>
    </div>

    <div class="col-md-2 property_dashboard_action">
      <?php get_template_part('templates/dashboard-templates/dashboard-unit-templates/dashboard-agent-unit-actions'); ?>
    </div>
</div>
