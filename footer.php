<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

</article>

<?php

if( is_home() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_home_sidebar', 'right' );
} elseif ( is_front_page() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_front_sidebar', 'right' );
} elseif ( is_search() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_search_sidebar', 'right' );
} elseif ( is_archive() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_archive_sidebar', 'right' );
} elseif( is_author() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_author_sidebar', 'right' );
} elseif( is_single() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_singular_sidebar', 'right' );
} elseif( is_page() ) {
    $sidebar = get_theme_mod( 'minimalistflex_layout_page_sidebar', 'right' );
}

?>

<?php if ( $sidebar <> 'no' ): ?>
    <aside class="minimalistflex-sidebar">
        <?php get_sidebar(); ?>
    </aside>
<?php endif; ?>

</main>

<footer class="minimalistflex-footer">
    <ul class="minimalistflex-controls">
        <?php if ( get_theme_mod( 'minimalistflex_interface_scroll_top', 'yes' ) === 'yes' ): ?>
            <li><a href="#" aria-label="<?php esc_attr_e( 'Back to top', 'minimalistflex' ) ?>">:D</a></li>
        <?php endif; ?>
    </ul>
    <div class="minimalistflex-footer-widgets-container">
        <?php $sidebars = get_theme_mod( 'minimalistflex_footer_widget_layout', 'one' ); ?>
        <?php
            get_sidebar( 'footer' );
            if ( $sidebars === 'two' || $sidebars === 'three' ) {
                get_sidebar( 'footer-2' );
            }
            if ( $sidebars === 'three' ) {
                get_sidebar( 'footer-3' );
            }
        ?>
    </div>
    <div class="minimalistflex-footer-credits">
        <?php if ( display_header_text() ): ?>
            <div class="footer-blog-description">
                <div class="footer-blog-title">
                    <a href="<?php echo esc_url( home_url() ); ?>" class="blog-title-link"><?php echo get_bloginfo( 'name' ) ?></a>
                </div>
                <?php if( get_bloginfo( 'description' ) ): ?>
                    <div class="footer-blog-tagline">
                        <?php echo get_bloginfo( 'description' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="footer-credits">
            <?php $footer_type = get_theme_mod( 'minimalistflex_footer_type', 'both' ); ?>
            <?php if ( $footer_type === 'both' || $footer_type === 'custom' ): ?>
                <?php echo wp_kses_data( get_theme_mod( 'minimalistflex_footer_text' ) ) ?>
            <?php endif; ?>
            <?php if ( $footer_type === 'both' || $footer_type === 'minimalistflex' ): ?>
                <?php
                    printf(
                        /* translators: %s: Link to theme author website. */
                        __( 'Theme <a href="%s">MinimalistFlex</a>.', 'minimalistflex' ),
                        esc_url( 'https://onmyodev.com/' )
                    )
                ?>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>