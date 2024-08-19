<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<div class="singular-meta">
    <?php $tags = get_the_category(); ?>
    <?php if( $tags ): ?>
        <div class="singular-categories">
            <div class="categories-indicator">
                <?php esc_html_e( 'Categories:', 'minimalistflex' ) ?>
            </div>
            <?php foreach( $tags as $tag ) { ?>
                <div class="singular-category">
                    <a href="<?php echo esc_attr( get_category_link( $tag ) ) ?>">
                        <?php echo $tag->name; ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>
    <?php $tags = get_the_tags(); ?>
    <?php if( $tags ): ?>
    <div class="singular-categories singular-tags">
        <div class="categories-indicator tags-indicator">
            <?php esc_html_e( 'Tags:', 'minimalistflex' ) ?>
        </div>
        <?php foreach( $tags as $tag ) { ?>
            <div class="singular-category singular-tag">
                <a href="<?php echo esc_attr( get_tag_link( $tag ) ) ?>">
                    <?php echo $tag->name; ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <?php endif; ?>
</div>