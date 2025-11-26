<?php
/**
 * Header
 *
 * @package ThisWriteOnly
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content">
    <?php esc_html_e( 'Skip to content', 'thiswriteonly' ); ?>
</a>

<div class="site">

<?php if ( thiswriteonly_show( 'show_header' ) ) : ?>
<header class="site-header">
    <div class="header-inner">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php elseif ( thiswriteonly_show( 'show_site_icon' ) ) : ?>
                <?php thiswriteonly_site_icon(); ?>
            <?php endif; ?>
            
            <?php if ( thiswriteonly_show( 'show_site_title' ) && ! has_custom_logo() ) : ?>
                <?php if ( is_front_page() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <?php if ( thiswriteonly_show( 'show_navigation' ) && has_nav_menu( 'primary' ) ) : ?>
        <nav class="main-navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1, 'container' => false ) ); ?>
        </nav>
        <?php endif; ?>
    </div>
</header>
<?php endif; ?>

<main id="content" class="site-content">
