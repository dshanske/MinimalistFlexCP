<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function minimalistflex_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
		$classes[] = 'h-feed';
	} else {
		if ( 'venue' === get_post_type() ) {
			$classes[] = 'h-card';
		} elseif ( 'page' !== get_post_type() ) {
			$classes[] = 'hentry';
			$classes[] = 'h-entry';
		} elseif ( 'page' === get_post_type() && ! is_front_page() ) {
			$classes[] = 'no-sidebar';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'minimalistflex_body_classes' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function minimalistflex_privacy_link( $link, $privacy_policy_url ) {
	$privacy_policy_url = get_privacy_policy_url();
	$policy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );
	$page_title     = ( $policy_page_id ) ? get_the_title( $policy_page_id ) : '';
		 
	if ( $privacy_policy_url && $page_title ) {
		$link = sprintf(
			'<a class="privacy-policy-link" href="%s" rel="privacy-policy">%s</a>',
			esc_url( $privacy_policy_url ),
			esc_html( $page_title )
		);
	}
	return $link;
}

add_filter( 'the_privacy_policy_link', 'minimalistflex_privacy_link', 10, 2 );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function minimalistflex_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%1$s" />', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'minimalistflex_pingback_header' );

/**
 * Adds a rel-feed if the main page is not a list of posts
 */
function minimalistflex_feed_header() {
	if ( is_front_page() && 0 !== (int) get_option( 'page_for_posts', 0 ) ) {
		printf( '<link rel="alternate" type="text/mf2+html" href="%1$s" title="%2$s" />' . PHP_EOL, esc_url( get_post_type_archive_link( 'post' ) ), __( 'H-Feed', 'iw26' ) );
	}
	if ( get_query_var( 'kind_firehose' ) ) {
		printf( '<link rel="alternate" type="text/mf2+html" href="%1$s" title="%2$s" />' . PHP_EOL, esc_url( get_self_link() ), __( 'H-Feed', 'iw26' ) );
	}

}
add_action( 'wp_head', 'minimalistflex_feed_header' );


/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function minimalistflex_post_classes( $classes ) {
	$classes = array_diff( $classes, array( 'hentry' ) );
	if ( ! is_singular() ) {
		if ( 'venue' === get_post_type() ) {
			$classes[] = 'h-card';
		} elseif ( 'page' !== get_post_type() ) {
			// Adds a class for microformats v2
			$classes[] = 'h-entry';
			// add hentry to the same tag as h-entry
			$classes[] = 'hentry';
		}
	}
	return $classes;
}

add_filter( 'post_class', 'minimalistflex_post_classes' );

/**
 * Adds mf2 to avatar
 *
 * @param array             $args Arguments passed to get_avatar_data(), after processing.
 * @param int|string|object $id_or_email A user ID, email address, or comment object
 * @return array $args
 */
function minimalistflex_get_avatar_data( $args, $id_or_email ) {
	if ( ! isset( $args['class'] ) ) {
		$args['class'] = array();
	}
	if ( ! in_array( 'u-featured', $args['class'] ) ) {
		$args['class'][] = 'u-photo';
	}
	return $args;
}

add_filter( 'get_avatar_data', 'minimalistflex_get_avatar_data', 11, 2 );

/**
 * Wraps the_content in e-content
 */
function minimalistflex_the_content( $content ) {
	if ( is_feed() ) {
		return $content;
	}
	$wrap = '<div class="entry-content e-content">';
	if ( empty( $content ) ) {
		return $content;
	}
	return $wrap . $content . '</div>';
}
add_filter( 'the_content', 'minimalistflex_the_content', 1 );

/**
 * Wraps the_excerpt in p-summary
 */
function minimalistflex_the_excerpt( $content ) {
	if ( is_feed() ) {
		return $content;
	}
	$wrap = '<div class="entry-summary p-summary">';
	if ( ! empty( $content ) ) {
		return $wrap . $content . '</div>';
	}
	return $content;
}

add_filter( 'the_excerpt', 'minimalistflex_the_excerpt', 1 );


function get_the_archive_thumbnail_url() {
	$image_id = null;
	if ( is_tax() || is_category() || is_tag() ) {
		$term     = get_queried_object();
		$image_id = get_term_meta( $term->term_id, 'image', true );
	}
	if ( $image_id ) {
		return wp_get_attachment_image_url( $image_id, 'thumbnail', true );
	}
}

function get_the_archive_thumbnail() {
	$image_id = null;
	if ( is_tax() || is_category() || is_tag() ) {
		$term     = get_queried_object();
		$image_id = get_term_meta( $term->term_id, 'image', true );
	}

	if ( $image_id ) {
		return wp_get_attachment_image( $image_id, 'thumbnail', true );
	}
}

function the_archive_thumbnail() {
	echo get_the_archive_thumbnail();
}

function minimalistflex_image_rss() {
	$url = get_the_archive_thumbnail_url();
	if ( ! $url ) {
		return;
	}
	echo '<image>' . PHP_EOL;
	echo '<url>' . $url . '</url>' . PHP_EOL;
	echo '<title>' . get_the_archive_title() . '</title>' . PHP_EOL;
	echo '<link>';
	self_link();
	echo '</link>' . PHP_EOL;
	echo '</image>' . PHP_EOL;
}

add_action( 'rss2_head', 'minimalistflex_image_rss' );
add_action( 'rss_head', 'minimalistflex_image_rss)' );
add_action( 'commentsrss2_head', 'minimalistflex_image_rss' );


function minimalistflex_is_404_singular() {
	// If any of these are present it is an attempt to get a single object not an archive.
	foreach ( array( 'name', 'page', 'p', 'pagename', 'attachment', 'attachment_id' ) as $var ) {
		if ( get_query_var( $var ) ) {
			return true;
		}
	}
	return false;
}

function minimalistflex_is_404_date() {
	// If any of these are present it is an attempt to get a date.
	foreach ( array( 'year', 'day', 'monthnum' ) as $var ) {
		if ( get_query_var( $var ) ) {
			return true;
		}
	}
	return false;
}

if ( ! function_exists( 'has_content' ) ) {
	function has_content( $post = 0 ) {
		$post = get_post( $post );
		return ( ! empty( $post->post_content ) );
	}
}


function minimalistflex_adjacent_post_link( $output, $format, $link, $post, $adjacent ) {
	if ( ! $post ) {
		return $output;
	}
	$previous = ( 'previous' === $adjacent );
		
	if ( empty( $post->post_title ) ) {
		if ( ! empty( $post->post_excerpt ) ) {
			$title = mb_strimwidth( wp_strip_all_tags( $post->post_excerpt ), 0, 40, '...' );
		} elseif ( ! empty( $post->post_content ) ) {
			$title = mb_strimwidth( wp_strip_all_tags( $post->post_content ), 0, 40, '...' );
		} else {
			$title = get_the_date( 'Y ' . get_option( 'time_format' ), $post );
		}

		if ( function_exists( 'kind_get_the_title' ) ) {
			$title = kind_get_the_title( $post, array( 'photo_size' => 'thumbnail' ) );
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $title, $post->ID );
			   
		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel  = $previous ? 'prev' : 'next';

		$string = '<a href="' . get_permalink( $post ) . '" rel="' . $rel . '">';
		
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';
										 
		$output = str_replace( '%link', $inlink, $format );
	}                             

	return $output;
}

add_filter( 'next_post_link', 'minimalistflex_adjacent_post_link', 11, 5 );
add_filter( 'previous_post_link', 'minimalistflex_adjacent_post_link', 11, 5 );

function minimalistflex_previous_posts_link_attributes( $attr ) {
	$attr   = explode( ' ', $attr );
	$attr[] = 'rel="prev"';
	return trim( implode( ' ', $attr ) );
}

add_filter( 'previous_posts_link_attributes', 'minimalistflex_previous_posts_link_attributes', 9 );


function minimalistflex_next_posts_link_attributes( $attr ) {
	$attr   = explode( ' ', $attr );
	$attr[] = 'rel="next"';
	return trim( implode( ' ', $attr ) );
}

add_filter( 'next_posts_link_attributes', 'minimalistflex_next_posts_link_attributes', 9 );

function minimalistflex_paginate_links( $r, $args = '' ) {
	global $wp_query, $wp_rewrite;
 
	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );
 
	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
 
	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
 
	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
 
	$defaults = array(
		'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below).
		'format'             => $format, // ?page=%#% : %#% is replaced by the page number.
		'total'              => $total,
		'current'            => $current,
		'aria_current'       => 'page',
		'show_all'           => false,
		'prev_next'          => true,
		'prev_text'          => __( '&laquo; Previous' ),
		'next_text'          => __( 'Next &raquo;' ),
		'end_size'           => 1,
		'mid_size'           => 2,
		'type'               => 'plain',
		'add_args'           => array(), // Array of query args to add.
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => '',
	);
 
	$args = wp_parse_args( $args, $defaults );
 
	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}
 
	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format       = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
		$format_query = isset( $format[1] ) ? $format[1] : '';
		wp_parse_str( $format_query, $format_args );
 
		// Find the query args of the requested URL.
		wp_parse_str( $url_parts[1], $url_query_args );
 
		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		foreach ( $format_args as $format_arg => $format_arg_value ) {
			unset( $url_query_args[ $format_arg ] );
		}
 
		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
	}
 
	// Who knows what else people pass in $args.
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds? Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
 
	$add_args   = $args['add_args'];
	$r          = '';
	$page_links = array();
	$dots       = false;
 
	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args ) {
			$link = add_query_arg( $add_args, $link );
		}
		$link .= $args['add_fragment'];
 
		$page_links[] = sprintf(
			'<a class="prev page-numbers" href="%s" rel="prev">%s</a>',
			/**
			 * Filters the paginated links for the given archive pages.
			 *
			 * @since 3.0.0
			 *
			 * @param string $link The paginated link URL.
			 */
			esc_url( apply_filters( 'paginate_links', $link ) ),
			$args['prev_text']
		);
	endif;
 
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = sprintf(
				'<span aria-current="%s" class="page-numbers current">%s</span>',
				esc_attr( $args['aria_current'] ),
				$args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
			);
 
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}
				$link .= $args['add_fragment'];
 
				$page_links[] = sprintf(
					'<a class="page-numbers" href="%s">%s</a>',
					/** This filter is documented in wp-includes/general-template.php */
					esc_url( apply_filters( 'paginate_links', $link ) ),
					$args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
				);
 
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
 
				$dots = false;
			endif;
		endif;
	endfor;
 
	if ( $args['prev_next'] && $current && $current < $total ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args ) {
			$link = add_query_arg( $add_args, $link );
		}
		$link .= $args['add_fragment'];
 
		$page_links[] = sprintf(
			'<a class="next page-numbers" href="%s" rel="next">%s</a>',
			/** This filter is documented in wp-includes/general-template.php */
			esc_url( apply_filters( 'paginate_links', $link ) ),
			$args['next_text']
		);
	endif;
 
	switch ( $args['type'] ) {
		case 'array':
			return $page_links;
 
		case 'list':
			$r .= "<ul class='page-numbers'>\n\t<li>";
			$r .= implode( "</li>\n\t<li>", $page_links );
			$r .= "</li>\n</ul>\n";
			break;
 
		default:
			$r = implode( "\n", $page_links );
			break;
	}
 
	return $r;
}

add_filter( 'paginate_links_output', 'minimalistflex_paginate_links', 11, 2 );


function minimalistflex_get_single_post_term_name( $taxonomy, $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}
	$_terms = get_the_terms( $post, $taxonomy );
	if ( is_wp_error( $_terms ) ) {
		return false;
	}
	if ( ! empty( $_terms ) ) {
		$term = array_shift( $_terms );
		return $term->name;
	}
	return false;
}
