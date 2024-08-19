<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php
$default_images = explode( ',', get_theme_mod( 'minimalistflex_default_featured_images' ));
$default_image_location = get_theme_mod( 'minimalistflex_default_featured_images_location', 'archive' );
?>

<?php get_header(); ?>

<?php if ( have_posts() ) :
        the_post();
        $id = get_the_author_meta( 'ID' );
    ?>
    <div <?php post_class( "singular" ) ?>>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="singular-image">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php elseif ( ( $default_images[0] <> '' || minimalistflex_get_first_image() ) && $default_image_location <> 'no' && $default_image_location <> 'archive' ): ?>
            <?php if ( get_theme_mod( 'minimalistflex_default_featured_images_first_image', 'yes' ) == 'yes' && minimalistflex_get_first_image() ): ?>
                <?php $imgsrc = minimalistflex_get_first_image(); ?>
            <?php else: ?>
                <?php
                    $key = minimalistflex_get_seconds() % count($default_images);
                    $imgsrc = $default_images[$key];
                ?>
            <?php endif; ?>
            <div class="singular-image">
                <img src="<?php echo esc_attr( $imgsrc ) ?>" aria-label="<?php esc_attr_e( 'The thumbnail image. This is a default image so that it\'s purely decorative.', 'minimalistflex' ) ?>">
            </div>
        <?php endif; ?>
        <div class="singular-main">
            <h1 class="panel-title"><?php the_title(); ?></h1>
            <?php get_template_part( 'templates/publisher' ) ?>
            <div class="panel-main">
                <?php the_content(); ?>
                <?php wp_link_pages( Array(
                    'before' => '<p class="panel post-nav-links"><span class="post-nav-links-indicator">' . __('Pages: ', 'minimalistflex') . '</span>'
                ) ); ?>
            </div>
            <?php get_sidebar( 'below-content' ) ?>
            <?php get_template_part( 'templates/author' ) ?>
            <?php get_template_part( 'templates/metadata' ) ?>
        </div>
        <?php if ( comments_open() || get_comments_number() ) :
	        comments_template();
        else: ?>
            <p class="no-comments"><?php _e( 'Comments are closed.', 'minimalistflex' ); ?></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php get_template_part( 'templates/empty' ); ?>
<?php endif; ?>

<?php get_footer(); ?>