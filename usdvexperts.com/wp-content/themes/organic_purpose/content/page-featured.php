<?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'purpose-featured-large' ) : false; ?>

<!-- BEGIN .post class -->
<div <?php post_class('holder'); ?> id="page-<?php the_ID(); ?>" <?php if ( has_post_thumbnail()) { ?> style="background-image: url(<?php echo $thumb[0]; ?>);" <?php } ?>>

	<!-- BEGIN .content -->
	<div class="content">
	
		<!-- BEGIN .article -->
		<div class="article">
		
			<div class="text-holder<?php if ( has_post_thumbnail()) { ?> text-white<?php } ?>">
				
				<?php the_content(__("Read More", 'organicthemes')); ?>
				
				<?php wp_link_pages(array(
					'before' => '<p class="page-links"><span class="link-label">' . __('Pages:', 'organicthemes') . '</span>',
					'after' => '</p>',
					'link_before' => '<span>',
					'link_after' => '</span>',
					'next_or_number' => 'next_and_number',
					'nextpagelink' => __('Next', 'organicthemes'),
					'previouspagelink' => __('Previous', 'organicthemes'),
					'pagelink' => '%',
					'echo' => 1 )
				); ?>
				
			</div>
		
		<!-- END .article -->
		</div>
	
	<!-- END .content -->
	</div>

<!-- END .post class -->
</div>