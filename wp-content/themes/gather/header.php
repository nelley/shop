<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<?php $heading_font = of_get_option('ttrust_heading_font'); ?>
	<?php $body_font = of_get_option('ttrust_body_font'); ?>
	<?php $home_message_font = of_get_option('ttrust_home_message_font'); ?>
	<?php if ($heading_font != "") : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($heading_font)); ?>:regular,italic,bold,bolditalic" />
	<?php else : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" />
	<?php endif; ?>
	
	<?php if ($body_font != "" && $body_font != $heading_font) : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($body_font)); ?>:regular,italic,bold,bolditalic" />
	<?php elseif ($heading_font != "") : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" />
	<?php endif; ?>
	
	<?php if ($home_message_font != "") : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($home_message_font)); ?>:regular,italic,bold,bolditalic" />
	<?php else : ?>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold" />
	<?php endif; ?>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if (of_get_option('ttrust_favicon') ) : ?>
		<link rel="shortcut icon" href="<?php echo of_get_option('ttrust_favicon'); ?>" />
	<?php endif; ?>
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>	
</head>

<body <?php body_class(); ?> >

<div id="container">	
<div id="header">
	<div class="inside">
	<div class="top clearfix">
		<div class="left">
			<?php $headerMessage = of_get_option('ttrust_header_message'); ?>
			<?php if($headerMessage) : ?>		
				<p><?php echo $headerMessage; ?></p>				
			<?php else: ?>
				<p><?php echo get_bloginfo ('description'); ?></p>
			<?php endif; ?>			
		</div>
		
		<div class="right">
			<!-- header.php NL001 --> 
			<?php if(is_user_logged_in()) : ?>
				<?php wp_nav_menu( array('menu_class' => 'sf-menu', 'theme_location' => 'top', 'fallback_cb' => '' )); ?>
			<?php endif;?>
		</div>
	</div>
	<div class="bottom clearfix">						
		<?php $ttrust_logo = of_get_option('logo'); ?>
		<div id="logo">
		<?php if($ttrust_logo) : ?>				
			<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
		<?php else : ?>				
			<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>				
		<?php endif; ?>	
		</div>
		<!-- header.php NL002 -->
		<?php if(is_user_logged_in()) : ?>
			<div id="mainNav" class="clearfix"><?php wp_nav_menu( array('menu_class' => 'sf-menu', 'theme_location' => 'main', 'fallback_cb' => 'default_nav' )); ?></div>
		<?php else :?>
			<div id="mainNav" class="clearfix"><?php wp_nav_menu( array('menu_class' => 'sf-menu', 'theme_location' => 'main', 'fallback_cb' => 'default_nav' )); ?></div>
		<?php endif;?>
	</div>			
	</div>	
</div>


<div id="main" class="clearfix">
<!-- header.php NL003 -->
	<?php if(is_front_page()):?>	
		<?php if(of_get_option('ttrust_slideshow_enabled')) get_template_part( 'part-slideshow'); ?>
		
		<?php $homeMessage = of_get_option('ttrust_home_message'); ?>
		<div id="homeMessage" class="clearfix <?php if(!$homeMessage) echo "empty"; ?>">
		<?php if($homeMessage) : ?>		
			<p><?php echo $homeMessage; ?></p>
		<?php endif; ?>			
		</div>		
	<?php endif; ?>
	
	