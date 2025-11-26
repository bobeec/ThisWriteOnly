<?php
/**
 * Archive Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<header class="page-header">
    <?php
    the_archive_title( '<h1 class="page-title">', '</h1>' );
    the_archive_description( '<div class="archive-description">', '</div>' );
    ?>
</header>

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
