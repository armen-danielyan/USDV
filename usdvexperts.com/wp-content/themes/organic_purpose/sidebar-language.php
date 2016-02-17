<div class="row topnav">

	<?php
	$current_language = get_option('WPLANG');
	$current_language = get_locale();
	$current_language = !empty($current_language) ? $current_language : 'en_US';
	$langItemArray  = array(
		'en_US' => array(
			'name' => 'English',
			'flag' => 'flag-uk.jpg',
			'code' => 'en'
		),
		'es_ES' => array(
			'name' => 'español',
			'flag' => 'flag-es.jpg',
			'code' => 'es'
		),
		'it_IT' => array(
			'name' => 'Italian',
			'flag' => 'flag-it.jpg',
			'code' => 'it'
		),
		'ar' => array(
			'name' => 'العَرَبِية',
			'flag' => 'flag-sa.jpg',
			'code' => 'ar'
		),

	);
	if($current_page_id = get_the_ID()){
		$current_page_url = get_permalink($current_page_id);
	}else{
		$current_page_url = home_url();
	}
	?>

	<ul class="list-inline links-list pull-right">
		<li>
			<div class="dropdown">
				<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $langItemArray[$current_language]['flag']; ?>"><?php echo $langItemArray[$current_language]['name']; ?><span class="caret"></span>
				</button>
				<ul class="dropdown-menu auto-width" role="menu" aria-labelledby="dLabel">
					<?php
					foreach($langItemArray as $code=>$lang){
						if($code != $current_language){?>
							<li class="langSelector" data-value="ar-AE">
								<a href="<?php echo add_query_arg( array('lang' => $langItemArray[$code]['code']), $current_page_url ); ?>">
									<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $langItemArray[$code]['flag']; ?>"><?php echo $langItemArray[$code]['name']; ?>
								</a>
							</li>
						<?php }
					}
					?>
				</ul>
			</div>
		</li>
		<li>|</li>
		<li>
			<a id="logout" href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Log Out', 'organicthemes'); ?></a>
		</li>
	</ul>
</div>