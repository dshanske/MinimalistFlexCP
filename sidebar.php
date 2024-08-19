<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php if ( is_active_sidebar( 'main-sidebar' ) ): ?>
    <ul class="sidebar">
	    <?php dynamic_sidebar('main-sidebar'); ?>
    </ul>
<?php else: ?>
    <ul class="sidebar">
        <?php if ( user_can( get_current_user_id(), 'edit_theme_options' ) ): ?>
            <li class="panel widget warning">
                <?php esc_html_e( 'Sorry, but no widgets were found in this area. ', 'minimalistflex' ); ?>
                <?php esc_html_e( 'Some default widgets had been displayed instead.', 'minimalistflex' ); ?>
                <br>
                <?php esc_html_e( 'This message is displayed to administrators only.', 'minimalistflex' ); ?>
            </li>
        <?php endif; ?>
        <li id="search" class="panel widget widget_search">
            <?php get_search_form(); ?>
        </li>
        
        <li id="archives" class="panel widget">
            <h3 class="widget-title"><?php _e( 'Archives', 'minimalistflex' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </li>

        <li id="meta" class="panel widget">
            <h3 class="widget-title"><?php _e( 'Meta', 'minimalistflex' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </li>
    </ul>
<?php endif; ?>