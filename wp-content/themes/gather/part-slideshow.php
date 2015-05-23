<?php
query_posts( array(
	'ignore_sticky_posts' => 1,
	'posts_per_page' => 20,
	'post_type' => 'slide'
));
?>
<?php if(have_posts()) :?>
<div class="slideshow">
			
	<div class="flexslider">		
		<ul class="slides">
			<?php $i = 1; while (have_posts()) : the_post(); ?>
			<?php
			//Get slide options
			$slide_description = get_post_meta($post->ID, "_ttrust_slide_description_value", true);					
			$show_slide_text = get_post_meta($post->ID, "_ttrust_show_slide_text_value", true);
			?>					
		
			<li id="slide<?php echo $i; ?>">				
				<?php the_content(); ?>				
				<?php if($show_slide_text) : ?>
				<div class="flex-caption">
					<h2><span><?php the_title(); ?></span></h2>
					<?php echo wpautop(do_shortcode($slide_description)); ?>
				</div>
				<?php endif; ?>
			</li>		
			
			<?php $i++; ?>			
		
			<?php endwhile; ?>
		</ul>
	</div>	
	
	
</div>
<?php endif; ?>
<?php wp_reset_query();?>






