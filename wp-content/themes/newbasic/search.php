<?php get_header(); ?>

<div id="main">

<div id="content">

<?php printf( __( 'Showing Results for: %s', 'newbasic' ), get_search_query() ); ?>

<div class="smallbreaker"></div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>

<div class="post-date">
<?php _e('Posted on ', 'newbasic'); ?> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_time(get_option('date_format')) ?></a>
<?php _e('| by ', 'newbasic'); ?> <?php the_author_posts_link(); ?>
<?php _e(' | ', 'newbasic'); ?> <?php comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', ''); ?> 
</div>

<?php if ( has_post_thumbnail()) : ?>
   <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
   <?php the_post_thumbnail('category-thumb', array('class' => 'alignnone')); ?>
   </a>
 <?php endif; ?>

<?php the_excerpt(''); ?>

<div class="smallbreaker"></div>

<div class="more-link"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('Continue Reading', 'newbasic'); ?></a></div>

</div>

<div class="breaker"></div>

<?php endwhile; else: ?>

<p><?php _e('Sorry, no posts matched your criteria.', 'newbasic'); ?></p><?php endif; ?>

<?php wp_link_pages(array('next_or_number'=>'next', 'previouspagelink' => ' &laquo; ', 'nextpagelink'=>' &raquo;')); ?>

<?php comments_template(); ?>

<h4 class="pagi">
<?php posts_nav_link(' &#183 ', 'Previous Page', 'Next Page'); ?>
</h4>

</div>

<?php get_sidebar(); ?>

</div>

</div>

<?php get_footer(); ?>