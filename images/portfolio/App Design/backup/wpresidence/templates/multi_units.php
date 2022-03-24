<?php
global $post;
global $wpestate_currency;
global $where_currency;
global $property_subunits_master;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('elementor/elementor.php')) {
    if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        $prop_id = $post->ID;
    } else {
        $prop_id = $property_id;
    }
} else {
    $prop_id = $post->ID;
}

if (!isset($section_title)) {
    $section_title = esc_html__('Available Units', 'wpresidence');
}
if (!isset($section_title2)) {
    $section_title2 = esc_html__('Other units in', 'wpresidence');
}




if (function_exists('icl_translate')) {
    $wp_estate_property_multi_text = icl_translate('wpestate', 'wp_estate_property_multi_text', esc_html(wpresidence_get_option('wp_estate_property_multi_text')));
    $wp_estate_property_multi_child_text = icl_translate('wpestate', 'wp_estate_property_multi_child_text', esc_html(wpresidence_get_option('wp_estate_property_multi_child_text')));
} else {
    $wp_estate_property_multi_text = stripslashes(esc_html(wpresidence_get_option('wp_estate_property_multi_text')));
    $wp_estate_property_multi_child_text = stripslashes(esc_html(wpresidence_get_option('wp_estate_property_multi_child_text')));
}

$has_multi_units = intval(get_post_meta($prop_id, 'property_has_subunits', true));
$property_subunits_master = intval(get_post_meta($prop_id, 'property_subunits_master', true));

$display = 0;
if ($has_multi_units == 1) {
    $display = 1;
} else {
    if (intval($property_subunits_master) != 0) {
        $has_multi_units = intval(get_post_meta($property_subunits_master, 'property_has_subunits', true));
        if ($has_multi_units == 1) {
            $display = 1;
        }
    } else {
        $display = 0;
    }
}
$property_subunits_list = get_post_meta($prop_id, 'property_subunits_list', true);

if (intval($property_subunits_master) != 0 && $property_subunits_master != $post->ID) {
    $property_subunits_list_master = get_post_meta($property_subunits_master, 'property_subunits_list', true);

    if (is_array($property_subunits_list_master) && ($key = array_search($prop_id, $property_subunits_list_master)) !== false) {
        if (isset($property_subunits_list_master[$key])) {
            unset($property_subunits_list_master[$key]);
        }
    }

    if (!is_array($property_subunits_list_master) || ( is_array($property_subunits_list_master) && count($property_subunits_list_master) == 0)) {
        $display = 0;
    }
}

if ($display == 1) {
    ?>
    <div class="multi_units_wrapper">

        <?php
        if (intval($property_subunits_master) != 0 && $property_subunits_master != $post->ID) {
            $prop_id = intval($property_subunits_master);
            ?>
            <h4 class="panel-title"><?php
        if ($wp_estate_property_multi_child_text != '') {
            echo esc_html($wp_estate_property_multi_child_text);
        } else {
            print $section_title2;
        }
        echo ' <a href="' . esc_url(get_permalink($property_subunits_master)) . '" target="_blank">' . get_the_title($property_subunits_master) . '</a>';
            ?> </h4>
            <?php
        } else {
            ?>
            <h4 class="panel-title">
                <?php
                if ($wp_estate_property_multi_text != '') {
                    echo '' . esc_html($wp_estate_property_multi_text);
                } else {
                    echo esc_html($section_title);
                }
                ?> </h4>
            <?php
        }



        $measure_sys = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));
        $property_subunits_list_manual = get_post_meta($prop_id, 'property_subunits_list_manual', true);

        if ($property_subunits_list_manual != '') {
            $property_subunits_list = explode(',', $property_subunits_list_manual);
        } else {
            $property_subunits_list = get_post_meta($prop_id, 'property_subunits_list', true);
        }

        if (is_array($property_subunits_list)) {
            foreach ($property_subunits_list as $prop_id) {
                $status = get_post_status($prop_id);
                if ($prop_id != $post->ID && $status == 'publish') {
                    print '<div class="subunit_wrapper">';
                    $compare = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'slider_thumb');
                    $property_rooms = floatval(get_post_meta($prop_id, 'property_rooms', true));
                    $property_bedrooms = floatval(get_post_meta($prop_id, 'property_bedrooms', true));
                    $property_bathrooms = floatval(get_post_meta($prop_id, 'property_bathrooms', true));
                    $property_size_simple = floatval(get_post_meta($prop_id, 'property_size', true));
                    $property_size = wpestate_get_converted_measure($prop_id, 'property_size');

                    $property_type = get_the_term_list($prop_id, 'property_category', '', ', ', '');
                    $title = get_the_title($prop_id);
                    $link = esc_url(get_permalink($prop_id));

                    print '<div class="subunit_thumb"><a href="' . esc_url($link) . '" target="_blank"><img src="' . esc_url($compare[0]) . '" alt="' . esc_attr($title) . '" /></a></div>';
                    print '<div class="subunit_details">';
                    print '<div class="subunit_title"><a href="' . esc_url($link) . '" target="_blank">' . esc_html($title) . '</a>  ';
                    print '<div class="subunit_price">';
                    wpestate_show_price($prop_id, $wpestate_currency, $where_currency);
                    print '</div></div>';
                    print '<div class="subunit_type"><strong>' . esc_html__('Category: ', 'wpresidence') . '</strong> ' . wp_kses_post($property_type) . ', </div>';
                    if ($property_rooms > 0) {
                        print '<div class="subunit_rooms"><strong>' . esc_html__('Rooms: ', 'wpresidence') . '</strong> ' . esc_html($property_rooms) . ', </div>';
                    }
                    if ($property_bedrooms > 0) {
                        print '<div class="subunit_rooms"><strong>' . esc_html__('Bedrooms: ', 'wpresidence') . '</strong> ' . esc_html($property_bedrooms) . ', </div>';
                    }
                    if ($property_bathrooms > 0) {
                        print '<div class="subunit_bathrooms"><strong>' . esc_html__('Baths: ', 'wpresidence') . '</strong> ' . esc_html($property_bathrooms) . ', </div>';
                    }
                    if ($property_size_simple > 0) {
                        print '<div class="subunit_size"><strong>' . esc_html__('Size: ', 'wpresidence') . '</strong> ' . trim($property_size) . '</div>'; //escaped in wpestate_get_converted_measure
                    }
                    print '</div>';

                    print '</div>';
                }
            }
        }
        ?>
    </div>
<?php } ?>
