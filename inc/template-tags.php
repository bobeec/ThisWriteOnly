<?php
/**
 * Template Tags
 *
 * @package ThisWriteOnly
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display post date
 */
function thiswriteonly_posted_on() {
    if ( ! thiswriteonly_show( 'show_post_date' ) ) return;
    
    echo '<time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">';
    echo esc_html( get_the_date() );
    echo '</time>';
}

/**
 * Display author name
 */
function thiswriteonly_posted_by() {
    if ( ! thiswriteonly_show( 'show_author' ) ) return;
    
    echo '<span class="author">';
    echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">';
    echo esc_html( get_the_author() );
    echo '</a></span>';
}

/**
 * Display reading time
 */
function thiswriteonly_reading_time_display() {
    if ( ! thiswriteonly_show( 'show_reading_time' ) ) return;
    
    $time = thiswriteonly_reading_time();
    /* translators: %s: reading time in minutes */
    echo '<span class="reading-time">' . sprintf( esc_html__( '%s min read', 'thiswriteonly' ), $time ) . '</span>';
}

/**
 * Display categories and tags
 */
function thiswriteonly_entry_footer() {
    if ( get_post_type() !== 'post' ) return;
    
    if ( thiswriteonly_show( 'show_categories' ) ) {
        $cats = get_the_category_list( ', ' );
        if ( $cats ) {
            echo '<span class="cat-links">' . $cats . '</span>';
        }
    }
    
    if ( thiswriteonly_show( 'show_tags' ) ) {
        $tags = get_the_tag_list( '', ', ' );
        if ( $tags ) {
            echo '<span class="tags-links">' . $tags . '</span>';
        }
    }
}

/**
 * Display author box
 */
function thiswriteonly_author_box() {
    if ( ! thiswriteonly_show( 'show_author_box' ) ) return;
    
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
 * Display post navigation (previous/next)
 */
function thiswriteonly_post_navigation() {
    if ( ! thiswriteonly_show( 'show_post_nav' ) ) return;
    
    $prev = get_previous_post();
    $next = get_next_post();
    
    if ( ! $prev && ! $next ) return;
    ?>
    <nav class="post-navigation">
        <?php if ( $prev ) : ?>
        <div class="nav-previous">
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
                <span class="nav-label"><?php esc_html_e( 'Previous', 'thiswriteonly' ); ?></span>
                <span class="nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
            </a>
        </div>
        <?php endif; ?>
        
        <?php if ( $next ) : ?>
        <div class="nav-next">
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
                <span class="nav-label"><?php esc_html_e( 'Next', 'thiswriteonly' ); ?></span>
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
function thiswriteonly_pagination() {
    the_posts_pagination( array(
        'mid_size'  => 1,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ) );
}

/**
 * Display breadcrumb navigation with structured data
 */
function thiswriteonly_breadcrumb() {
    if ( ! thiswriteonly_show( 'show_breadcrumb' ) ) return;
    if ( is_front_page() ) return;
    
    $items = array();
    $position = 1;
    
    // Home
    $items[] = array(
        'name' => __( 'Home', 'thiswriteonly' ),
        'url'  => home_url( '/' ),
    );
    
    if ( is_single() ) {
        // Category (first one)
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $cat = $categories[0];
            // Add parent category if exists
            if ( $cat->parent ) {
                $parent = get_category( $cat->parent );
                $items[] = array(
                    'name' => $parent->name,
                    'url'  => get_category_link( $parent->term_id ),
                );
            }
            $items[] = array(
                'name' => $cat->name,
                'url'  => get_category_link( $cat->term_id ),
            );
        }
        // Current post
        $items[] = array(
            'name' => get_the_title(),
            'url'  => '',
        );
    } elseif ( is_page() ) {
        // Add parent pages if exists
        global $post;
        if ( $post->post_parent ) {
            $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
            foreach ( $ancestors as $ancestor_id ) {
                $items[] = array(
                    'name' => get_the_title( $ancestor_id ),
                    'url'  => get_permalink( $ancestor_id ),
                );
            }
        }
        // Current page
        $items[] = array(
            'name' => get_the_title(),
            'url'  => '',
        );
    } elseif ( is_category() ) {
        $cat = get_queried_object();
        if ( $cat->parent ) {
            $parent = get_category( $cat->parent );
            $items[] = array(
                'name' => $parent->name,
                'url'  => get_category_link( $parent->term_id ),
            );
        }
        $items[] = array(
            'name' => $cat->name,
            'url'  => '',
        );
    } elseif ( is_tag() ) {
        $items[] = array(
            'name' => single_tag_title( '', false ),
            'url'  => '',
        );
    } elseif ( is_date() ) {
        if ( is_year() ) {
            $items[] = array(
                'name' => get_the_date( 'Y' ),
                'url'  => '',
            );
        } elseif ( is_month() ) {
            $items[] = array(
                'name' => get_the_date( 'F Y' ),
                'url'  => '',
            );
        } elseif ( is_day() ) {
            $items[] = array(
                'name' => get_the_date(),
                'url'  => '',
            );
        }
    } elseif ( is_author() ) {
        $items[] = array(
            'name' => get_the_author(),
            'url'  => '',
        );
    } elseif ( is_search() ) {
        $items[] = array(
            /* translators: %s: search query */
            'name' => sprintf( __( 'Search results for "%s"', 'thiswriteonly' ), get_search_query() ),
            'url'  => '',
        );
    } elseif ( is_404() ) {
        $items[] = array(
            'name' => __( 'Page not found', 'thiswriteonly' ),
            'url'  => '',
        );
    }
    
    // HTML output
    echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'thiswriteonly' ) . '">';
    echo '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    foreach ( $items as $index => $item ) {
        $position = $index + 1;
        $is_last = ( $index === count( $items ) - 1 );
        
        echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        
        if ( ! $is_last && $item['url'] ) {
            echo '<a href="' . esc_url( $item['url'] ) . '" itemprop="item">';
            echo '<span itemprop="name">' . esc_html( $item['name'] ) . '</span>';
            echo '</a>';
        } else {
            echo '<span itemprop="name">' . esc_html( $item['name'] ) . '</span>';
        }
        
        echo '<meta itemprop="position" content="' . esc_attr( $position ) . '">';
        echo '</li>';
        
        if ( ! $is_last ) {
            echo '<li class="breadcrumb-separator" aria-hidden="true">/</li>';
        }
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Display modified date
 */
function thiswriteonly_modified_date() {
    if ( ! thiswriteonly_show( 'show_modified_date' ) ) return;
    if ( get_the_date() === get_the_modified_date() ) return;
    
    echo '<time class="entry-modified" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">';
    /* translators: %s: modified date */
    echo sprintf( esc_html__( 'Updated: %s', 'thiswriteonly' ), esc_html( get_the_modified_date() ) );
    echo '</time>';
}
