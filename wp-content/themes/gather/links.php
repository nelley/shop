<?php get_header(); ?>		
		<div id="middle">
			<div id="pageHead">
				<h1><?php _e('Links', 'themetrust'); ?></h1>
			</div>					 
		<div id="content" class="twoThird clearfix">			    
			<div class="post">					
				<ul>
					<?php get_links_list(); ?>
				</ul>				
			</div>						    	
		</div>		
		<?php get_sidebar(); ?>
		</div>
<?php get_footer(); ?>
