<?php
/**
 * Template part for displaying post cards in archive views
 *
 * @package BLOGthemeWP
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
    
    <h2 class="post-card-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    
    <div class="post-card-meta">
        <?php blogthemewp_posted_on(); ?>
        <span class="meta-sep">・</span>
        <?php blogthemewp_reading_time_display(); ?>
    </div>
    
    <?php if ( has_excerpt() || get_the_content() ) : ?>
        <p class="post-card-excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 60, '...' ); ?>
        </p>
    <?php endif; ?>
    
</article>
