<?php
/**
 * Single Post
 *
 * @package BLOGthemeWP
 */

get_header();

while ( have_posts() ) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta">
            <?php blogthemewp_posted_on(); ?>
            <?php blogthemewp_posted_by(); ?>
            <?php blogthemewp_reading_time_display(); ?>
        </div>
    </header>
    
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail( 'large' ); ?>
    </div>
    <?php endif; ?>
    
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    
    <footer class="entry-footer">
        <?php blogthemewp_entry_footer(); ?>
    </footer>
    
</article>

<?php blogthemewp_author_box(); ?>

<?php blogthemewp_post_navigation(); ?>

<?php
if ( blogthemewp_show( 'show_comments' ) && ( comments_open() || get_comments_number() ) ) :
    comments_template();
endif;

endwhile;

get_footer();
