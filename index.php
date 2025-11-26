<?php
/**
 * Main Index Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<?php if ( is_home() && ! is_paged() ) : ?>
    <header class="page-header">
        <h1 class="page-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
    </header>
<?php endif; ?>

<?php if ( have_posts() ) : ?>

    <div class="post-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', 'card' ); ?>
        <?php endwhile; ?>
    </div>

    <?php blogthemewp_pagination(); ?>

<?php else : ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

<?php
get_footer();
