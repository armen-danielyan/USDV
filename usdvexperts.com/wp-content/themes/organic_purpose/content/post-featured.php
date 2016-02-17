<!-- BEGIN .content -->
<div class="content">

	<!-- BEGIN .article -->
	<div class="article">
	
		<h4 class="headline text-center"><?php echo esc_html( purpose_cat_id_to_name(get_theme_mod('category_news', '1') ) ); ?></h4>
		
		<!-- BEGIN .featured-posts-wrap -->
		<div class="featured-posts-wrap">
		
			<?php $news = new WP_Query(array('cat'=>get_theme_mod('category_news', '1'), 'posts_per_page'=>get_theme_mod('postnumber_news', '3'), 'paged'=>$paged, 'suppress_filters'=>0)); ?>
			<?php if ($news->have_posts()) : while($news->have_posts()) : $news->the_post(); ?>
			
			<!-- BEGIN .third -->
			<div class="third">
			
				<!-- BEGIN .post class -->
				<div <?php post_class('holder'); ?> id="post-<?php the_ID(); ?>">
						
					<?php if ( '' != get_the_post_thumbnail()) { ?>
				
						<a class="feature-img" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'organicthemes' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail( 'purpose-featured-small' ); ?></a>
				
					<?php } ?>
					
					<!-- BEGIN .information -->
					<div class="information">
						
						<h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						
						<div class="excerpt">
							<?php the_excerpt(); ?>
						</div>
					
					<!-- END .information -->
					</div>
				
				<!-- END .post class -->
				</div>
			
			<!-- END .third -->
			</div>
			
			<?php endwhile; else : ?>
			
			<!-- BEGIN .information -->
			<div class="information">
				<h2 class="title"><?php _e("No Posts Found", 'organicthemes'); ?></h2>
				<p><?php _e("We're sorry, but no posts have been found. Create a post to be added to this section, and configure your theme options.", 'organicthemes'); ?></p>
			<!-- END .information -->
			</div>
			
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		
		<!-- END .featured-posts-wrap -->
		</div>

	<!-- END .article -->
	</div>

<!-- END .content -->
</div>