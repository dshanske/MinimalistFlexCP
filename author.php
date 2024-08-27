<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="minimalistflex-author">
        <?php $id = get_the_author_meta( 'ID' ); ?>
        <h1 class="author-title panel">
            <?php if ( get_theme_mod( 'minimalistflex_layout_author_title', 'yes' ) === 'yes' ): ?>
                <?php the_archive_title() ?>
            <?php endif; ?>
            <div class="author-page-avatar<?php if ( user_can( $id, 'administrator' ) && get_theme_mod( 'minimalistflex_layout_author_admin', 'yes' ) === 'yes' ) {
                echo ' author-admin';
            } ?>" aria-hidden="true">
                <?php echo get_avatar( $id, 150 ); ?>
            </div>
        </h1>
        <div class="author-details">
            <?php
                $titles = Array(
                    esc_html__( 'User description', 'minimalistflex' ),
                    esc_html__( 'Registration time', 'minimalistflex' ),
                    esc_html__( 'Website', 'minimalistflex' ),
                    esc_html__( 'Email', 'minimalistflex' )
                );
                $metas = Array(
                    'description',
                    'user_registered',
                    'user_url',
                    'user_email'
                );
                $i = 0;
            ?>
            <?php while ( $i < count( $metas ) ): ?>
                <?php $meta = get_the_author_meta( $metas[$i] ); ?>
                <?php if ( strlen( $meta ) && get_theme_mod( 'minimalistflex_layout_author_elements_' . $metas[$i], 'yes' ) === 'yes' ): ?>
                    <div class="author-detail">
                        <h2><?php echo $titles[$i] ?></h2>
                        <?php echo esc_html( $meta ) ?>
                    </div>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endwhile; ?>
        </div>
        <h2 class="author-page-all-posts-title">
            <?php
                printf(
                    /* translators: %s: The author display name. */
                    esc_html__( 'All posts by %s', 'minimalistflex' ),
                    get_the_author_meta( 'display_name' )
                )
            ?>
        </h2>
        <?php get_template_part( 'templates/loop' ) ?>
    </div>
    <?php the_posts_pagination(); ?>
<?php endif; ?>

<?php get_footer(); ?>
