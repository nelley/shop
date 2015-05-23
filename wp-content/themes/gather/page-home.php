<?php /*
Template Name: Home
*/ ?>
<?php get_header(); ?>
<div id="middle" class="clearfix">	
<div id="content" class="full">
			
<?php get_template_part( 'part-products-home'); ?>	

<div id="page" class="homeSection clearfix">			
	<?php the_content(); ?>
</div>
</div>
</div>
<?php get_footer(); ?>	