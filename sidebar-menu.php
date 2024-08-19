<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php if ( is_active_sidebar( 'menu' ) ): ?>
    <a id="minimalistflex-menu-goto-right" href="#menu-custom" aria-label="<?php esc_attr_e( 'Go to the right of the navigation menu, which conntains an extra widget area.', 'minimalistflex' ) ?>">&gt;</a>
    <ul class="menu-widgets">
        <?php dynamic_sidebar( 'menu' ); ?>
    </ul>
    <a id="minimalistflex-menu-goto-left" href="#minimalistflex-menu-nav-menu" aria-label="<?php esc_attr_e( 'Go to the left of the navigation menu, which is the menu and a menu widget area.', 'minimalistflex' ) ?>">&lt;</a>
<?php elseif ( user_can( get_current_user_id(), 'edit_theme_options' ) ): ?>
    <a id="minimalistflex-menu-goto-right" href="#menu-custom" aria-label="<?php esc_attr_e( 'Go to the right of the navigation menu, which conntains an extra widget area.', 'minimalistflex' ) ?>">&gt;</a>
    <ul class="menu-widgets">
        <li class="panel widget menu-widget warning">
            <?php esc_html_e( 'Sorry, but no widgets were found in this area.', 'minimalistflex' ); ?>
            <?php esc_html_e( 'This message is displayed to administrators only.', 'minimalistflex' ); ?>
        </li>
    </ul>
    <a id="minimalistflex-menu-goto-left" href="#minimalistflex-menu-nav-menu" aria-label="<?php esc_attr_e( 'Go to the left of the navigation menu, which is the menu and a menu widget area.', 'minimalistflex' ) ?>">&lt;</a>
<?php endif; ?>