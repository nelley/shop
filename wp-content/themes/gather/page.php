<?php if ( get_the_title() == "fetchentry" ) : ?>
	<?php fetch_bkt(); ?>
<?php elseif ( get_the_title() == "uploadentry" ) : ?>
	<?php upload_entry(); ?>
<?php else : ?>
	<?php get_header(); ?>
			<!-- page.php NL004 -->
			<div id="middle" class="clearfix">
				<?php if(!is_front_page()):?>
				<div id="pageHead">
					<h1><?php the_title(); ?></h1>
					<?php $page_description = get_post_meta($post->ID, "_ttrust_page_description_value", true); ?>
					<?php if ($page_description) : ?>
						<p><?php echo $page_description; ?></p>
					<?php endif; ?>				
				</div>
				<?php endif; ?>
			<!-- page.php NL005 -->
			<div id="content" class="threeFourth clearfix">
				<?php while (have_posts()) : the_post(); ?>
					<div <?php post_class('clearfix'); ?>>
						<?php the_content(); ?>
					</div>
					<?php comments_template('', true); ?>
				<?php endwhile; ?>
			</div>
			<?php get_sidebar(); ?>
			</div>
		<!-- page.php NL006 -->
	<?php get_footer(); ?>
<?php endif; ?>
