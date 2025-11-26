<?php
/**
 * Footer
 *
 * @package BLOGthemeWP
 */
?>

</main>

<?php if ( blogthemewp_show( 'show_footer' ) ) : ?>
<footer class="site-footer">
    <p>&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></p>
</footer>
<?php endif; ?>

</div>

<?php wp_footer(); ?>
</body>
</html>
