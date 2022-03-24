<?php
global $prop_id ;
global $agent_email;
global $agent_urlc;
global $link;
global $agent_url;
global $agent_urlc;
global $link;
global $agent_facebook;
global $agent_posit;
global $agent_twitter;
global $agent_linkedin;
global $agent_instagram;
global $agent_pinterest;
global $agent_member;



if(isset($is_modal)){
    $prop_id=$post_id;
    $agent_id=$modal_agent_id;
    global $propid;
    $propid=$prop_id;

}else{
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active( 'elementor/elementor.php' )) {
        if( !\Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $prop_id=$post->ID;
        }else{
            $prop_id=$property_id;
        }
    }else{
        $prop_id=$post->ID;
    }

    if( get_page_template_slug()=='page_property_design.php' ){
        $prop_id=$property_id;
    }

    $agent_id       =   intval( get_post_meta($prop_id, 'property_agent', true) );

}


$realtor_details    =   wpestate_return_agent_details($prop_id);
$author_email       =   get_the_author_meta( 'user_email'  );
$agent_user_id      =   get_post_meta($agent_id,'user_agent_id',true);
if ($agent_id!=0){


        include( locate_template('templates/agentdetails.php'));
        include( locate_template('templates/agent_contact.php'));


}   // end if !=0
else{
    
       $author_id           =  wpsestate_get_author($prop_id);
        if ( get_the_author_meta('user_level',$author_id) !=10){
            include( locate_template('templates/agentdetails.php'));
            include( locate_template('templates/agent_contact.php') );
        }
}
?>
