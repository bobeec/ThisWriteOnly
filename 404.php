<?php
/**
 * 404
 *
 * @package ThisWriteOnly
 */

get_header();

thiswriteonly_breadcrumb();
?>

<div class="error-404">
    <h1 class="page-title">404</h1>
    <p><?php esc_html_e( 'Page not found.', 'thiswriteonly' ); ?></p>
    <p><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Back to Home', 'thiswriteonly' ); ?></a></p>
</div>

<?php
get_footer();
