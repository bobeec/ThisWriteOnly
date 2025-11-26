<?php
/**
 * テンプレートタグ
 *
 * @package BLOGthemeWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 投稿日
 */
function blogthemewp_posted_on() {
    if ( ! blogthemewp_show( 'show_post_date' ) ) return;
    
    echo '<time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">';
    echo esc_html( get_the_date() );
    echo '</time>';
}

/**
 * 著者名
 */
function blogthemewp_posted_by() {
    if ( ! blogthemewp_show( 'show_author' ) ) return;
    
    echo '<span class="author">';
    echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">';
    echo esc_html( get_the_author() );
    echo '</a></span>';
}

/**
 * 読了時間
 */
function blogthemewp_reading_time_display() {
    if ( ! blogthemewp_show( 'show_reading_time' ) ) return;
    
    $time = blogthemewp_reading_time();
    echo '<span class="reading-time">' . sprintf( __( '%s分で読める', 'blogthemewp' ), $time ) . '</span>';
}

/**
 * カテゴリー・タグ
 */
function blogthemewp_entry_footer() {
    if ( get_post_type() !== 'post' ) return;
    
    if ( blogthemewp_show( 'show_categories' ) ) {
        $cats = get_the_category_list( ', ' );
        if ( $cats ) {
            echo '<span class="cat-links">' . $cats . '</span>';
        }
    }
    
    if ( blogthemewp_show( 'show_tags' ) ) {
        $tags = get_the_tag_list( '', ', ' );
        if ( $tags ) {
            echo '<span class="tags-links">' . $tags . '</span>';
        }
    }
}

/**
 * 著者ボックス
 */
function blogthemewp_author_box() {
    if ( ! blogthemewp_show( 'show_author_box' ) ) return;
    
    $bio = get_the_author_meta( 'description' );
    ?>
    <div class="author-box">
        <div class="author-avatar">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?>
        </div>
        <div class="author-info">
            <h4 class="author-name">
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                    <?php the_author(); ?>
                </a>
            </h4>
            <?php if ( $bio ) : ?>
                <p class="author-bio"><?php echo esc_html( $bio ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * 前後の記事リンク
 */
function blogthemewp_post_navigation() {
    if ( ! blogthemewp_show( 'show_post_nav' ) ) return;
    
    $prev = get_previous_post();
    $next = get_next_post();
    
    if ( ! $prev && ! $next ) return;
    ?>
    <nav class="post-navigation">
        <?php if ( $prev ) : ?>
        <div class="nav-previous">
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
                <span class="nav-label"><?php _e( '前の記事', 'blogthemewp' ); ?></span>
                <span class="nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
            </a>
        </div>
        <?php endif; ?>
        
        <?php if ( $next ) : ?>
        <div class="nav-next">
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
                <span class="nav-label"><?php _e( '次の記事', 'blogthemewp' ); ?></span>
                <span class="nav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
            </a>
        </div>
        <?php endif; ?>
    </nav>
    <?php
}

/**
 * ページネーション
 */
function blogthemewp_pagination() {
    the_posts_pagination( array(
        'mid_size'  => 1,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ) );
}
