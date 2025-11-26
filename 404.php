<?php
/**
 * 404 Error Template
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<section class="error-404 not-found">
    <header class="page-header">
        <h1 class="page-title">404</h1>
    </header>

    <div class="page-content">
        <p><?php esc_html_e( 'お探しのページは見つかりませんでした。', 'blogthemewp' ); ?></p>
        <p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-home">
                <?php esc_html_e( 'ホームに戻る', 'blogthemewp' ); ?>
            </a>
        </p>
    </div>
</section>

<?php
get_footer();
