</div><!-- end content_wrapper started in header -->
</div> <!-- end class container -->
<?php
isset($post->ID) ? $post_id =$post->ID : $post_id='';
$show_foot          =   wpresidence_get_option('wp_estate_show_footer','');
if( $show_foot=='yes' && !wpestate_half_map_conditions ($post_id) ){
  if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
    get_template_part( 'templates/footer_template','', array() );
  }
}
?>

</div> <!-- end website wrapper ed-->
<?php wp_footer();?>
</body>
</html>
