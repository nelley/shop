<div id="sidebar" class="clearfix">	
	<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
    <?php	   
	if(is_shop() && is_active_sidebar('sidebar_product')) : dynamic_sidebar('sidebar_product');
	elseif(is_product() && is_active_sidebar('sidebar_product')) : dynamic_sidebar('sidebar_product');
	elseif(is_product_category() && is_active_sidebar('sidebar_product')) : dynamic_sidebar('sidebar_product');
	elseif(is_product_tag() && is_active_sidebar('sidebar_product')) : dynamic_sidebar('sidebar_product');	
	endif;
	?>
</div><!-- end sidebar -->