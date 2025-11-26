<?php
/**
 * Header Template
 *
 * @package BLOGthemeWP
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">
    <?php esc_html_e( 'コンテンツにスキップ', 'blogthemewp' ); ?>
</a>

<div id="page" class="site">

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php blogthemewp_site_icon(); ?>
                
                <?php if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php else : ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php
                $blogthemewp_description = get_bloginfo( 'description', 'display' );
                if ( $blogthemewp_description || is_customize_preview() ) :
                ?>
                    <p class="site-description screen-reader-text"><?php echo $blogthemewp_description; ?></p>
                <?php endif; ?>
            </div>

            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'メインメニュー', 'blogthemewp' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'depth'          => 1,
                        'container'      => false,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
        
        <?php if ( blogthemewp_should_show_header_image() ) : ?>
            <div class="header-image">
                <img src="<?php header_image(); ?>" 
                     width="<?php echo esc_attr( get_custom_header()->width ); ?>" 
                     height="<?php echo esc_attr( get_custom_header()->height ); ?>" 
                     alt="<?php bloginfo( 'name' ); ?>">
            </div>
        <?php endif; ?>
    </header>

    <main id="primary" class="site-content">
