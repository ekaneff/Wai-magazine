<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Cousine|Roboto" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="site-branding">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="header-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="spread">WAI</span> Magazine</a></h1>
				<?php else : ?>
					<h1 class="header-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="spread">WAI</span> Magazine</a></h1>
				<?php
				endif;
 				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<ul class="nav navbar-nav custom-navigation">
					<?php
					if ( is_front_page() ) : ?>
						<li class="active"><a href="/">All</a></li>
						<li><a href="/?page_id=7">DevOps</a></li>
						<li><a href="/?page_id=9">Docker</a></li>
						<li><a href="/?page_id=5">Git</a></li>
					<?php elseif ( is_page( "DevOps" ) ) : ?>
						<li><a href="/">All</a></li>
						<li class="active"><a href="/?page_id=7">DevOps</a></li>
						<li><a href="/?page_id=9">Docker</a></li>
						<li><a href="/?page_id=5">Git</a></li>
					<?php elseif ( is_page( "Docker" ) ) : ?>
						<li><a href="/">All</a></li>
						<li><a href="/?page_id=7">DevOps</a></li>
						<li class="active"><a href="/?page_id=9">Docker</a></li>
						<li><a href="/?page_id=5">Git</a></li>
					<?php elseif ( is_page( "Github" ) ) : ?>
						<li><a href="/">All</a></li>
						<li><a href="/?page_id=7">DevOps</a></li>
						<li><a href="/?page_id=9">Docker</a></li>
						<li class="active"><a href="/?page_id=5">Git</a></li>
					<?php else : ?>
						<li class="active"><a href="/">All</a></li>
						<li><a href="/?page_id=7">DevOps</a></li>
						<li><a href="/?page_id=9">Docker</a></li>
						<li><a href="/?page_id=5">Git</a></li>
					<?php endif; ?>
				</ul>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
