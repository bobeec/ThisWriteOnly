<?php
/**
 * BLOGthemeWP functions and definitions
 *
 * 極限まで簡素化されたブログ専用テーマ
 * 「書くこと。読んでもらうこと。」を追求
 *
 * @package BLOGthemeWP
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define theme constants
 */
define( 'BLOGTHEMEWP_VERSION', '1.0.0' );
define( 'BLOGTHEMEWP_DIR', get_template_directory() );
define( 'BLOGTHEMEWP_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function blogthemewp_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'blogthemewp', BLOGTHEMEWP_DIR . '/languages' );

    // Add default posts and comments RSS feed links
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 630, true );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom header image support
    add_theme_support( 'custom-header', array(
        'default-image'      => '',
        'width'              => 1920,
        'height'             => 300,
        'flex-width'         => true,
        'flex-height'        => true,
        'header-text'        => false,
    ) );

    // Register navigation menu
    register_nav_menus( array(
        'primary' => esc_html__( 'メインメニュー', 'blogthemewp' ),
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Block editor support
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );

    // Editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Disable custom colors and gradients for simplicity
    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-gradients' );
    
    // Editor color palette - minimal
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Primary', 'blogthemewp' ),
            'slug'  => 'primary',
            'color' => get_theme_mod( 'blogthemewp_primary_color', '#1a8917' ),
        ),
        array(
            'name'  => __( 'Black', 'blogthemewp' ),
            'slug'  => 'black',
            'color' => '#292929',
        ),
        array(
            'name'  => __( 'Gray', 'blogthemewp' ),
            'slug'  => 'gray',
            'color' => '#6b6b6b',
        ),
        array(
            'name'  => __( 'Light Gray', 'blogthemewp' ),
            'slug'  => 'light-gray',
            'color' => '#fafafa',
        ),
        array(
            'name'  => __( 'White', 'blogthemewp' ),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ) );

    // Font sizes - minimal options
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( '小', 'blogthemewp' ),
            'size' => 14,
            'slug' => 'small',
        ),
        array(
            'name' => __( '標準', 'blogthemewp' ),
            'size' => 17,
            'slug' => 'normal',
        ),
        array(
            'name' => __( '大', 'blogthemewp' ),
            'size' => 20,
            'slug' => 'large',
        ),
    ) );
}
add_action( 'after_setup_theme', 'blogthemewp_setup' );

/**
 * Enqueue scripts and styles
 */
function blogthemewp_scripts() {
    // Main stylesheet
    wp_enqueue_style( 
        'blogthemewp-style', 
        get_stylesheet_uri(), 
        array(), 
        BLOGTHEMEWP_VERSION 
    );

    // Add inline CSS for customizer settings
    $custom_css = blogthemewp_get_custom_css();
    wp_add_inline_style( 'blogthemewp-style', $custom_css );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'blogthemewp_scripts' );

/**
 * Generate custom CSS from customizer settings
 */
function blogthemewp_get_custom_css() {
    $primary_color = get_theme_mod( 'blogthemewp_primary_color', '#1a8917' );
    
    // Calculate lighter and darker versions
    $primary_light = blogthemewp_adjust_brightness( $primary_color, 0.9 );
    $primary_dark = blogthemewp_adjust_brightness( $primary_color, -0.2 );

    $css = "
        :root {
            --blog-primary: {$primary_color};
            --blog-primary-light: {$primary_light};
            --blog-primary-dark: {$primary_dark};
        }
    ";

    return $css;
}

/**
 * Adjust color brightness
 */
