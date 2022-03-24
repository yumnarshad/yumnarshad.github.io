<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="google-signin-client_id" content="13759604714-0t7p0dh546nvkefuvt58ojmj6dcr82ld.apps.googleusercontent.com">
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/analytics.readonly">
<?php
if( !has_site_icon() ){
    print '<link rel="shortcut icon" href="'.get_theme_file_uri('/img/favicon.gif').'" type="image/x-icon" />';
}
wp_head();?>
</head>

<body <?php body_class(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}

$logo_header_type   =   wpresidence_get_option('wp_estate_logo_header_type','');
$header_classes     =   wpestate_header_classes();
if( $logo_header_type=='type3' &&  wpestate_is_user_dashboard() ){
  $logo_header_type='type1';
}
get_template_part('templates/mobile_menu' );
?>

<div class="website-wrapper" id="all_wrapper" >
  <div class="container main_wrapper <?php echo esc_attr($header_classes['main_wrapper_class']) ;?>">

  <?php
  $is_elementor_in_use='header_media_elementor';
  if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
    wpresidence_show_header_wrapper($header_classes,$logo_header_type);
      $is_elementor_in_use='header_media_non_elementor';
  }

  get_template_part( 'header_media','', array(
        'elementor_class'   => $is_elementor_in_use,
    ) );
  ?>
  <div class="pre_search_wrapper"></div>
<div class="container content_wrapper">
