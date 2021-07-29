<?php
function wp_menu_route() {
    $menuLocations = get_nav_menu_locations(); // Get nav locations set in theme, usually functions.php)
    return $menuLocations;
    }

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wp/v2', '/menu/', array(
        'methods' => 'GET',
        'callback' => 'wp_menu_route',
    ) );
} );

function wp_menu_single($data) {
    $menuID = $data['id']; // Get the menu from the ID
    $primaryNav = wp_get_nav_menu_items($menuID); // Get the array of wp objects, the nav items for our queried location.
    return $primaryNav;
    }

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wp/v2', '/menu/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'wp_menu_single',
    ) );
} );
?>