<?php
/**
 * 404
 *
 * @package BLOGthemeWP
 */

get_header();
?>

<div class="error-404">
    <h1 class="page-title">404</h1>
    <p><?php esc_html_e( 'ページが見つかりません。', 'blogthemewp' ); ?></p>
    <p><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'ホームに戻る', 'blogthemewp' ); ?></a></p>
</div>

<?php
get_footer();
