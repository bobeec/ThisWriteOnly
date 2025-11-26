<?php
/**
 * Footer
 *
 * @package ThisWriteOnly
 */
?>

</main>

<?php if ( thiswriteonly_show( 'show_footer' ) ) : ?>
<footer class="site-footer">
    
    <?php 
    $show_yearly = thiswriteonly_show( 'show_archive_yearly' );
    $show_monthly = thiswriteonly_show( 'show_archive_monthly' );
    $show_category = thiswriteonly_show( 'show_archive_category' );
    
    if ( $show_yearly || $show_monthly || $show_category ) : 
    ?>
    <div class="footer-archives">
        <?php if ( $show_yearly ) : ?>
        <div class="footer-archive-section">
            <h3 class="footer-archive-title"><?php esc_html_e( 'Archives by Year', 'thiswriteonly' ); ?></h3>
            <ul class="footer-archive-list">
                <?php wp_get_archives( array( 'type' => 'yearly', 'limit' => 5 ) ); ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ( $show_monthly ) : ?>
        <div class="footer-archive-section">
            <h3 class="footer-archive-title"><?php esc_html_e( 'Archives by Month', 'thiswriteonly' ); ?></h3>
            <ul class="footer-archive-list">
                <?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ( $show_category ) : ?>
        <div class="footer-archive-section">
            <h3 class="footer-archive-title"><?php esc_html_e( 'Categories', 'thiswriteonly' ); ?></h3>
            <ul class="footer-archive-list">
                <?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <p class="footer-copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></p>
</footer>
<?php endif; ?>

</div>

<?php wp_footer(); ?>
</body>
</html>
