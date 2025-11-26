<?php
/**
 * Archive
 *
 * @package ThisWriteOnly
 */

get_header();

thiswriteonly_breadcrumb();
?>

<header class="page-header" style="margin-bottom: var(--spacing-lg);">
    <h1 class="page-title"><?php the_archive_title(); ?></h1>
    <?php the_archive_description( '<p class="archive-description" style="color: var(--color-text-light);">', '</p>' ); ?>
</header>

<?php if ( have_posts() ) : ?>

<div class="post-list">
    <?php while ( have_posts() ) : the_post(); ?>
    
    <article <?php post_class( 'post-card' ); ?>>
        <h2 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="post-card-meta">
            <?php thiswriteonly_posted_on(); ?>
            <?php thiswriteonly_reading_time_display(); ?>
        </div>
        <p class="post-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 50 ); ?></p>
    </article>
    
    <?php endwhile; ?>
</div>

<?php thiswriteonly_pagination(); ?>

<?php else : ?>

<div class="no-results">
    <p><?php esc_html_e( 'No posts found.', 'thiswriteonly' ); ?></p>
</div>

<?php endif; ?>

<?php
get_footer();
