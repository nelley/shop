<?php
/**
 * Content Wrappers
 */
$id = ( get_option('template') === 'twentyeleven' ) ? 'primary' : 'container';
?>

	<div id="middle" class="clearfix">	  
		<div id="pageHead">
			<h1 class="page-title">
				<?php if ( is_search() ) : ?>
					<?php 
						printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() ); 
						if ( get_query_var( 'paged' ) )
							printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
					?>
				<?php elseif ( is_tax() ) : ?>
					<?php echo single_term_title( "", false ); ?>
				<?php else : ?>
					<?php 
						$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );

						echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
					?>
				<?php endif; ?>
			</h1>
		</div>
	<div id="content" role="main">