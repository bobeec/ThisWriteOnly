<?php
/**
 * BLOGthemeWP - 極限シンプルなブログテーマ
 * 
 * 「書くこと。読んでもらうこと。」
 *
 * @package BLOGthemeWP
 * @version 0.4.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BLOGTHEMEWP_VERSION', '0.4.1' );
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
    
    // WordPress.org推奨サポート
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
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
        'show_archive_yearly'    => array( 'label' => 'フッター：年別アーカイブ', 'default' => false ),
        'show_archive_monthly'   => array( 'label' => 'フッター：月別アーカイブ', 'default' => false ),
        'show_archive_category'  => array( 'label' => 'フッター：カテゴリー', 'default' => false ),
        'show_breadcrumb'        => array( 'label' => 'パンくずリスト', 'default' => true ),
        'show_modified_date'     => array( 'label' => '更新日（投稿日と異なる場合）', 'default' => true ),
    );
}

function blogthemewp_show( $option ) {
    $options = blogthemewp_get_display_options();
    $default = isset( $options[ $option ]['default'] ) ? $options[ $option ]['default'] : true;
    $value = get_theme_mod( 'blogthemewp_' . $option, 'not_set' );
    
    // 値が設定されていなければデフォルトを返す
    if ( $value === 'not_set' ) {
        return $default;
    }
    
    // 1ならtrue、0ならfalse
    return ( $value == 1 );
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
            // チェックボックスがオンなら1、オフなら0として保存
            $value = isset( $_POST[ 'blogthemewp_' . $key ] ) ? 1 : 0;
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
                    $is_checked = blogthemewp_show( $key );
                ?>
                <label style="display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                    <input type="checkbox" name="blogthemewp_<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $is_checked, true ); ?> style="margin-right: 12px;">
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
        
        <div style="font-size: 12px; color: #666; margin-top: 16px; padding: 12px; background: #e8f4e8; border-radius: 4px; border-left: 3px solid #4caf50;">
            <strong style="color: #2e7d32;">✓ テーマ内蔵SEO機能（プラグイン不要）</strong>
            <ul style="margin: 8px 0 0; padding-left: 16px; color: #50575e;">
                <li>メタディスクリプション自動生成</li>
                <li>OGP / Twitter Card 対応</li>
                <li>JSON-LD構造化データ（Article）</li>
                <li>canonical URL 出力</li>
                <li>パンくずリスト（構造化データ付き）</li>
            </ul>
        </div>
        
        <h4 style="font-size: 13px; font-weight: 600; margin: 16px 0 8px; color: #1d2327;">プラグインの提案</h4>
        <p style="font-size: 12px; color: #666; margin-bottom: 12px;">以下は必須ではありませんが、サイト運営に役立つプラグインです。</p>
        
        <div style="font-size: 12px; color: #50575e; line-height: 1.7;">
            <details style="margin-bottom: 8px;">
                <summary style="cursor: pointer; font-weight: 600; padding: 8px; background: #f8f9fa; border-radius: 4px;">📝 日本語対応</summary>
                <div style="padding: 8px 12px; background: #fff; border: 1px solid #e0e0e0; border-top: none; border-radius: 0 0 4px 4px;">
                    <strong>WP Multibyte Patch</strong><br>
                    日本語の文字数カウント・検索・トラックバックを正確に処理。日本語サイトには必須級。
                </div>
            </details>
            
            <details style="margin-bottom: 8px;">
                <summary style="cursor: pointer; font-weight: 600; padding: 8px; background: #f8f9fa; border-radius: 4px;">🔍 SEO・検索エンジン対策</summary>
                <div style="padding: 8px 12px; background: #fff; border: 1px solid #e0e0e0; border-top: none; border-radius: 0 0 4px 4px;">
                    <strong>XML Sitemaps</strong><br>
                    サイトマップを自動生成・検索エンジンに送信。テーマでは実装が難しい機能。<br><br>
                    <strong>Site Kit by Google</strong><br>
                    Search Console・Analytics・AdSense をWordPressから一元管理。アクセス解析に。
                </div>
            </details>
            
            <details style="margin-bottom: 8px;">
                <summary style="cursor: pointer; font-weight: 600; padding: 8px; background: #f8f9fa; border-radius: 4px;">🛡️ セキュリティ・バックアップ</summary>
                <div style="padding: 8px 12px; background: #fff; border: 1px solid #e0e0e0; border-top: none; border-radius: 0 0 4px 4px;">
                    <strong>UpdraftPlus</strong><br>
                    記事・設定・画像を自動バックアップ。クラウド保存・復元も簡単。<br><br>
                    <strong>Akismet</strong><br>
                    コメントスパムを自動判定・ブロック。コメント欄を開放するなら必須。
                </div>
            </details>
            
            <details style="margin-bottom: 8px;">
                <summary style="cursor: pointer; font-weight: 600; padding: 8px; background: #f8f9fa; border-radius: 4px;">⚡ パフォーマンス</summary>
                <div style="padding: 8px 12px; background: #fff; border: 1px solid #e0e0e0; border-top: none; border-radius: 0 0 4px 4px;">
                    <strong>WP Super Cache / LiteSpeed Cache</strong><br>
                    ページをキャッシュして高速表示。サーバー環境に合わせて選択。<br><br>
                    <strong>ShortPixel / Imagify</strong><br>
                    画像を自動圧縮・WebP変換。ページ読み込み速度を改善。
                </div>
            </details>
            
            <details style="margin-bottom: 8px;">
                <summary style="cursor: pointer; font-weight: 600; padding: 8px; background: #f8f9fa; border-radius: 4px;">🔧 サイト管理</summary>
                <div style="padding: 8px 12px; background: #fff; border: 1px solid #e0e0e0; border-top: none; border-radius: 0 0 4px 4px;">
                    <strong>Redirection</strong><br>
                    URL変更時のリダイレクト管理・404エラー監視。リンク切れ対策に。
                </div>
            </details>
        </div>
        
        <p style="font-size: 11px; color: #999; margin-top: 12px;">
            ※ すべてWordPress公式ディレクトリから無料でインストールできます。
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

/**
 * Canonical URL出力
 */
function blogthemewp_canonical_url() {
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
add_action( 'wp_head', 'blogthemewp_canonical_url', 1 );

/* Note: Head cleanup (wp_generator, rsd_link, etc.) removed for WordPress.org compliance.
 * These modifications are plugin territory. Use a security plugin if needed. */

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
