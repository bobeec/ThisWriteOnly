<?php
/**
 * Single Post
 *
 * @package ThisWriteOnly
 */

get_header();

thiswriteonly_breadcrumb();

while ( have_posts() ) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta">
            <?php thiswriteonly_posted_on(); ?>
            <?php thiswriteonly_modified_date(); ?>
            <?php thiswriteonly_posted_by(); ?>
            <?php thiswriteonly_reading_time_display(); ?>
        </div>
    </header>
    
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail( 'large' ); ?>
    </div>
    <?php endif; ?>
    
    <div class="entry-content">
        <?php the_content(); ?>
        
        <?php
        wp_link_pages( array(
            'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'thiswriteonly' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
        ) );
        ?>
    </div>
    
    <footer class="entry-footer">
        <?php thiswriteonly_entry_footer(); ?>
    </footer>
    
</article>

<?php thiswriteonly_author_box(); ?>

<?php thiswriteonly_post_navigation(); ?>

<?php
if ( thiswriteonly_show( 'show_comments' ) && ( comments_open() || get_comments_number() ) ) :
    comments_template();
endif;

endwhile;

get_footer();
