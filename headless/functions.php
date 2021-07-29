<?php
function expose_navigation($request) {
    $id = $request['id'];
    return wp_get_nav_menu_items($id);
  }
  
  /**
   * Exposes under /navigation/{id} the menu items in the wp-json api
   *
   * @return void
   */
  function expose_navigation_to_rest() {
    register_rest_route( 'wp/v2', '/menu/(?P<id>\d+)', [
        'methods' => 'GET',
        'callback' => 'expose_navigation'
      ]
    );
  }
  
  add_action('rest_api_init', 'expose_navigation_to_rest');
?>