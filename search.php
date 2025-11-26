<?php
/**
 * Search Results Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<header class="page-header">
    <h1 class="page-title">
        <?php
        printf(
            /* translators: %s: search query */
            esc_html__( '「%s」の検索結果', 'blogthemewp' ),
            '<span>' . get_search_query() . '</span>'
        );
        ?>
    </h1>
</header>

<?php if ( have_posts() ) : ?>

    <div class="post-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', 'card' ); ?>
        <?php endwhile; ?>
    </div>

    <?php blogthemewp_pagination(); ?>

<?php else : ?>

    <div class="no-results">
        <p><?php esc_html_e( '検索結果が見つかりませんでした。別のキーワードでお試しください。', 'blogthemewp' ); ?></p>
        <?php get_search_form(); ?>
    </div>

<?php endif; ?>

<?php
get_footer();