function blogthemewp_adjust_brightness( $hex, $percent ) {
    $hex = ltrim( $hex, '#' );
    
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    
    if ( $percent > 0 ) {
        // Lighten
        $r = round( $r + ( 255 - $r ) * $percent );
        $g = round( $g + ( 255 - $g ) * $percent );
        $b = round( $b + ( 255 - $b ) * $percent );
    } else {
        // Darken
        $r = round( $r * ( 1 + $percent ) );
        $g = round( $g * ( 1 + $percent ) );
        $b = round( $b * ( 1 + $percent ) );
    }
    
    return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Customizer settings
 */
function blogthemewp_customize_register( $wp_customize ) {
    
    // BLOGthemeWP Section
    $wp_customize->add_section( 'blogthemewp_settings', array(
        'title'    => __( 'BLOGthemeWP 設定', 'blogthemewp' ),
        'priority' => 30,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'blogthemewp_primary_color', array(
        'default'           => '#1a8917',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogthemewp_primary_color', array(
        'label'    => __( 'メインカラー', 'blogthemewp' ),
        'description' => __( 'リンクやボタンに使用されるテーマカラーを選択してください。', 'blogthemewp' ),
        'section'  => 'blogthemewp_settings',
        'settings' => 'blogthemewp_primary_color',
    ) ) );

    // Site Icon is already built-in, just move it
    $wp_customize->get_control( 'site_icon' )->section = 'blogthemewp_settings';
    $wp_customize->get_control( 'site_icon' )->priority = 20;
    $wp_customize->get_control( 'site_icon' )->label = __( 'サイトアイコン', 'blogthemewp' );
    $wp_customize->get_control( 'site_icon' )->description = __( 'ブログのアイコンをアップロードしてください（512×512px推奨）', 'blogthemewp' );

    // Custom Header is already registered, just update labels
    $wp_customize->get_section( 'header_image' )->title = __( 'ヘッダー画像', 'blogthemewp' );
    $wp_customize->get_section( 'header_image' )->priority = 35;

    // Hide unnecessary sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
}
add_action( 'customize_register', 'blogthemewp_customize_register' );

/**
 * Customizer live preview
 */
function blogthemewp_customize_preview_js() {
    wp_enqueue_script( 
        'blogthemewp-customizer', 
        BLOGTHEMEWP_URI . '/assets/js/customizer.js', 
        array( 'customize-preview' ), 
        BLOGTHEMEWP_VERSION, 
        true 
    );
}
add_action( 'customize_preview_init', 'blogthemewp_customize_preview_js' );

/**
 * Simplify Block Editor
 * Remove unnecessary blocks for a cleaner writing experience
 */
function blogthemewp_allowed_block_types( $allowed_blocks, $editor_context ) {
    // Only apply to posts and pages
    if ( ! empty( $editor_context->post ) ) {
        return array(
            // Text blocks - Essential
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/list-item',
            'core/quote',
            'core/code',
            'core/preformatted',
            
            // Media blocks - Essential
            'core/image',
            'core/gallery',
            'core/video',
            'core/embed',
            
            // Embed variations
            'core-embed/youtube',
            'core-embed/twitter',
            'core-embed/instagram',
            
            // Layout blocks - Minimal
            'core/separator',
            'core/spacer',
            'core/group',
            
            // Other essentials
            'core/html',
            'core/shortcode',
        );
    }
    
    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'blogthemewp_allowed_block_types', 10, 2 );

/**
 * Remove unnecessary block patterns
 */
function blogthemewp_remove_block_patterns() {
    remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'blogthemewp_remove_block_patterns' );

/**
 * Disable remote block patterns
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Simplify editor interface
 */
function blogthemewp_editor_settings( $settings ) {
    // Disable openverse media
    $settings['enableOpenverseMediaCategory'] = false;
    
    // Disable template editing
    $settings['supportsTemplateMode'] = false;
    
    return $settings;
}
add_filter( 'block_editor_settings_all', 'blogthemewp_editor_settings' );

/**
 * Add editor styles
 */
function blogthemewp_block_editor_styles() {
    wp_enqueue_style(
        'blogthemewp-editor-style',
        BLOGTHEMEWP_URI . '/assets/css/editor-style.css',
        array(),
        BLOGTHEMEWP_VERSION
    );
    
    // Add custom CSS to editor
    $custom_css = blogthemewp_get_custom_css();
    wp_add_inline_style( 'blogthemewp-editor-style', $custom_css );
}
add_action( 'enqueue_block_editor_assets', 'blogthemewp_block_editor_styles' );

/**
 * SEO: Add meta description
 */
function blogthemewp_meta_description() {
    if ( is_single() || is_page() ) {
        global $post;
        $description = wp_strip_all_tags( get_the_excerpt( $post ), true );
        if ( empty( $description ) ) {
            $description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '...' );
        }
    } elseif ( is_home() || is_front_page() ) {
        $description = get_bloginfo( 'description' );
    } elseif ( is_category() ) {
        $description = category_description();
    } elseif ( is_tag() ) {
        $description = tag_description();
    } elseif ( is_author() ) {
        $description = get_the_author_meta( 'description' );
    } else {
        $description = get_bloginfo( 'description' );
    }
    
    if ( ! empty( $description ) ) {
        $description = esc_attr( wp_trim_words( $description, 25, '...' ) );
        echo '<meta name="description" content="' . $description . '">' . "\n";
    }
}
add_action( 'wp_head', 'blogthemewp_meta_description', 1 );

/**
 * SEO: Add Open Graph meta tags
 */
