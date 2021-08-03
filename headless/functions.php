<?php
function wp_menu_route() {
    $menuLists = get_terms( 'nav_menu', array( 'hide_empty' => true ) ); // Get nav locations set in theme, usually functions.php)
    return $menuLists;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/menu/', array(
        'methods' => 'GET',
        'callback' => 'wp_menu_route',
    ));
});

function wp_menu_single($data) {
    $menuID = $data['id']; // Get the menu from the ID
    $primaryNav = wp_get_nav_menu_items($menuID); // Get the array of wp objects, the nav items for our queried location.
    return $primaryNav;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/menu/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'wp_menu_single',
    ));
});

function create_ACF_meta_in_REST() {
    $postypes_to_exclude = ['acf-field-group','acf-field'];
    $extra_postypes_to_include = ['page','employment'];
    $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

    array_push($post_types, $extra_postypes_to_include);

    foreach ($post_types as $post_type) {
        register_rest_field( $post_type, 'acf', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
       ]
     );
    }

}

function expose_ACF_fields( $object ) {
    $ID = $object['id'];
    return get_fields($ID);
}

add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );
?>