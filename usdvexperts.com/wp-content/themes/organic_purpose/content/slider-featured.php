<!-- BEGIN .slideshow -->
<div class="slideshow">

	<!-- BEGIN .flexslider -->
	<div class="flexslider loading" data-speed="<?php echo get_theme_mod('transition_interval', '12000'); ?>">
	
		<div class="preloader"></div>
		
		<!-- BEGIN .slides -->
		<ul class="slides">
		
			<?php $slider = new WP_Query(array( 'cat'=>get_theme_mod('category_slideshow_home', '1'), 'posts_per_page'=>20, 'suppress_filters'=>0 )); ?>
			<?php if ($slider->have_posts()) : while($slider->have_posts()) : $slider->the_post(); ?>
			
				<?php if (!get_post_format()) { get_template_part('formats/slider', 'standard'); } else { get_template_part('formats/slider', get_post_format()); } ?>
			
			<?php endwhile; ?>
			<?php endif; ?>
			
		<!-- END .slides -->
		</ul>
		
	<!-- END .flexslider -->
	</div>

<!-- END .slideshow -->
</div>