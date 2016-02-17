<?php
/**
* This template is used to display the home page.
*
* @package Purpose
* @since Purpose 1.0
*
*/
get_header(); ?>

<?php if ( '' != get_theme_mod( 'category_slideshow_home' ) ) { ?>

<!-- BEGIN .row -->
<div class="row">

	<!-- BEGIN .sixteen columns -->
	<div class="sixteen columns">
		
		<!-- BEGIN .home-slider -->
		<div class="home-slider">
		
			<?php get_template_part( 'content/slider', 'featured' ); ?>
			
		<!-- END .home-slider -->
		</div>

	<!-- END .sixteen columns -->
	</div>

<!-- END .row -->
</div>

<?php } ?>
	
<!-- BEGIN .featured-pages -->
<div class="featured-pages<?php $slider = get_theme_mod( 'category_slideshow_home', '1' ); if ( empty( $slider ) ) { ?> no-thumb<?php } ?>">

	<!-- BEGIN .row -->
	<div class="row">
	
	<?php if ( 'false' != get_theme_mod( 'page_one', '2' ) ) { ?>
	<?php if ( '' != get_theme_mod( 'page_one', '2' ) ) { ?>
		
		<?php $recent = new WP_Query('page_id='.get_theme_mod( 'page_one', '2' )); while($recent->have_posts()) : $recent->the_post(); ?>
		<?php global $more; $more = 0; ?>
		
			<?php get_template_part( 'content/page', 'featured' ); ?>
		
		<?php endwhile; ?>
		
	<?php } ?>
	<?php } ?>
	
	<!-- END .row -->
	</div>
		
	<!-- BEGIN .row -->
	<div class="row">
	
	<?php if ( 'false' != get_theme_mod( 'page_two', '2' ) ) { ?>
	<?php if ( '' != get_theme_mod( 'page_two', '2' ) ) { ?>
		
		<?php $recent = new WP_Query('page_id='.get_theme_mod( 'page_two', '2' )); while($recent->have_posts()) : $recent->the_post(); ?>
		<?php global $more; $more = 0; ?>
		
			<?php get_template_part( 'content/page', 'featured' ); ?>
		
		<?php endwhile; ?>
		
	<?php } ?>
	<?php } ?>
	
	<!-- END .row -->
	</div>
	
	<!-- BEGIN .row -->
	<div class="row">
	
	<?php if ( 'false' != get_theme_mod( 'page_three', '2' ) ) { ?>
	<?php if ( '' != get_theme_mod( 'page_three', '2' ) ) { ?>
		
		<?php $recent = new WP_Query('page_id='.get_theme_mod( 'page_three', '2' )); while($recent->have_posts()) : $recent->the_post(); ?>
		<?php global $more; $more = 0; ?>
		
			<?php get_template_part( 'content/page', 'featured' ); ?>
		
		<?php endwhile; ?>
		
	<?php } ?>
	<?php } ?>
	
	<!-- END .row -->
	</div>
	
<!-- END .featured-pages -->
</div>

<!-- BEGIN .featured-posts -->
<div class="featured-posts">

	<!-- BEGIN .row -->
	<div class="row">
	
	<?php if ( '-1' != get_theme_mod( 'category_news', '1' ) ) { ?>
	<?php if ( '' != get_theme_mod( 'category_news', '1' ) ) { ?>

		<?php get_template_part( 'content/post', 'featured' ); ?>
		
	<?php } ?>
	<?php } ?>

	<!-- END .row -->
	</div>
	
<!-- END .featured-posts -->
</div>

<?php get_footer(); ?>