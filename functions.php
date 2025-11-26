<?php
/**
 * ThisWriteOnly - A minimal blog theme focused on writing
 * 
 * Write. Read. That's it.
 *
 * @package ThisWriteOnly
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'THISWRITEONLY_VERSION', '1.0.1' );
define( 'THISWRITEONLY_DIR', get_template_directory() );
define( 'THISWRITEONLY_URI', get_template_directory_uri() );

/*----------------------------------------------------------
 * Theme Setup
 *----------------------------------------------------------*/
function thiswriteonly_setup() {
    load_theme_textdomain( 'thiswriteonly', THISWRITEONLY_DIR . '/languages' );
    
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );
    
    // Navigation menu
    register_nav_menus( array( 'primary' => __( 'Primary Menu', 'thiswriteonly' ) ) );
    
    // WordPress.org recommended supports
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'thiswriteonly_setup' );

/*----------------------------------------------------------
 * Enqueue Styles & Scripts
 *----------------------------------------------------------*/
function thiswriteonly_scripts() {
    // Google Fonts - Noto Sans JP
    wp_enqueue_style( 
        'thiswriteonly-fonts', 
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap',
        array(),
        null
    );
    
    wp_enqueue_style( 'thiswriteonly-style', get_stylesheet_uri(), array( 'thiswriteonly-fonts' ), THISWRITEONLY_VERSION );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'thiswriteonly_scripts' );

/*----------------------------------------------------------
 * Display Options
 *----------------------------------------------------------*/
function thiswriteonly_get_display_options() {
    return array(
        'show_header'            => array( 'label' => __( 'Show Header', 'thiswriteonly' ), 'default' => true ),
        'show_site_icon'         => array( 'label' => __( 'Show Site Icon', 'thiswriteonly' ), 'default' => true ),
        'show_site_title'        => array( 'label' => __( 'Show Site Title', 'thiswriteonly' ), 'default' => true ),
        'show_navigation'        => array( 'label' => __( 'Show Navigation', 'thiswriteonly' ), 'default' => true ),
        'show_post_date'         => array( 'label' => __( 'Show Post Date', 'thiswriteonly' ), 'default' => true ),
        'show_author'            => array( 'label' => __( 'Show Author', 'thiswriteonly' ), 'default' => true ),
        'show_reading_time'      => array( 'label' => __( 'Show Reading Time', 'thiswriteonly' ), 'default' => true ),
        'show_categories'        => array( 'label' => __( 'Show Categories', 'thiswriteonly' ), 'default' => true ),
        'show_tags'              => array( 'label' => __( 'Show Tags', 'thiswriteonly' ), 'default' => false ),
        'show_author_box'        => array( 'label' => __( 'Show Author Box', 'thiswriteonly' ), 'default' => true ),
        'show_post_nav'          => array( 'label' => __( 'Show Post Navigation', 'thiswriteonly' ), 'default' => true ),
        'show_comments'          => array( 'label' => __( 'Show Comments', 'thiswriteonly' ), 'default' => true ),
        'show_footer'            => array( 'label' => __( 'Show Footer', 'thiswriteonly' ), 'default' => true ),
        'show_archive_yearly'    => array( 'label' => __( 'Footer: Yearly Archives', 'thiswriteonly' ), 'default' => false ),
        'show_archive_monthly'   => array( 'label' => __( 'Footer: Monthly Archives', 'thiswriteonly' ), 'default' => false ),
        'show_archive_category'  => array( 'label' => __( 'Footer: Categories', 'thiswriteonly' ), 'default' => false ),
        'show_breadcrumb'        => array( 'label' => __( 'Show Breadcrumb', 'thiswriteonly' ), 'default' => true ),
        'show_modified_date'     => array( 'label' => __( 'Show Modified Date', 'thiswriteonly' ), 'default' => true ),
    );
}

function thiswriteonly_show( $option ) {
    $options = thiswriteonly_get_display_options();
    $default = isset( $options[ $option ]['default'] ) ? $options[ $option ]['default'] : true;
    return get_theme_mod( 'thiswriteonly_' . $option, $default );
}

/*----------------------------------------------------------
 * Customizer Settings
 *----------------------------------------------------------*/
