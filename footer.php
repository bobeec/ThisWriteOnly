<?php
/**
 * Footer Template
 *
 * @package BLOGthemeWP
 */
?>

    </main><!-- #primary -->

    <?php if ( is_active_sidebar( 'footer-widget' ) ) : ?>
        <aside class="widget-area" aria-label="<?php esc_attr_e( 'フッター', 'blogthemewp' ); ?>">
            <div class="widget-area-inner">
                <?php dynamic_sidebar( 'footer-widget' ); ?>
            </div>
        </aside>
    <?php endif; ?>

    <footer id="colophon" class="site-footer">
        <div class="footer-inner">
            <p class="copyright">
                &copy; <?php echo date( 'Y' ); ?> 
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </p>
            <p class="theme-credit">
                <a href="https://github.com/blogthemewp" target="_blank" rel="noopener">
                    BLOGthemeWP
                </a>
            </p>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
