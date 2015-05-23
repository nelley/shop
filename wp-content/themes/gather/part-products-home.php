<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
<?php if(is_plugin_active('woocommerce/woocommerce.php')): ?>

<?php $home_product_count = intval(of_get_option('ttrust_home_product_count')); ?>
<?php $ttrust_featured_products_on_home = of_get_option('ttrust_featured_products_on_home'); ?>	

<?php if($home_product_count > 0) : ?>	
<div id="products" class="full homeSection clearfix">			
	<h2 class="sectionHead"><span><?php echo of_get_option('ttrust_featured_products_title'); ?></span></h2>		
	
	<?php if($ttrust_featured_products_on_home) : //show only featured products	
		query_posts( array(
			'ignore_sticky_posts' => 1,	
			'meta_key' => '_featured',
			'meta_value' => 'yes',		  			
    		'posts_per_page' => $home_product_count,
    		'post_type' => array(				
				'product'					
				)
		));		
	else: //show recent products
		query_posts( array(
			'ignore_sticky_posts' => 1,			  			
    		'posts_per_page' => $home_product_count,
    		'post_type' => array(				
				'product'					
				)
		));
	endif;	
	?>		
					
				
		<?php if ( have_posts() ) : ?>
		
			<?php do_action('woocommerce_before_shop_loop'); ?>
		
			<ul class="products clearfix">
			
				<?php woocommerce_product_subcategories(); ?>
		
				<?php while ( have_posts() ) : the_post(); ?>
		
					<?php woocommerce_get_template_part( 'content', 'product' ); ?>
		
				<?php endwhile; // end of the loop. ?>
				
			</ul>

			<?php do_action('woocommerce_after_shop_loop'); ?>
		
		<?php else : ?>
		
			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
					
				<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>
					
			<?php endif; ?>
		
		<?php endif; ?>
		<?php wp_reset_query();	?>		
	
</div>
<?php endif; ?>
<?php endif; ?>