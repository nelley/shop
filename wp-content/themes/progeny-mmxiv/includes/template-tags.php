<?php
/**
 * Custom template tags.
 *
 * @package Progeny_MMXIV
 * @since 1.0.0
 */

/**
 * Retrieve the title for an archive.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post to get the archive title for. Defaults to the current post.
 * @return string
 */
function progeny_get_archive_title( $post = null, $singular = false ) {
	$post = get_post( $post );

	if ( $singular ) {
		$title = get_post_type_object( $post->post_type )->labels->singular_name;
	} else {
		$title = get_post_type_object( $post->post_type )->label;
	}

	return $title;
}

/**
 * Print archive link.
 *
 * @since 1.0.0
 */
function progeny_archive_link() {
	$post_type = get_post_type();
	$link      = get_post_type_archive_link( $post_type );

	if ( 'audiotheme_track' == $post_type ) {
		$link = get_permalink( get_post()->post_parent );
	}
	?>
	<a href="<?php echo esc_url( $link ); ?>">
		<?php echo esc_html( progeny_get_archive_title() ); ?>
	</a>
	<?php
}

/**
 * Display page content on contributor page template.
 *
 * @since 1.0.0
 */
function progeny_contributor_page_content() {
	if ( '' != get_post()->post_content ) :
	?>
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'progeny-mmxiv' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>
		</div>
	<?php
	endif;
}
