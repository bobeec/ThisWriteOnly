<?php
/**
 * Single Post Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            
            <div class="entry-meta">
                <?php blogthemewp_posted_on(); ?>
                <span class="meta-sep">・</span>
                <?php blogthemewp_posted_by(); ?>
                <span class="meta-sep">・</span>
                <?php blogthemewp_reading_time_display(); ?>
            </div>
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

        <footer class="entry-footer">
            <?php blogthemewp_entry_footer(); ?>
        </footer>

    </article>

    <?php blogthemewp_author_box(); ?>

    <?php blogthemewp_post_navigation(); ?>

    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
    ?>

<?php endwhile; ?>

<?php
get_footer();
