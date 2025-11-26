<?php
/**
 * Template part for displaying a message when no posts are found
 *
 * @package BLOGthemeWP
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( '記事が見つかりません', 'blogthemewp' ); ?></h1>
    </header>

    <div class="page-content">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p>
                <?php
                printf(
                    /* translators: %s: link to new post admin page */
                    wp_kses(
                        __( '最初の記事を<a href="%s">投稿</a>してみましょう。', 'blogthemewp' ),
                        array( 'a' => array( 'href' => array() ) )
                    ),
                    esc_url( admin_url( 'post-new.php' ) )
                );
                ?>
            </p>

        <?php elseif ( is_search() ) : ?>

            <p><?php esc_html_e( '検索キーワードに一致する記事がありませんでした。別のキーワードでお試しください。', 'blogthemewp' ); ?></p>
            <?php get_search_form(); ?>

        <?php else : ?>

            <p><?php esc_html_e( 'お探しのコンテンツは見つかりませんでした。', 'blogthemewp' ); ?></p>

        <?php endif; ?>
    </div>
</section>
