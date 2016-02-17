<?php
/**
* This page template is used to display a 404 error message.
*
* @package Purpose
* @since Purpose 1.0
*
*/
get_header(); ?>
	
<!-- BEGIN .row -->
<div class="row">

	<!-- BEGIN .content -->
	<div class="content no-thumb">

	<?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
	
		<!-- BEGIN .eleven columns -->
		<div class="eleven columns">
	
		<div class="postarea">
			<h1 class="headline"><?php _e("Not Found, Error 404", 'organicthemes'); ?></h1>
			<p><?php _e("The page you are looking for no longer exists.", 'organicthemes'); ?></p>
		</div>
		
		<!-- END .eleven columns -->
		</div>
		
		<!-- BEGIN .five columns -->
		<div class="five columns">
		
			<?php get_sidebar( 'page' ); ?>
			
		<!-- END .five columns -->
		</div>
	
	<?php else : ?>
	
		<!-- BEGIN .sixteen columns -->
		<div class="sixteen columns">
	
		<div class="postarea full">
			<h1 class="headline"><?php _e("Not Found, Error 404", 'organicthemes'); ?></h1>
			<p><?php _e("The page you are looking for no longer exists.", 'organicthemes'); ?></p>
		</div>
		
		<!-- END .sixteen columns -->
		</div>
		
	<?php endif; ?>
	
	<!-- END .content -->
	</div>

<!-- END .row -->
</div>

<?php get_footer(); ?>