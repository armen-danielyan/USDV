<ul class="social-icons">

	<?php if( '' != get_theme_mod( 'purpose_link_facebook' ) ) { ?>
		<li><a class="link-facebook" href="<?php echo esc_url( get_theme_mod( 'purpose_link_facebook' ) ); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_twitter' ) ) { ?>
		<li><a class="link-twitter" href="<?php echo esc_url( get_theme_mod( 'purpose_link_twitter' ) ); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_linkedin' ) ) { ?>
		<li><a class="link-linkedin" href="<?php echo esc_url( get_theme_mod( 'purpose_link_linkedin' ) ); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_googleplus' ) ) { ?>
		<li><a class="link-google" href="<?php echo esc_url( get_theme_mod( 'purpose_link_googleplus' ) ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_pinterest' ) ) { ?>
		<li><a class="link-pinterest" href="<?php echo esc_url( get_theme_mod( 'purpose_link_pinterest' ) ); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_instagram' ) ) { ?>
		<li><a class="link-instagram" href="<?php echo esc_url( get_theme_mod( 'purpose_link_instagram' ) ); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_youtube' ) ) { ?>
		<li><a class="link-youtube" href="<?php echo esc_url( get_theme_mod( 'purpose_link_youtube' ) ); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_github' ) ) { ?>
		<li><a class="link-github" href="<?php echo esc_url( get_theme_mod( 'purpose_link_github' ) ); ?>" target="_blank"><i class="fa fa-github"></i></a></li>
	<?php } ?>

	<?php if( '' != get_theme_mod( 'purpose_link_email' ) ) { ?>
		<li><a class="link-email" href="<?php echo purpose_get_email_link(); ?>" target="_blank"><i class="fa fa-envelope"></i></a></li>
	<?php } ?>
	
</ul>