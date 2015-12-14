<?php


function custom_post_type() {

    // EVENEMENT
    $labels = array(
        'name'               => _x('Evenement', 'general name'),
        'singular_name'      => _x('Evenement', 'singular name'),
        'add_new'            => _x('Ajouter une evenement', 'evenement'),
        'add_new_item'       => __('Ajouter une evenement'),
        'edit_item'          => __('Modifier des evenements'),
        'new_item'           => __('Nouveaux evenements'),
        'all_items'          => __('Tous les evenements'),
        'view_item'          => __('Voir les evenements'),
        'search_items'       => __('Rechercher des evenements'),
        'not_found'          => __('Aucun evenement trouvé'),
        'not_found_in_trash' => __('Aucun evenement trouvé dans la corbeille'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Evenements'
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_position' => null,
        'supports'      => array('title', 'page-attributes'),
        'has_archive'   => true,
    );

    register_post_type(__('evenement'), $args);

    // CONTACT
    $labels = array(
        'name'               => _x('Contact', 'general name'),
        'singular_name'      => _x('Contact', 'singular name'),
        'add_new'            => _x('Ajouter une contact', 'contact'),
        'add_new_item'       => __('Ajouter une contact'),
        'edit_item'          => __('Modifier des contacts'),
        'new_item'           => __('Nouveaux contacts'),
        'all_items'          => __('Tous les contacts'),
        'view_item'          => __('Voir les contacts'),
        'search_items'       => __('Rechercher des contacts'),
        'not_found'          => __('Aucun contact trouvé'),
        'not_found_in_trash' => __('Aucun contact trouvé dans la corbeille'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Contacts'
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_position' => null,
        'supports'      => array('title', 'page-attributes'),
        'has_archive'   => true,
    );

    register_post_type(__('contact'), $args);
}

add_action( 'init', 'custom_post_type' );

require 'metabox.php';