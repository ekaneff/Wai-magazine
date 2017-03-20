<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */


/*
			============= Original Single Page =============

			get_template_part( 'template-parts/content', get_post_format() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		*/




get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<?php
				while ( have_posts() ) : the_post();
					?>
					<div class="single-container">
						<!-- This is where the title of the post is -->
						<div class="single-header single-content-container">
							<h2><?php the_title(); ?></h2>
						</div>
						<div class="single-content-container">
							<p class="single-author"><a href="/?author=<?php the_author_meta('ID') ?>"><?php the_author(); 
							?></a> / <?php the_date()?></p>
							
							<!-- This is where the content of the post is -->
							<?php the_content(); ?>
						</div>
					</div>

				<?php
				endwhile; // End of the loop.
				
				if ( comments_open() || get_comments_number() ) :
						comments_template();
				endif;
				?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
