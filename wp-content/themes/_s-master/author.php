<?php get_header(); ?>

<div id="content" class="narrowcolumn">
    <!-- This sets the $curauth variable -->

        <?php
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
        ?>

    <div class="container">
        <div class="author-current">
            <div class="container">
                <!-- Avatar Images Call -->
                <?php 
                    $author_link='http://localhost:8000/wp-content/themes/_s-master/authors/'.$curauth->first_name.' '.$curauth->last_name.".jpg";
                ?>
                <h3>About the Author</h3>

                <img class="author-image" src="<?php echo $author_link ?>"/>

                <!-- Avatar Image Ends -->
                <h1><?php echo $curauth->first_name; ?> <?php echo $curauth->last_name; ?></h1>

                <em><?php echo nl2br(get_the_author_meta('description')); ?></em>
            </div>
        </div>

        <div class="author-content">

        <!-- The Loop -->

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <p><?php the_time(get_option('date_format')); ?></p>

                    </header>

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
                        ?>
                    </div>
                    <?php
                    if ( comments_open() ) :
                                echo '<p>';
                                comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post');
                                echo '</p>';
                            endif;
                        ?>
                </article>

            <?php endwhile; else: ?>
                <p><?php _e('No posts by this author.'); ?></p>

            <?php endif; ?>

        <!-- End Loop -->

        </div>
    </div>
</div>

<?php get_footer(); ?>
