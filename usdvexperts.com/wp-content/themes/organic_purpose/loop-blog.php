<?php $wp_query = new WP_Query(array('cat'=>get_theme_mod('category_blog'), 'posts_per_page'=>get_theme_mod('postnumber_blog'), 'paged'=>$paged, 'suppress_filters'=>0)); ?>
<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
<?php global $more; $more = 0; ?>

	<!-- BEGIN .blog-holder -->
	<div class="blog-holder">
	
		<?php 
		if (!get_post_format()) 
			{ get_template_part('formats/format', 'standard'); } 
		else if (get_post_format() != 'quote' && get_post_format() != 'status')
			{ get_template_part('formats/format', get_post_format()); } 
		?>
	
	<!-- END .blog-holder -->
	</div>

<?php endwhile; ?>

	<?php if($wp_query->max_num_pages > 1) { ?>
		<!-- BEGIN .pagination -->
		<div class="pagination">
			<?php echo purpose_get_pagination_links(); ?>
		<!-- END .pagination -->
		</div>
	<?php } ?>

<?php else : ?>

	<div class="error-404">
		<h1 class="headline"><?php _e("No Posts Found", 'organicthemes'); ?></h1>
		<p><?php _e("We're sorry, but no posts have been found. Create a post to be added to this section, and configure your theme options.", 'organicthemes'); ?></p>
	</div>

<?php endif; ?>