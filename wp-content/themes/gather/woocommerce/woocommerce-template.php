<?php

/**
 * WooCommerce Product Thumbnail
 **/
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
	function woocommerce_get_product_thumbnail( $size = 'ttrust_one_fourth_cropped', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post, $woocommerce;

		if ( ! $placeholder_width )
			$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
		if ( ! $placeholder_height )
			$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
		if ( has_post_thumbnail() ){
			return get_the_post_thumbnail( $post->ID, $size ); 
		}else{ 
			$tmp = '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
			return '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
		}
	}
}


/**
 * WooCommerce Single Product
 **/
if ( ! function_exists( 'custom_woocommerce_single_product_content' ) ) {
	function custom_woocommerce_single_product_content( $wc_query = false  ) {

		// Let developers override the query used, in case they want to use this function for their own loop/wp_query
		if ( ! $wc_query ) {
			global $wp_query;

			$wc_query = $wp_query;
		}

			?>


		<?php
		if ( $wc_query->have_posts() ) while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>

			<?php do_action( 'woocommerce_before_single_product' ); ?>

			<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php do_action( 'woocommerce_before_single_product_summary' ); ?>

				<div class="summary" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

					<?php do_action( 'woocommerce_single_product_summary' ); ?>

				</div>
	
				<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
				
			</div>

			<?php do_action( 'woocommerce_after_single_product' ); ?>

		<?php endwhile;

	}
}

/**
 * WooCommerce Related Products
 **/
if ( ! function_exists( 'woocommerce_output_related_products' ) ) {
	function woocommerce_output_related_products() {
		woocommerce_related_products( 3, 3  );
	}
}

?>