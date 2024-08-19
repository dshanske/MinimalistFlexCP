<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'loading' ) ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>

<?php

if( is_home() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_home_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_home_header', 'yes' );
} elseif ( is_front_page() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_front_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_front_header', 'yes' );
} elseif ( is_search() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_search_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_search_header', 'yes' );
} elseif ( is_author() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_author_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_author_header', 'yes' );
} elseif ( is_archive() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_archive_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_archive_header', 'yes' );
} elseif ( is_single() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_singular_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_singular_header', 'yes' );
} elseif ( is_page() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_page_sidebar', 'right' );
    $header = get_theme_mod( 'minimalistflex_layout_page_header', 'yes' );
}

$link = get_theme_mod( 'minimalistflex_header_link' );
$label = get_theme_mod( 'minimalistflex_header_label' );

?>

<a class="screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to main content', 'minimalistflex' ) ?></a>

<?php if( get_header_image() && $header == 'yes' ): ?>
    <header class="minimalistflex-header-image">
        <?php if ( strlen( $link ) ): ?>
            <a href="<?php echo esc_url( $link ) ?>" aria-label="<?php
                    if ( strlen( $label ) ) {
                        echo esc_attr( $label );
                    } else {
                        esc_attr_e( 'The header image link.', 'minimalistflex' );
                    }
                ?>">
        <?php endif; ?>
            <img src="<?php header_image(); ?>" aria-label="<?php
                if ( strlen( $label ) ) {
                    printf(
                        /* translators: %s: The label of the header image link. */
                        esc_attr__( 'The image of the header image link to "%s".', 'minimalistflex' ),
                        esc_attr( $label )
                    );
                } else {
                    esc_attr_e( 'The header image.', 'minimalistflex' );
                }
            ?>">
        <?php if ( strlen( $link ) ): ?>
            </a>
        <?php endif; ?>
    </header>
<?php endif; ?>

<nav class="minimalistflex-header">
    <?php if ( has_custom_logo() ): ?>
        <?php echo get_custom_logo(); ?>
    <?php endif; ?>
    <?php if ( display_header_text() ): ?>
        <h1 class="blog-title">
            <a href="<?php echo esc_url( home_url() ); ?>" class="blog-title-link"><?php echo get_bloginfo( 'name' ) ?></a>
        </h1>
    <?php endif; ?>
    <div class="spacer"></div>
    <?php if ( has_nav_menu( 'main-menu' ) || is_active_sidebar( 'menu' ) || is_active_sidebar( 'menu-2' ) ): ?>
        <button id="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation dropdown', 'minimalistflex' ) ?>">
            <i id="menu-toggle-icon"></i>
        </button>
    <?php endif; ?>
    <div class="minimalistflex-menu-container">
        <div class="minimalistflex-menu">
            <?php if ( has_nav_menu( 'main-menu' ) ): ?>
                <div id="minimalistflex-menu-nav-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
                </div>
            <?php endif; ?>
            <div class="custom-menu-2" id="custom-menu-2">
                <a id="custom-menu-2-focus" href="#" aria-label="<?php esc_attr_e( 'Here goes the "Menu 2" widget area. This text does not trigger anything.', 'minimalistflex' ) ?>"></a>
                <div class="custom-menu-2-menu">
                    <?php get_sidebar( 'menu-2' ) ?>
                </div>
            </div>
            <?php if ( is_active_sidebar( 'menu' ) || user_can( get_current_user_id(), 'edit_theme_options' ) ): ?>
                <div class="menu-custom" id="menu-custom">
                    <?php get_sidebar( 'menu' ) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="minimalistflex-master <?php echo 'minimalistflex-sidebar-layout-' . $sidebar ?>">

<article class="minimalistflex-content" id="main-content">

<?php get_sidebar( 'above-content' ); ?>
