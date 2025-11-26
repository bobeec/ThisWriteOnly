<?php
/**
 * BLOGthemeWP - 極限シンプルなブログテーマ
 * 
 * 「書くこと。読んでもらうこと。」
 *
 * @package BLOGthemeWP
 * @version 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BLOGTHEMEWP_VERSION', '0.2.0' );
define( 'BLOGTHEMEWP_DIR', get_template_directory() );
define( 'BLOGTHEMEWP_URI', get_template_directory_uri() );

/*----------------------------------------------------------
 * テーマセットアップ
 *----------------------------------------------------------*/
function blogthemewp_setup() {
    load_theme_textdomain( 'blogthemewp', BLOGTHEMEWP_DIR . '/languages' );
    
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );
    
    // ナビメニュー（1つだけ）
    register_nav_menus( array( 'primary' => __( 'メニュー', 'blogthemewp' ) ) );
    
    // ブロックエディタをシンプルに
    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-gradients' );
    add_theme_support( 'disable-custom-font-sizes' );
    remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'blogthemewp_setup' );

/*----------------------------------------------------------
 * スタイル・スクリプト読み込み
 *----------------------------------------------------------*/
function blogthemewp_scripts() {
    // Google Fonts - Noto Sans JP（シンプルで読みやすい）
    wp_enqueue_style( 
        'blogthemewp-fonts', 
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap',
        array(),
        null
    );
    
    wp_enqueue_style( 'blogthemewp-style', get_stylesheet_uri(), array( 'blogthemewp-fonts' ), BLOGTHEMEWP_VERSION );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'blogthemewp_scripts' );

/*----------------------------------------------------------
 * テーマ設定（シンプルな表示/非表示トグルのみ）
 *----------------------------------------------------------*/
function blogthemewp_get_display_options() {
    return array(
        'show_header'       => array( 'label' => 'ヘッダー', 'default' => true ),
        'show_site_icon'    => array( 'label' => 'サイトアイコン', 'default' => true ),
        'show_site_title'   => array( 'label' => 'サイトタイトル', 'default' => true ),
        'show_navigation'   => array( 'label' => 'ナビゲーション', 'default' => true ),
        'show_post_date'    => array( 'label' => '投稿日', 'default' => true ),
        'show_author'       => array( 'label' => '著者名', 'default' => true ),
        'show_reading_time' => array( 'label' => '読了時間', 'default' => true ),
        'show_categories'   => array( 'label' => 'カテゴリー', 'default' => true ),
        'show_tags'         => array( 'label' => 'タグ', 'default' => false ),
        'show_author_box'   => array( 'label' => '著者ボックス', 'default' => true ),
        'show_post_nav'     => array( 'label' => '前後の記事リンク', 'default' => true ),
        'show_comments'     => array( 'label' => 'コメント', 'default' => true ),
        'show_footer'       => array( 'label' => 'フッター', 'default' => true ),
    );
}

function blogthemewp_show( $option ) {
    $options = blogthemewp_get_display_options();
    $default = isset( $options[ $option ]['default'] ) ? $options[ $option ]['default'] : true;
    return get_theme_mod( 'blogthemewp_' . $option, $default );
}

/*----------------------------------------------------------
 * 管理画面：テーマ設定ページ
 *----------------------------------------------------------*/
function blogthemewp_admin_menu() {
    add_theme_page(
        'BLOGthemeWP 設定',
        'BLOGthemeWP',
        'edit_theme_options',
        'blogthemewp-settings',
        'blogthemewp_settings_page'
    );
}
add_action( 'admin_menu', 'blogthemewp_admin_menu' );

function blogthemewp_settings_page() {
    if ( isset( $_POST['blogthemewp_save'] ) && check_admin_referer( 'blogthemewp_settings' ) ) {
        $options = blogthemewp_get_display_options();
        foreach ( $options as $key => $opt ) {
            $value = isset( $_POST[ 'blogthemewp_' . $key ] ) ? true : false;
            set_theme_mod( 'blogthemewp_' . $key, $value );
        }
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
    }
    
    $options = blogthemewp_get_display_options();
    ?>
    <div class="wrap" style="max-width: 600px;">
        <h1 style="font-weight: 400; margin-bottom: 30px;">BLOGthemeWP 設定</h1>
        
        <form method="post">
            <?php wp_nonce_field( 'blogthemewp_settings' ); ?>
            
            <div style="background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 16px; font-weight: 600; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid #e0e0e0;">表示項目</h2>
                
                <p style="color: #666; font-size: 13px; margin-bottom: 20px;">表示する項目にチェックを入れてください。</p>
                
                <?php foreach ( $options as $key => $opt ) : 
                    $checked = blogthemewp_show( $key ) ? 'checked' : '';
                ?>
                <label style="display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                    <input type="checkbox" name="blogthemewp_<?php echo esc_attr( $key ); ?>" <?php echo $checked; ?> style="margin-right: 12px;">
                    <span style="font-size: 14px;"><?php echo esc_html( $opt['label'] ); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            
            <p style="margin-top: 20px;">
                <button type="submit" name="blogthemewp_save" class="button button-primary" style="padding: 8px 24px;">保存</button>
            </p>
        </form>
    </div>
    <?php
}

/*----------------------------------------------------------
 * ダッシュボードウィジェット：使い方ガイド
 *----------------------------------------------------------*/
function blogthemewp_dashboard_widget() {
    wp_add_dashboard_widget(
        'blogthemewp_guide',
        'BLOGthemeWP - 使い方ガイド',
        'blogthemewp_dashboard_widget_content'
    );
}
add_action( 'wp_dashboard_setup', 'blogthemewp_dashboard_widget' );

