<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php $userid = get_the_author_meta( 'ID' ) ?>
<div class="singular-author">
    <div class="author-card">
        <div class="author-avatar">
            <?php echo get_avatar( $userid, 80 ); ?>
        </div>
        <div class="author-description">
            <a class="author-link" href="<?php echo get_author_posts_url( $userid ) ?>"><?php the_author() ?></a>
            <p class="author-tagline"><?php the_author_meta( 'description' ) ?></p>
        </div>
    </div>
</div>