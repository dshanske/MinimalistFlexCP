<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<div class="publisher">

<a class="publisher-link" href="<?php echo esc_attr( get_author_posts_url($id) ) ?>">
    <?php echo get_avatar( $id, 32 ) ?>
    <span><?php the_author() ?></span>
</a>
<div class="publisher-datetime">
    <?php $datemode = get_theme_mod( 'minimalistflex_interface_date', 'modify' ); ?>
    <?php if ( $datemode <> 'no' ): ?>
        <?php if ( $datemode == 'publish' || get_the_modified_date() <> get_the_date() ): ?>
            <?php printf(
                /* translators: %s: Post publish time. */
                __( 'Published on %s', 'minimalistflex' ),
                get_the_date()
            ) ?>
        <?php else: ?>
            <?php printf(
                /* translators: %s: Post last modified time. */
                __( 'Last modified on %s', 'minimalistflex' ),
                get_the_modified_date()
            ) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

</div>