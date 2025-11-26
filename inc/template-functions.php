<?php
/**
 * Template Functions
 *
 * @package BLOGthemeWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add custom classes to post
 */
function blogthemewp_post_classes( $classes ) {
    if ( ! has_post_thumbnail() ) {
        $classes[] = 'no-thumbnail';
    }
    return $classes;
}
add_filter( 'post_class', 'blogthemewp_post_classes' );

/**
 * Modify main query for blog
 */
function blogthemewp_modify_main_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        // Set posts per page for archive
        if ( $query->is_home() || $query->is_archive() ) {
            $query->set( 'posts_per_page', 10 );
        }
    }
}
add_action( 'pre_get_posts', 'blogthemewp_modify_main_query' );

/**
 * Get author avatar URL
 */
function blogthemewp_get_author_avatar_url( $author_id, $size = 96 ) {
    return get_avatar_url( $author_id, array( 'size' => $size ) );
}

/**
 * Format post date in Japanese style
 */
function blogthemewp_format_date( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $timestamp = get_the_date( 'U', $post_id );
    $now = current_time( 'timestamp' );
    $diff = $now - $timestamp;
    
    // Within last 24 hours
    if ( $diff < DAY_IN_SECONDS ) {
        $hours = floor( $diff / HOUR_IN_SECONDS );
        if ( $hours < 1 ) {
            return __( 'たった今', 'blogthemewp' );
        }
        return sprintf( __( '%s時間前', 'blogthemewp' ), $hours );
    }
    
    // Within last 7 days
    if ( $diff < WEEK_IN_SECONDS ) {
        $days = floor( $diff / DAY_IN_SECONDS );
        return sprintf( __( '%s日前', 'blogthemewp' ), $days );
    }
    
    // Default: formatted date
    return get_the_date( 'Y年n月j日', $post_id );
}

/**
 * Check if page should show header image
 */
function blogthemewp_should_show_header_image() {
    if ( ! has_header_image() ) {
        return false;
    }
    
    // Only show on home and archive pages
    if ( is_home() || is_front_page() || is_archive() ) {
        return true;
    }
    
    return false;
}

/**
 * Generate archive title without prefix
 */
function blogthemewp_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    } elseif ( is_year() ) {
        $title = get_the_date( 'Y年' );
    } elseif ( is_month() ) {
        $title = get_the_date( 'Y年n月' );
    } elseif ( is_day() ) {
        $title = get_the_date( 'Y年n月j日' );
    }
    
    return $title;
}
add_filter( 'get_the_archive_title', 'blogthemewp_archive_title' );

/**
 * Add pingback header
 */
function blogthemewp_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'blogthemewp_pingback_header' );
