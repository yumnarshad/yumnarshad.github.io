<?php
global $agent_email;
global $propid;
global $agent_wid;


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

if (get_page_template_slug() == 'page_property_design.php') {
    $prop_id = $property_id;
}

$realtor_details = wpestate_return_agent_details($prop_id);
?>



<?php
wp_reset_query();
$agent_wid = $realtor_details['agent_id'];
if (get_the_author_meta('user_level', $agent_wid) != 10) {
    ?>
    <div class="agent_contanct_form_sidebar widget-container">
        <?php
        include( locate_template('templates/agent_unit_widget_sidebar.php') );
        include( locate_template('templates/agent_contact.php') );
        //include( locate_template('templates/realtor_templates/agent_contact_bar.php') );
        ?>
    </div>
<?php }
?>
