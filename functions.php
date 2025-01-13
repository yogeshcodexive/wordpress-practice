<?php
$curious_includes = [
  'lib/assets.php',  // Scripts and stylesheets
  'lib/extras.php',  // Custom functions
  'lib/setup.php',   // Theme setup
  'lib/titles.php',  // Page titles
  'lib/wrapper.php'  // Theme wrapper class
];

foreach ($curious_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function mytheme_add_woocommerce_support()
{
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

if (function_exists('acf_add_options_page')) {

  acf_add_options_page(
    array(
      'page_title' => 'Header',
      'menu_title' => 'Header',
      'menu_slug' => 'header-options',
      'capability' => 'edit_posts',
      'redirect' => false
    )
  );
  acf_add_options_page(
    array(
      'page_title' => 'Footer',
      'menu_title' => 'Footer',
      'menu_slug' => 'footer-options',
      'capability' => 'edit_posts',
      'redirect' => false
    )
  );
}

// Service Custom Post Type Start
add_action('init', 'Services_custom_post_type');
function Services_custom_post_type()
{
  register_post_type(
    'service',
    array(
      'labels' => array(
        'name' => __("Services", 'textdomain'),
        'singular_name' => __("Service", 'textdomain'),
        'add_new' => __("Add Service"),
        'add_new_item' => __("Add Service"),
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'service', 'with_front' => false),
      'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
      'menu_icon' => 'dashicons-hammer', // Match icon for Services
    )
  );
}
// Service Custom Post Type End



// Project Custom Post Type Start
add_action('init', 'projects_custom_post_type');
function projects_custom_post_type()
{
  register_post_type(
    'project',
    array(
      'labels' => array(
        'name' => __("Projects", 'textdomain'),
        'singular_name' => __("Project", 'textdomain'),
        'add_new' => __("Add New Project"),
        'add_new_item' => __("Add New Project"),
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'project', 'with_front' => false),
      'supports' => array('title', 'editor', 'thumbnail'),
      'menu_icon' => 'dashicons-portfolio', // Match icon for Projects
    )
  );


  register_taxonomy(
    'project_category',  
    'project',           
    array(
      'hierarchical' => true,
      'labels' => array(
        'name' => _x('Project Categories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Project Category', 'taxonomy singular name', 'textdomain'),
        'search_items' =>  __("Search Project Categories", 'textdomain'),
        'all_items' => __("All Project Categories", 'textdomain'),
        'parent_item' => __("Parent Project Category", 'textdomain'),
        'parent_item_colon' => __("Parent Project Category:", 'textdomain'),
        'edit_item' => __("Edit Project Category", 'textdomain'),
        'update_item' => __("Update Project Category", 'textdomain'),
        'add_new_item' => __("Add New Project Category", 'textdomain'),
        'new_item_name' => __("New Project Category Name", 'textdomain'),
        'menu_name' => __("Project Categories", 'textdomain'),
      ),
      'rewrite' => array('slug' => 'project-category'),
      'show_admin_column' => true,
      'show_ui' => true,
      'query_var' => true,
      'public' => true,
      'capabilities' => array(
        'manage_terms' => 'manage_categories',
        'edit_terms' => 'edit_categories',
        'delete_terms' => 'delete_categories',
        'assign_terms' => 'assign_categories',
      ),
    )
  );
}
// Project Custom Post Type End