function thiswriteonly_customize_register( $wp_customize ) {
    // Add Theme Panel
    $wp_customize->add_panel( 'thiswriteonly_panel', array(
        'title'    => __( 'ThisWriteOnly Settings', 'thiswriteonly' ),
        'priority' => 30,
    ) );
    
    // Display Options Section
    $wp_customize->add_section( 'thiswriteonly_display', array(
        'title'    => __( 'Display Options', 'thiswriteonly' ),
        'panel'    => 'thiswriteonly_panel',
        'priority' => 10,
    ) );
    
    // Add display toggle settings
    $options = thiswriteonly_get_display_options();
    $priority = 10;
    
    foreach ( $options as $key => $opt ) {
        $wp_customize->add_setting( 'thiswriteonly_' . $key, array(
            'default'           => $opt['default'],
            'sanitize_callback' => 'thiswriteonly_sanitize_checkbox',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( 'thiswriteonly_' . $key, array(
            'label'    => $opt['label'],
            'section'  => 'thiswriteonly_display',
            'type'     => 'checkbox',
            'priority' => $priority,
        ) );
        
        $priority += 10;
    }
    
    // Editor Options Section
    $wp_customize->add_section( 'thiswriteonly_editor', array(
        'title'    => __( 'Editor Options', 'thiswriteonly' ),
        'panel'    => 'thiswriteonly_panel',
        'priority' => 20,
    ) );
    
    // Simple Editor Mode (block restriction)
    $wp_customize->add_setting( 'thiswriteonly_simple_editor', array(
        'default'           => false,
        'sanitize_callback' => 'thiswriteonly_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'thiswriteonly_simple_editor', array(
        'label'       => __( 'Simple Editor Mode', 'thiswriteonly' ),
        'description' => __( 'Limit available blocks to essential ones only (paragraph, heading, list, quote, image, etc.)', 'thiswriteonly' ),
        'section'     => 'thiswriteonly_editor',
        'type'        => 'checkbox',
    ) );
}
add_action( 'customize_register', 'thiswriteonly_customize_register' );

function thiswriteonly_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/*----------------------------------------------------------
 * Block Editor - Simple Mode (Optional)
 *----------------------------------------------------------*/
function thiswriteonly_allowed_block_types( $allowed_blocks, $editor_context ) {
    // Only restrict blocks if Simple Editor Mode is enabled
    if ( ! get_theme_mod( 'thiswriteonly_simple_editor', false ) ) {
        return $allowed_blocks;
    }
    
    if ( ! empty( $editor_context->post ) ) {
        return array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/list-item',
            'core/quote',
            'core/code',
            'core/image',
            'core/gallery',
            'core/video',
            'core/embed',
            'core/separator',
            'core/spacer',
            'core/html',
            'core/table',
            'core/buttons',
            'core/button',
        );
    }
    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'thiswriteonly_allowed_block_types', 10, 2 );

/*----------------------------------------------------------
 * SEO Features (Built-in)
 *----------------------------------------------------------*/
function thiswriteonly_seo_head() {
    global $post;
    
    // Description
    $desc = '';
    if ( is_singular() && $post ) {
        $desc = get_the_excerpt( $post );
        if ( empty( $desc ) ) {
            $desc = wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );
        }
    } elseif ( is_home() || is_front_page() ) {
        $desc = get_bloginfo( 'description' );
    }
    
    if ( $desc ) {
        echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
    }
    
    // OGP
    echo '<meta property="og:type" content="' . ( is_single() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( is_singular() ? get_permalink() : home_url() ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( is_singular() ? get_the_title() : get_bloginfo( 'name' ) ) . '">' . "\n";
    if ( $desc ) {
        echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
    }
    if ( is_singular() && has_post_thumbnail() ) {
        echo '<meta property="og:image" content="' . esc_url( get_the_post_thumbnail_url( null, 'large' ) ) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    
    // JSON-LD (posts only)
    if ( is_single() && $post ) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date( 'c' ),
            'dateModified' => get_the_modified_date( 'c' ),
            'author' => array( '@type' => 'Person', 'name' => get_the_author() ),
            'publisher' => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ),
        );
        if ( has_post_thumbnail() ) {
            $schema['image'] = get_the_post_thumbnail_url( null, 'large' );
        }
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'thiswriteonly_seo_head', 1 );

/**
 * Canonical URL
 */
function thiswriteonly_canonical_url() {
    if ( is_singular() ) {
        echo '<link rel="canonical" href="' . esc_url( get_permalink() ) . '">' . "\n";
    } elseif ( is_home() || is_front_page() ) {
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    } elseif ( is_category() ) {
        echo '<link rel="canonical" href="' . esc_url( get_category_link( get_queried_object_id() ) ) . '">' . "\n";
    } elseif ( is_tag() ) {
        echo '<link rel="canonical" href="' . esc_url( get_tag_link( get_queried_object_id() ) ) . '">' . "\n";
    } elseif ( is_author() ) {
        echo '<link rel="canonical" href="' . esc_url( get_author_posts_url( get_queried_object_id() ) ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'thiswriteonly_canonical_url', 1 );

/*----------------------------------------------------------
 * Utility Functions
 *----------------------------------------------------------*/
function thiswriteonly_reading_time( $post_id = null ) {
    $content = get_post_field( 'post_content', $post_id ?: get_the_ID() );
    return max( 1, ceil( mb_strlen( strip_tags( $content ) ) / 500 ) );
}

function thiswriteonly_site_icon() {
    if ( has_site_icon() ) {
        echo '<img src="' . esc_url( get_site_icon_url( 80 ) ) . '" alt="" class="site-icon">';
    }
}

/*----------------------------------------------------------
 * Template Tags
 *----------------------------------------------------------*/
require_once THISWRITEONLY_DIR . '/inc/template-tags.php';
