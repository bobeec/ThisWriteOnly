<?php
/**
 * Page Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header>

        <?php blogthemewp_post_thumbnail( 'large' ); ?>

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'ページ:', 'blogthemewp' ),
                'after'  => '</div>',
            ) );
            ?>
        </div>

    </article>

    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
    ?>

<?php endwhile; ?>

<?php
get_footer();