function blogthemewp_dashboard_widget_content() {
    $is_minimized = get_user_meta( get_current_user_id(), 'blogthemewp_widget_minimized', true );
    ?>
    <div id="blogthemewp-guide" style="<?php echo $is_minimized ? 'display:none;' : ''; ?>">
        <p style="font-size: 14px; color: #333; line-height: 1.8; margin-bottom: 16px;">
            <strong>BLOGthemeWP</strong>は「書くこと」と「読むこと」に集中するためのシンプルなテーマです。
        </p>
        
        <h4 style="font-size: 13px; font-weight: 600; margin: 16px 0 8px; color: #1d2327;">基本の使い方</h4>
        <ol style="font-size: 13px; color: #50575e; line-height: 1.8; margin: 0; padding-left: 20px;">
            <li><a href="<?php echo admin_url( 'themes.php?page=blogthemewp-settings' ); ?>">外観 → BLOGthemeWP</a> で表示項目を設定</li>
            <li><a href="<?php echo admin_url( 'nav-menus.php' ); ?>">外観 → メニュー</a> でナビゲーションを作成</li>
            <li><a href="<?php echo admin_url( 'options-general.php' ); ?>">設定 → 一般</a> でサイト名を設定</li>
            <li><a href="<?php echo admin_url( 'options-general.php#site_icon_preview' ); ?>">設定 → 一般</a> でサイトアイコンを設定</li>
            <li>あとは記事を書くだけ！</li>
        </ol>
        
        <h4 style="font-size: 13px; font-weight: 600; margin: 16px 0 8px; color: #1d2327;">推奨プラグイン</h4>
        <ul style="font-size: 13px; color: #50575e; line-height: 1.8; margin: 0; padding-left: 20px;">
            <li><strong>WP Multibyte Patch</strong> - 日本語環境の最適化</li>
            <li><strong>XML Sitemaps</strong> - サイトマップ自動生成</li>
            <li><strong>UpdraftPlus</strong> - バックアップ</li>
            <li><strong>Akismet</strong> - スパム対策</li>
        </ul>
        
        <p style="font-size: 12px; color: #999; margin-top: 16px; padding-top: 12px; border-top: 1px solid #e0e0e0;">
            ヒント：このテーマはSEO対応済み（メタタグ・OGP・構造化データ自動出力）。SEOプラグインは不要です。
        </p>
    </div>
    
    <div id="blogthemewp-guide-minimized" style="<?php echo $is_minimized ? '' : 'display:none;'; ?>">
        <p style="font-size: 13px; color: #666; margin: 0;">
            ガイドは最小化されています。
        </p>
    </div>
    
    <p style="margin: 12px 0 0; text-align: right;">
        <button type="button" id="blogthemewp-toggle-guide" class="button button-small">
            <?php echo $is_minimized ? '展開' : '最小化'; ?>
        </button>
    </p>
    
    <script>
    jQuery(function($) {
        $('#blogthemewp-toggle-guide').on('click', function() {
            var $guide = $('#blogthemewp-guide');
            var $mini = $('#blogthemewp-guide-minimized');
            var $btn = $(this);
            
            if ($guide.is(':visible')) {
                $guide.slideUp(200);
                $mini.slideDown(200);
                $btn.text('展開');
                $.post(ajaxurl, { action: 'blogthemewp_toggle_widget', minimized: 1 });
            } else {
                $guide.slideDown(200);
                $mini.slideUp(200);
                $btn.text('最小化');
                $.post(ajaxurl, { action: 'blogthemewp_toggle_widget', minimized: 0 });
            }
        });
    });
    </script>
    <?php
}

function blogthemewp_toggle_widget() {
    $minimized = isset( $_POST['minimized'] ) ? intval( $_POST['minimized'] ) : 0;
    update_user_meta( get_current_user_id(), 'blogthemewp_widget_minimized', $minimized );
    wp_die();
}
add_action( 'wp_ajax_blogthemewp_toggle_widget', 'blogthemewp_toggle_widget' );

/*----------------------------------------------------------
 * ブロックエディタをシンプル化
 *----------------------------------------------------------*/
function blogthemewp_allowed_block_types( $allowed_blocks, $editor_context ) {
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
            'core/html',
        );
    }
    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'blogthemewp_allowed_block_types', 10, 2 );
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/*----------------------------------------------------------
 * SEO（自動出力）
 *----------------------------------------------------------*/
function blogthemewp_seo_head() {
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
    
    // JSON-LD（投稿のみ）
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
add_action( 'wp_head', 'blogthemewp_seo_head', 1 );

/*----------------------------------------------------------
 * 不要なhead要素を削除
 *----------------------------------------------------------*/
function blogthemewp_cleanup() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'blogthemewp_cleanup' );

/*----------------------------------------------------------
 * ユーティリティ
 *----------------------------------------------------------*/
function blogthemewp_reading_time( $post_id = null ) {
    $content = get_post_field( 'post_content', $post_id ?: get_the_ID() );
    return max( 1, ceil( mb_strlen( strip_tags( $content ) ) / 500 ) );
}

function blogthemewp_site_icon() {
    if ( has_site_icon() ) {
        echo '<img src="' . esc_url( get_site_icon_url( 80 ) ) . '" alt="" class="site-icon">';
    }
}

/*----------------------------------------------------------
 * テンプレート関数読み込み
 *----------------------------------------------------------*/
require_once BLOGTHEMEWP_DIR . '/inc/template-tags.php';
