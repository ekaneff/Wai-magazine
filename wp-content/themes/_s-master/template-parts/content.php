<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="post">
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title home-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
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
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Read More', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		
		if ( comments_open() ) :
							    echo '<p>';
							    comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post');
							    echo '</p>';
							endif;
							?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
