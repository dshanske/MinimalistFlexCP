<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php
$default_images = explode( ',', get_theme_mod( 'minimalistflex_default_featured_images' ));
$default_image_location = get_theme_mod( 'minimalistflex_default_featured_images_location', 'archive' );
?>

<?php while ( have_posts() ) :
        the_post();
        $id = get_the_author_meta('ID');
        $post_id = get_the_ID();
    ?>
    <div <?php post_class("panel"); ?>>
        <?php if ( has_post_thumbnail() ): ?>
            <a class="panel-image" href="<?php the_permalink() ?>" aria-label="<?php
            printf(
                /* translators: %s: Post title associated with the thumbnail image. */
                esc_attr__( 'Thumbnail image of %s. Also a link that navigates to it.', 'minimalistflex' ),
                get_the_title()
            ) ?>">
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        <?php elseif ( ( $default_images[0] <> '' || minimalistflex_get_first_image() ) && $default_image_location <> 'no' && $default_image_location <> 'single' ): ?>
            <?php if ( get_theme_mod( 'minimalistflex_default_featured_images_first_image', 'yes' ) == 'yes' && minimalistflex_get_first_image() ): ?>
                <?php $imgsrc = minimalistflex_get_first_image(); ?>
            <?php else: ?>
                <?php
                    $key = minimalistflex_get_seconds() % count($default_images);
                    $imgsrc = $default_images[$key];
                ?>
            <?php endif; ?>
            <a class="panel-image" href="<?php the_permalink() ?>" aria-label="<?php
            printf(
                /* translators: %s: Post title associated with the thumbnail image. */
                esc_attr__( 'The thhumbnail image link for %s', 'minimalistflex' ),
                get_the_title()
            ) ?>">
                <img src="<?php echo esc_url( $imgsrc );?>" aria-label="<?php
                    printf(
                        /* translators: %s: Title of the post. */
                        esc_attr__( 'The thumbnail image for %s.', 'minimalistflex' ),
                        get_the_title()
                    )
                ?>">
            </a>
        <?php endif; ?>
        <div class="panel-content">
            <?php if ( get_theme_mod( 'minimalistflex_interface_comment_count', 'yes' ) == 'yes' ): ?>
                <div class="panel-comment-count">
                    <?php
                        printf(
                            _nx(
                                '1 Comment',
                                '%d Comments',
                                get_comments_number(),
                                'comment count',
                                'minimalistflex'
                            ),
                            number_format_i18n( get_comments_number() )
                        );
                    ?>
                </div>
            <?php endif; ?>
            <h1 class="panel-title"><?php the_title(); ?></h1>
            <div class="panel-main">
                <?php the_excerpt(); ?>
                <?php wp_link_pages( Array(
                    'before' => '<p class="panel post-nav-links"><span class="post-nav-links-indicator">' . __('Pages: ', 'minimalistflex') . '</span>'
                ) ); ?>
            </div>
            <div class="panel-meta">
                <?php if ( get_theme_mod( 'minimalistflex_interface_publisher', 'yes' ) == 'yes' ): ?>
                    <a class="panel-author" href="<?php echo esc_url( get_author_posts_url($id) ) ?>">
                        <span aria-hidden="true"><?php echo get_avatar( $id, 80 ) ?></span>
                        <?php the_author() ?>
                    </a>
                <?php endif; ?>
                <?php $datemode = get_theme_mod( 'minimalistflex_interface_date', 'modify' ); ?>
                <?php if ( $datemode <> 'no' ): ?>
                    <div class="panel-author">
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
                    </div>
                <?php endif; ?>
                <a class="panel panel-link" href="<?php the_permalink(); ?>" aria-label="<?php
                        printf(
                            /* translators: %s: Post title. */
                            __( 'Read more of %s', 'minimalistflex' ),
                            get_the_title()
                        )
                    ?>">
                    <?php echo esc_html( get_theme_mod( 'minimalistflex_interface_readlink', __( 'Read More', 'minimalistflex' ) ) ); ?>
                </a>
            </div>
        </div>
    </div>
<?php endwhile; ?>