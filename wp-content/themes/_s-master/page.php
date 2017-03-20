<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */


/*
		This is the standard Loop Call
		------------------------------
	<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<?php
					$the_query = new WP_Query( array( 'category_name' => get_the_title() ) );
				?>
					<?php if ( $the_query->have_posts() ) : ?>

					<!-- pagination here -->

					<!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<!-- The beginning of the Card -->
					<div class="post category-post entry-content">
						<!-- This is where the title of the post is -->
						

						<?php the_title( '<h2 class="entry-title home-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
						<div class="entry-meta">
							<!-- Avatar Images Call -->
							<?php 
								$author_link='http://localhost:8000/wp-content/themes/_s-master/authors/'.get_the_author_meta("display_name").".jpg";
							?>
							<img class="avatar" width="50" height="50" src="<?php echo $author_link ?>"/>

							<!-- Avatar Image Ends -->
							<div class="author-creds">
								<a href="/?author=<?php the_author_meta('ID') ?>"><?php the_author(); ?></a>
								<p><?php the_time(get_option('date_format')); ?></p>
							</div>
						</div><!-- .entry-meta -->

						<!-- This is where the content of the post is -->
						<?php the_content("Read More"); ?>
						<?php
						if ( comments_open() ) :
							    echo '<p>';
							    comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post');
							    echo '</p>';
							endif;

						?>
					</div>

					<?php endwhile; ?>
					<!-- end of the loop -->

					<!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<div class="container">
						<p class="post no-post"><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
