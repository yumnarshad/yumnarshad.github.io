<?php
$price                  =   floatval ( get_post_meta($post->ID, 'property_price', true) );
$price_label            =   esc_html ( get_post_meta($post->ID, 'property_label', true) );
$price_label_before     =   esc_html ( get_post_meta($post->ID, 'property_label_before', true) );
if ($price != 0) {
    $price = wpestate_show_price(get_the_ID(),$wpestate_currency,$where_currency,1);
}else{
    $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
}

?>


<div class="single_property_labels">
    <?php
        print '<div class="property_title_label">'.wp_kses_post($property_action).'</div>';
        print '<div class="property_title_label actioncat">'.wp_kses_post($property_category).'</div>';
    ?>
</div>

<h1 class="entry-title entry-prop"><?php the_title(); ?></h1>

<div class="price_area"><?php print wp_kses_post($price); ?></div>
