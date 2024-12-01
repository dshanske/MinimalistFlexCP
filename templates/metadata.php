<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>
                <?php $mf_datemode = get_theme_mod( 'minimalistflex_interface_date', 'modify' ); ?>
                <?php if ( $mf_datemode <> 'no' ): ?>
                    <div class="panel-author">
                        <?php if ( $mf_datemode === 'publish' || get_the_modified_date() <> get_the_date() ): ?>
                            <?php printf(
                                /* translators: %s: Post publish time. */
                                esc_html__( 'Published on %s', 'minimalistflex' ),
                                esc_html( get_the_date() )
                            ) ?>
                        <?php else: ?>
                            <?php printf(
                                /* translators: %s: Post last modified time. */
                                esc_html__( 'Last modified on %s', 'minimalistflex' ),
                                esc_html( get_the_modified_date() )
                            ) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

<div class="singular-meta">
    <?php $mf_tags = get_the_category(); ?>
    <?php if( $mf_tags ): ?>
        <div class="singular-categories">
            <div class="categories-indicator">
                <?php esc_html_e( 'Categories:', 'minimalistflex' ) ?>
            </div>
            <?php foreach( $mf_tags as $mf_tag ) { ?>
                <div class="singular-category">
                    <a href="<?php echo esc_url( get_category_link( $mf_tag ) ) ?>">
                        <?php echo esc_html( $mf_tag->name ) ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>
    <?php $mf_tags = get_the_tags(); ?>
    <?php if( $mf_tags ): ?>
    <div class="singular-categories singular-tags">
        <div class="categories-indicator tags-indicator">
            <?php esc_html_e( 'Tags:', 'minimalistflex' ) ?>
        </div>
        <?php foreach( $mf_tags as $mf_tag ) { ?>
            <div class="singular-category singular-tag">
                <a href="<?php echo esc_url( get_tag_link( $mf_tag ) ) ?>">
                    <?php echo esc_html( $mf_tag->name ) ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <?php endif; ?>

	<?php  if ( taxonomy_exists( 'series' ) ) {
	     if ( $mf_tags = get_the_terms( get_the_ID(), 'series' ) ) ?>
    <?php if( $mf_tags ) { ?>
    <div class="singular-categories singular-tags">
        <div class="categories-indicator tags-indicator">
            <?php esc_html_e( 'Series:', 'minimalistflex' ) ?>
        </div>
        <?php foreach( $mf_tags as $mf_tag ) { ?>
            <div class="singular-category">
                <a href="<?php echo esc_url( get_term_link( $mf_tag, 'series' ) ) ?>">
                    <?php echo esc_html( $mf_tag->name ) ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <?php }
	} ?>
</div>
