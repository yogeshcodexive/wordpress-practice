<?php

namespace Curious\Extras;

use Curious\Setup;

if ( !class_exists( 'WPSEO_Frontend' ) ) {
  remove_action( 'wp_head', 'rel_canonical' );
  add_action( 'wp_head', __NAMESPACE__ . '\\rel_canonical' );
}

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' ';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);

  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);

  return $excerpt;
}

add_action('excerpt', __NAMESPACE__ . '\\excerpt');


function get_page_links( $args = '' ) {
  $defaults = array(
      'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
      'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
      'total' => 1,
      'current' => 0,
      'show_all' => false,
      'prev_next' => true,
      'prev_text' => __('&laquo; Previous'),
      'next_text' => __('Next &raquo;'),
      'end_size' => 3,
      'mid_size' => 2,
      'type' => 'plain',
      'add_args' => false, // array of query args to add
      'add_fragment' => ''
  );

  $args = wp_parse_args( $args, $defaults );
  extract($args, EXTR_SKIP);

  // Who knows what else people pass in $args
  $total = (int) $total;
  if ( $total < 2 )
    return;
  $current  = (int) $current;
  $end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
  $mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
  $add_args = is_array($add_args) ? $add_args : false;
  $r = '';
  $page_links = array();
  $n = 0;
  $dots = false;

  if ( $prev_next && $current && 0 < $current ) :
    $link = str_replace('%_%', 2 == $current ? '' : $format, $base);
    $link = str_replace('%#%', $current - 1, $link);
    if ( $add_args )
      $link = add_query_arg( $add_args, $link );
    $link .= $add_fragment;
    $page_links[] = '<a class="prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">
       <i class="pagination-arrow"></i></a>';
  endif;
  for ( $n = 1; $n <= $total; $n++ ) :
    $n_display = number_format_i18n($n);
    if ( $n == $current  AND  $n != $total) :
      $page_links[] = "<span class='page-numbers current'>$n_display</span>";
      $dots = true;
    elseif ( $n == $current  AND  $n == $total) :
      $page_links[] = "<span class='page-numbers current'>$n_display</span>";
      $dots = true;
    else :
      if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
        $link = str_replace('%_%', 1 == $n ? '' : $format, $base);
        $link = str_replace('%#%', $n, $link);
        if ( $add_args )
          $link = add_query_arg( $add_args, $link );
        $link .= $add_fragment;
        if ( $n == $total ) :
          $page_links[] = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>$n_display</a>";
        else :
          $page_links[] = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>$n_display</a>";
        endif;
        $dots = true;
      elseif ( $dots && !$show_all ) :
        $page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
        $dots = false;
      endif;
    endif;
  endfor;
  if ( $prev_next && $current ) :
    $link = str_replace('%_%', $format, $base);
    $link = str_replace('%#%', $current + 1, $link);
    if ( $add_args )
      $link = add_query_arg( $add_args, $link );
    $link .= $add_fragment;

    $page_links[] = '<a class="next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"> <i class="pagination-arrow"></i>
        </a>';
  endif;
  switch ( $type ) :
    case 'array' :
      return $page_links;
      break;
    case 'list' :
      $r .= "<ul class='pagination'>\n\t<li>";
      $r .= join("</li>\n\t<li>", $page_links);
      $r .= "</li>\n</ul>\n";
      break;
    default :
      $r = join("\n", $page_links);
      break;
  endswitch;
  return $r;
}


function rel_canonical() {
  global $wp_the_query;

  if ( !is_singular() ) {
    return;
  }

  if ( !$id = $wp_the_query->get_queried_object_id() ) {
    return;
  }

  $link = get_permalink( $id );

  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}