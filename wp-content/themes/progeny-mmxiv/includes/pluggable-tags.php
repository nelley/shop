<?php
/**
 * Pluggable template tags from parent theme.
 *
 * @package Progeny_MMXIV
 * @since 1.1.0
 */

/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since 1.0.0
 */
function twentyfourteen_list_authors() {
	$member_ids = array_filter( wp_parse_id_list( get_post_meta( get_the_ID(), 'member_ids', true ) ) );
	$contributor_ids = $member_ids;

	if ( empty( $contributor_ids ) ) {
		$contributor_ids = get_users( array(
			'fields'  => 'ID',
			'orderby' => 'post_count',
			'order'   => 'DESC',
			'who'     => 'authors',
		) );
	}

	// Display page content before contributor list.
	progeny_contributor_page_content();

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( empty( $member_ids ) && ! $post_count ) {
			continue;
		}
		?>

		<div class="contributor">
			<div class="contributor-info">
				<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
				<div class="contributor-summary">
					<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
					<p class="contributor-bio">
						<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
					</p>

					<?php if ( $post_count ) : ?>
						<a class="contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
							<?php printf( _n( '%d Article', '%d Articles', $post_count, 'progeny-mmxiv' ), $post_count ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $twitter_username = get_the_author_meta( 'twitter', $contributor_id ) ) : ?>
						<span class="icon">
							<a class="contributor-twitter-link" href="<?php echo esc_url( 'http://twitter.com/' . $twitter_username ); ?>" target="_blank">
								<?php _e( 'Twitter', 'progeny-mmxiv' ); ?>
							</a>
						</span>
					<?php endif; ?>

					<?php if ( $facebook_url = get_the_author_meta( 'facebook', $contributor_id ) ) : ?>
						<span class="icon">
							<a class="contributor-facebook-link" href="<?php echo esc_url( $facebook_url ); ?>" target="_blank">
								<?php _e( 'Facebook', 'progeny-mmxiv' ); ?>
							</a>
						</span>
					<?php endif; ?>

					<?php if ( $website_url = get_the_author_meta( 'user_url', $contributor_id ) ) : ?>
						<span class="icon icon-link">
							<a class="contributor-website-link" href="<?php echo esc_url( $website_url ); ?>" target="_blank">
								<?php _e( 'Website', 'progeny-mmxiv' ); ?>
							</a>
						</span>
					<?php endif; ?>

					<?php if ( is_user_logged_in() && current_user_can( 'edit_user', $contributor_id ) ) : ?>
						<span class="icon icon-link">
							<a class="contributor-edit-link" href="<?php echo esc_url( get_edit_user_link( $contributor_id ) ); ?>" target="_blank">
								<?php _e( 'Edit', 'progeny-mmxiv' ); ?>
							</a>
						</span>
					<?php endif; ?>
				</div><!-- .contributor-summary -->
			</div><!-- .contributor-info -->
		</div><!-- .contributor -->

		<?php
	endforeach;
}