function blogthemewp_open_graph() {
    global $post;
    
    // OG Type
    $og_type = is_single() ? 'article' : 'website';
    echo '<meta property="og:type" content="' . $og_type . '">' . "\n";
    
    // Site name
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    
    // URL
    if ( is_singular() ) {
        echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '">' . "\n";
    } else {
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    }
    
    // Title
    if ( is_singular() ) {
        echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
    } else {
        echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    }
    
    // Description
    if ( is_singular() ) {
        $description = wp_strip_all_tags( get_the_excerpt( $post ), true );
        if ( empty( $description ) ) {
            $description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '...' );
        }
    } else {
        $description = get_bloginfo( 'description' );
    }
    if ( ! empty( $description ) ) {
        echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    }
    
    // Image
    if ( is_singular() && has_post_thumbnail() ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        if ( $image ) {
            echo '<meta property="og:image" content="' . esc_url( $image[0] ) . '">' . "\n";
            echo '<meta property="og:image:width" content="' . esc_attr( $image[1] ) . '">' . "\n";
            echo '<meta property="og:image:height" content="' . esc_attr( $image[2] ) . '">' . "\n";
        }
    } elseif ( has_header_image() ) {
        echo '<meta property="og:image" content="' . esc_url( get_header_image() ) . '">' . "\n";
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'blogthemewp_open_graph', 2 );

/**
 * SEO: Add structured data (JSON-LD)
 */
function blogthemewp_structured_data() {
    if ( is_single() ) {
        global $post;
        
        $author = get_the_author();
        $published = get_the_date( 'c' );
        $modified = get_the_modified_date( 'c' );
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => $published,
            'dateModified' => $modified,
            'author' => array(
                '@type' => 'Person',
                'name' => $author,
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink(),
            ),
        );
        
        // Add image if exists
        if ( has_post_thumbnail() ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
            if ( $image ) {
                $schema['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $image[0],
                    'width' => $image[1],
                    'height' => $image[2],
                );
            }
        }
        
        // Add description
        $description = wp_strip_all_tags( get_the_excerpt( $post ), true );
        if ( ! empty( $description ) ) {
            $schema['description'] = $description;
        }
        
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
        echo "\n</script>\n";
    }
}
add_action( 'wp_head', 'blogthemewp_structured_data', 3 );

/**
 * Remove unnecessary head elements
 */
function blogthemewp_cleanup_head() {
    // Remove WordPress version
    remove_action( 'wp_head', 'wp_generator' );
    
    // Remove RSD link
    remove_action( 'wp_head', 'rsd_link' );
    
    // Remove wlwmanifest link
    remove_action( 'wp_head', 'wlwmanifest_link' );
    
    // Remove shortlink
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    
    // Remove REST API link
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    
    // Remove oEmbed discovery links
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}
add_action( 'init', 'blogthemewp_cleanup_head' );

/**
 * Disable emoji scripts
 */
function blogthemewp_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'blogthemewp_disable_emojis' );

/**
 * Custom excerpt length
 */
function blogthemewp_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'blogthemewp_excerpt_length' );

/**
 * Custom excerpt more
 */
function blogthemewp_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'blogthemewp_excerpt_more' );

/**
 * Register widget area (minimal)
 */
function blogthemewp_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'フッターウィジェット', 'blogthemewp' ),
        'id'            => 'footer-widget',
        'description'   => __( 'フッターに表示されるウィジェットエリアです。', 'blogthemewp' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'blogthemewp_widgets_init' );

/**
 * Add body classes
 */
function blogthemewp_body_classes( $classes ) {
    // Add singular class
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    
    // Add no-sidebar class (we don't use sidebars)
    $classes[] = 'no-sidebar';
    
    return $classes;
}
add_filter( 'body_class', 'blogthemewp_body_classes' );

/**
 * Get reading time
 */
function blogthemewp_reading_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field( 'post_content', $post_id );
    $word_count = mb_strlen( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 500 ); // 500 characters per minute for Japanese
    
    return max( 1, $reading_time );
}

/**
 * Display site icon or custom logo
 */
function blogthemewp_site_icon() {
    if ( has_site_icon() ) {
        $icon_url = get_site_icon_url( 80 );
        echo '<img src="' . esc_url( $icon_url ) . '" alt="" class="site-icon">';
    } elseif ( has_custom_logo() ) {
        the_custom_logo();
    }
}

/**
 * Remove admin bar inline styles on frontend
 */
function blogthemewp_remove_admin_bar_bump() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'blogthemewp_remove_admin_bar_bump' );

/**
 * Add admin bar spacing via CSS instead
 */
function blogthemewp_admin_bar_fix() {
    if ( is_admin_bar_showing() ) {
        echo '<style>
            .admin-bar .site-header { top: 32px; }
            @media screen and (max-width: 782px) {
                .admin-bar .site-header { top: 46px; }
            }
        </style>';
    }
}
add_action( 'wp_head', 'blogthemewp_admin_bar_fix', 100 );

/**
 * Include template functions
 */
require_once BLOGTHEMEWP_DIR . '/inc/template-functions.php';
require_once BLOGTHEMEWP_DIR . '/inc/template-tags.php';
