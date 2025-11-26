<?php
/**
 * Template Tags
 *
 * @package BLOGthemeWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display post meta (date, author, reading time)
 */
function blogthemewp_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( blogthemewp_format_date() )
    );
    
    echo '<span class="posted-on">' . $time_string . '</span>';
}

/**
 * Display author
 */
function blogthemewp_posted_by() {
    $author_id = get_the_author_meta( 'ID' );
    $author_name = get_the_author();
    $author_url = get_author_posts_url( $author_id );
    
    echo '<span class="byline">';
    echo '<a href="' . esc_url( $author_url ) . '" class="author-link">' . esc_html( $author_name ) . '</a>';
    echo '</span>';
}

/**
 * Display reading time
 */
function blogthemewp_reading_time_display() {
    $reading_time = blogthemewp_reading_time();
    echo '<span class="reading-time">';
    printf( 
        /* translators: %s: reading time in minutes */
        esc_html__( '%s分で読める', 'blogthemewp' ), 
        $reading_time 
    );
    echo '</span>';
}

/**
 * Display entry footer (categories, tags)
 */
function blogthemewp_entry_footer() {
    // Categories
    if ( 'post' === get_post_type() ) {
        $categories_list = get_the_category_list( ', ' );
        if ( $categories_list ) {
            printf(
                '<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                esc_html__( 'カテゴリー: ', 'blogthemewp' ),
                $categories_list
            );
        }

        $tags_list = get_the_tag_list( '', ', ' );
        if ( $tags_list ) {
            printf(
                '<span class="tags-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                esc_html__( 'タグ: ', 'blogthemewp' ),
                $tags_list
            );
        }
    }
}

/**
 * Display post thumbnail
 */
function blogthemewp_post_thumbnail( $size = 'post-thumbnail' ) {
    if ( ! has_post_thumbnail() ) {
        return;
    }
    
    if ( is_singular() ) {
        echo '<div class="post-thumbnail">';
        the_post_thumbnail( $size );
        echo '</div>';
    } else {
        echo '<a class="post-thumbnail-link" href="' . esc_url( get_permalink() ) . '">';
        echo '<div class="post-thumbnail">';
        the_post_thumbnail( $size );
        echo '</div>';
        echo '</a>';
    }
}

/**
 * Display author box
 */
function blogthemewp_author_box() {
    $author_id = get_the_author_meta( 'ID' );
    $author_name = get_the_author();
    $author_bio = get_the_author_meta( 'description' );
    $author_url = get_author_posts_url( $author_id );
    $avatar_url = get_avatar_url( $author_id, array( 'size' => 128 ) );
    
    ?>
    <div class="author-box">
        <div class="author-avatar">
            <a href="<?php echo esc_url( $author_url ); ?>">
                <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $author_name ); ?>">
            </a>
        </div>
        <div class="author-info">
            <h4 class="author-name">
                <a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
            </h4>
            <?php if ( $author_bio ) : ?>
                <p class="author-bio"><?php echo wp_kses_post( $author_bio ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Display post navigation
 */
function blogthemewp_post_navigation() {
    $prev = get_previous_post();
    $next = get_next_post();
    
    if ( ! $prev && ! $next ) {
        return;
    }
    
    ?>
    <nav class="post-navigation" aria-label="<?php esc_attr_e( '記事ナビゲーション', 'blogthemewp' ); ?>">
        <?php if ( $prev ) : ?>
            <div class="nav-previous">
                <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
                    <span class="nav-subtitle"><?php esc_html_e( '前の記事', 'blogthemewp' ); ?></span>
                    <span class="nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                </a>
            </div>
        <?php else : ?>
            <div class="nav-previous"></div>
        <?php endif; ?>
        
        <?php if ( $next ) : ?>
            <div class="nav-next">
                <a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
                    <span class="nav-subtitle"><?php esc_html_e( '次の記事', 'blogthemewp' ); ?></span>
                    <span class="nav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </nav>
    <?php
}

/**
 * Display pagination
 */
function blogthemewp_pagination() {
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => '←',
        'next_text' => '→',
        'class'     => 'pagination',
    ) );
}

/**
 * Comments callback
 */
function blogthemewp_comment_callback( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <header class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 40 ); ?>
                    <?php printf( '<span class="fn">%s</span>', get_comment_author_link() ); ?>
                </div>
                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                            printf(
                                '%1$s %2$s',
                                get_comment_date(),
                                get_comment_time()
                            );
                            ?>
                        </time>
                    </a>
                </div>
            </header>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e( 'コメントは承認待ちです。', 'blogthemewp' ); ?></p>
            <?php endif; ?>

            <footer class="comment-footer">
                <?php
                comment_reply_link( array_merge( $args, array(
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="reply">',
                    'after'     => '</span>',
                ) ) );
                ?>
            </footer>
        </article>
    <?php
}
