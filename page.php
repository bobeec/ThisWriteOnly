<?php
/**
 * Page
 *
 * @package BLOGthemeWP
 */

get_header();

while ( have_posts() ) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    
    <div class="entry-content">
        <?php the_content(); ?>
        
        <?php
        wp_link_pages( array(
            'before'      => '<div class="page-links">' . esc_html__( 'ページ:', 'blogthemewp' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
        ) );
        ?>
    </div>
    
</article>

<?php
if ( blogthemewp_show( 'show_comments' ) && ( comments_open() || get_comments_number() ) ) :
    comments_template();
endif;

endwhile;

get_footer();
