<div class="fixed-header-box">
	<div class="limit-wrapper">
		<nav id="top-nav">
			<?php wp_nav_menu(array('fallback_cb' => '', 'theme_location' => 'menu-top' )); ?>
		</nav>
		
		<?php if(wpv_get_option('phone-num-top') != ''): ?>
			<div id="phone-num"><div><?php echo do_shortcode(wpv_get_option('phone-num-top'))?></div></div>
		<?php endif ?>
				
		<header class="main-header">
		
			<div class="header-left">
				<div class="logo-wrapper">
				<?php
					$logo = wpv_get_option('custom-header-logo');
					$logo2x = wpv_get_option('custom-header-logo2x');

					if(!empty($logo2x)) {
						$logo_editor = wp_get_image_editor(wpv_get_attachment_file($logo2x));
						$logo2x_size = is_wp_error($logo_editor) ? array('height'=>0, 'width'=>0) : $logo_editor->get_size();
					}

				?>
					<a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" class="logo a-reset <?php if(empty($logo)) echo 'text-logo' ?>"><?php 
						if($logo):
						?>
							<img src="<?php echo $logo;?>" alt="<?php bloginfo('name')?>" class="<?php if($logo2x) echo 'hide-hidpi' ?>"/>
							<?php if(!empty($logo2x)): ?>
								<img src="<?php echo $logo2x;?>" alt="<?php bloginfo('name')?>" class="show-hidpi-inline" height="<?php echo floor($logo2x_size['height']/2) ?>"/>
							<?php endif ?>
						<?php
						else:
							bloginfo( 'name' );
						endif;
						?>
						<span class="logo-tagline"><?php bloginfo('description') ?></span>
					</a>
				</div>
			</div>
			
			<div class="header-center">
				<div id="menus">
					<nav id="main-menu">
						<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
						<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'wpv' ); ?>" class="visuallyhidden"><?php _e( 'Skip to content', 'wpv' ); ?></a>
						<?php
							if(has_nav_menu('menu-header')) {
								wp_nav_menu(array('theme_location' => 'menu-header'));
							} else {
								wp_page_menu();
							}
						?>
					</nav>
				</div>
			</div>
			
			<div class="header-right">
				
				<div class="search-extend">
					<form action="<?php echo home_url() ?>/" class="searchform" method="get" role="search" novalidate="">
						<input type="text" required="required" placeholder="<?php _e('Search', 'wpv') ?>" name="s" value="" id="search-text-widget" />
						<button type="submit" id="top-search-submit"></button>
						<?php if(defined('ICL_LANGUAGE_CODE')): ?>
							<input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>"/>
						<?php endif ?>
					</form>
				</div>
				
			</div>
		</header>
	</div>
	
	<?php do_action('wpv_header_box'); ?>
</div><!-- / .fixed-header-box -->
<div class="shadow-bottom"></div>