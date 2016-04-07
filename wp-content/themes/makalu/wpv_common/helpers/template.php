<?php

/**
 * Various template helpers
 */

/**
 * page layout
 */
function wpv_get_layout() {
	global $post;

	if(!defined('WPV_LAYOUT_TYPE')) {
		$layout_type = '';
		if(is_singular(array('page', 'post', 'portfolio', 'product'))) {
			$layout_type = wpv_post_default('layout-type', 'default-body-layout');
		} else {
			$layout_type = wpv_get_option('default-body-layout');
		}

		if(empty($layout_type)) {
			$layout_type = 'full';
		}

		define('WPV_LAYOUT_TYPE', $layout_type);

		switch($layout_type) {
			case 'left-only':
				define('WPV_LAYOUT', 'left-sidebar');
			break;
			case 'right-only':
				define('WPV_LAYOUT', 'right-sidebar');
			break;
			case 'left-right':
				define('WPV_LAYOUT', 'two-sidebars');
			break;
			case 'full':
				define('WPV_LAYOUT', 'no-sidebars');
			break;
		}

		return $layout_type;
	}

	return WPV_LAYOUT_TYPE;
}

/**
 * deals with the left sidebar
 */
function wpv_has_left_sidebar() {
	global $sidebars;
	$layout_type = wpv_get_layout();

	if($layout_type == 'left-only' || $layout_type == 'left-right'): ?>
		<aside class="<?php echo apply_filters('wpv_left_sidebar_class', 'left', $layout_type) ?>">
			<?php $sidebars->get_sidebar('left'); ?>
		</aside>
	<?php endif;
}

/**
 * deals with the right sidebar
 */
function wpv_has_right_sidebar() {
	global $sidebars;
	$layout_type = wpv_get_layout();

	if($layout_type == 'right-only' || $layout_type == 'left-right'): ?>
		<aside class="<?php echo apply_filters('wpv_right_sidebar_class', 'right', $layout_type) ?>">
			<?php $sidebars->get_sidebar('right'); ?>
		</aside>
	<?php endif;
}

/**
 * wrapper for wpv_hf_sidebars
 */
function wpv_header_sidebars() {
	wpv_hf_sidebars('header');
}

/**
 * wrapper for wpv_hf_sidebars
 */
function wpv_footer_sidebars() {
	wpv_hf_sidebars('footer');
}

/**
 * displays header/footer sidebars
 */
function wpv_hf_sidebars($area) {
	$is_active = false;
	$sidebar_count = (int)wpv_get_option("$area-sidebars");
	for($i=1; $i<=$sidebar_count; $i++) {
		$is_active = $is_active || is_active_sidebar("$area-sidebars-$i");
	}

	if($is_active):
?>

	<div id="<?php echo $area?>-sidebars" data-rows="<?php echo $sidebar_count ?>">
		<div class="row" data-num="0">
			<?php for($i=1; $i<=$sidebar_count; $i++): ?>
				<?php
					$active = is_active_sidebar("$area-sidebars-$i");
					$empty = wpv_get_option("$area-sidebars-$i-empty");
				?>
				<?php if($active || $empty) : ?>
					<?php
						$width = wpv_get_option("$area-sidebars-$i-width");
						$is_last = wpv_get_option("$area-sidebars-$i-last") || $width == 'full';
						$fit = ($width != 'full') ? 'fit' : '';
					?>
					<aside class="<?php echo $width?> <?php if($is_last) echo ' last' ?><?php if($empty) echo ' empty' ?> <?php echo $fit ?>"><div>
						<?php dynamic_sidebar("$area-sidebars-$i"); ?>
					</div></aside>
					<?php if($is_last && $i != $sidebar_count): ?>
						</div><div class="row" data-num="<?php echo $i ?>">
					<?php endif ?>
				<?php endif; ?>
			<?php endfor ?>
		</div>
	</div>

	<?php endif;
}

add_filter('get_previous_post_join', 'wpv_post_siblings_join', 10, 3);
add_filter('get_next_post_join', 'wpv_post_siblings_join', 10, 3);
function wpv_post_siblings_join($join, $in_same_cat, $excluded_categories) {
	global $post;

	if($post->post_type == 'portfolio') {
		$join = str_replace("'category'", "'portfolio_category'", $join);
		$cat_array = wp_get_object_terms($post->ID, 'portfolio_category', array('fields' => 'ids'));
		$cat_in = "tt.term_id IN (" . implode(',', $cat_array) . ")";
		$join = preg_replace('#tt\.term_id IN \([^)]*\)#', $cat_in, $join);
	}

	return $join;
}

add_filter('get_previous_post_where', 'wpv_post_siblings_where', 10, 3);
add_filter('get_next_post_where', 'wpv_post_siblings_where', 10, 3);
function wpv_post_siblings_where($where, $in_same_cat, $excluded_categories) {
	global $post;

	if($post->post_type == 'portfolio') {
		$where = str_replace("'category'", "'portfolio_category'", $where);
	}

	return $where;
}

/**
 * echoes the "load more" button
 */

function wpv_load_more($pagination_type = null) {
	if(is_null($pagination_type))
		$pagination_type = wpv_get_option('pagination-type');

	if($pagination_type == 'paged') {
		if(!function_exists('wp_pagenavi')) {
			trigger_error(__('WP-PageNavi must be activated if you want to use this pagination type!', 'wpv'), E_USER_WARNING);
			return;
		}

		wp_pagenavi();
	} elseif($pagination_type == 'basic') {
		paginate_links();
	} else {
		global $wp_query;

		$max = $wp_query->max_num_pages;
		$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

		$class = apply_filters('wpv_lmbtn_class', 'lm-btn');

		if((int)$max > (int)$paged) {
			$url = remove_query_arg(array('page', 'paged'));
			$url .= (strpos($url, '?') === false) ? '?' : '&';
			$url .= 'paged='.($paged+1);

			echo '<div class="load-more"><a href="'.$url.'" class="'.$class.'"><span>'.__('Load more', 'wpv').'</span></a></div>';
		}
	}
}

/**
 * some social buttons and feedback form/button
 */
function wpv_buttons() {
	if(!apply_filters('wpv_show_buttons', true)) return;

	?>
	<?php if(wpv_get_option('feedback-type') != 'none'): ?>
		<div id="feedback-wrapper">
			<?php if(wpv_get_option('feedback-type') == 'sidebar'): ?>
				<?php dynamic_sidebar('feedback-sidebar') ?>
				<a href="#" id="feedback" class="slideout icon" ><?php wpv_icon('pencil') ?></a>
			<?php else: ?>
				<a href="<?php wpvge('feedback-link')?>" id="feedback" class="icon"><?php wpv_icon('pencil') ?></a>
			<?php endif ?>
		</div>
	<?php endif ?>

	<?php if(wpv_get_option('show_scroll_to_top')): ?>
		<div id="scroll-to-top" class="icon"><?php wpv_icon('arrow-up') ?></div>
	<?php endif ?>

	<div class="icons-top">
	<?php if(wpv_get_option('show_rss_button')): ?>
		<a href="<?php bloginfo('rss2_url')?>" id="rss-top" class="icon"><?php wpv_icon('feed1') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('fb-link')): ?>
		<a href="<?php wpvge('fb-link')?>" id="ifb" target="_blank" class="icon"><?php wpv_icon('facebook') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('gplus-link')): ?>
		<a href="<?php wpvge('gplus-link')?>" id="igplus" target="_blank" class="icon"><?php wpv_icon('google plus') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('twitter-link')): ?>
		<a href="<?php wpvge('twitter-link')?>" id="itwitter" target="_blank" class="icon"><?php wpv_icon('twitter') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('youtube-link')): ?>
		<a href="<?php wpvge('youtube-link')?>" id="iyoutube" target="_blank" class="icon"><?php wpv_icon('youtube') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('flickr-link')): ?>
		<a href="<?php wpvge('flickr-link')?>" id="iflickr" target="_blank" class="icon"><?php wpv_icon('flickr') ?></a>
	<?php endif ?>

	<?php if(wpv_get_option('linkedin-link')): ?>
		<a href="<?php wpvge('linkedin-link')?>" id="ilinkedin" target="_blank" class="icon"><?php wpv_icon('linkedin') ?></a>
	<?php endif ?>

	</div><!-- / .icons-top -->

	<?php
}
add_action('wp_footer', 'wpv_buttons');

/*
 * adds share buttons depending on context
 */

if(!function_exists('wpv_share')):
function wpv_share($context) {
	global $post;

	ob_start();

	if(wpv_get_option("share-$context-twitter") || wpv_get_option("share-$context-facebook") ||
	   wpv_get_option("share-$context-gplus") || wpv_get_option("share-$context-pinterest")):
	?>
	<div class="clearfix <?php echo apply_filters('wpv_share_class', 'share-btns')?>">
		<?php if(wpv_get_option("share-$context-pinterest")): ?>
			<div class="fl">
				<a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
				<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
			</div>
		<?php endif	?>

		<?php if(wpv_get_option("share-$context-twitter")): ?>
			<div class="fl">
			    <iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html" style="width:auto; height:20px;"></iframe>
			</div>
		<?php endif; ?>

		<?php if(wpv_get_option("share-$context-facebook")): ?>
			<div class="fl">
				<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()) ?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
			</div>
		<?php endif	?>

		<?php if(wpv_get_option("share-$context-gplus")): ?>
			<div class="fl">
				<div class="g-plusone" data-size="medium" data-width="auto"></div>
				<script type="text/javascript">
				/*<![CDATA[*/
				  (function() {
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				/*]]>*/
				</script>
			</div>
		<?php endif	?>
	</div>
	<?php
	endif;

	echo apply_filters('wpv_share', ob_get_clean(), $context);
}
endif;

/*
 * post meta helper
 */

if(!function_exists('wpv_meta')):
function wpv_meta() {?>
	<?php if(wpv_get_optionb('meta_posted_in') || wpv_get_optionb('meta_posted_on') || wpv_get_optionb('meta_comment_count')): ?>
		<div class="entry-meta">
			<?php if(wpv_get_optionb('meta_posted_in')):?>
				<span class="posted-in"><?php wpv_posted_in() ?></span>
				<span class="meta-sep">|</span>
			<?php endif ?>
			<?php if(wpv_get_optionb('meta_posted_in')):?>
				<span class="posted-on"><?php wpv_posted_on() ?></span>
				<span class="meta-sep">|</span>
			<?php endif ?>
			<?php if(wpv_get_optionb('meta_comment_count')):?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wpv' ), __( '1 Comment', 'wpv' ), __( '% Comments', 'wpv' ) ); ?></span>
			<?php endif ?>
			<?php edit_post_link( __( 'Edit', 'wpv' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
		</div>
	<?php endif ?>
<?php
}
endif;

/*
 * comments callback
 */

if ( ! function_exists( 'wpv_comments' ) ) :
function wpv_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
        ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div class="comment-wrapper">
					<div class="comment-left">
						<?php echo get_avatar( $comment, 80 ); ?>
					</div>
					<div class="comment-right">
						<div class="comment-meta">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<?php comment_date()?>
							</a>
							<?php edit_comment_link( __( '(Edit)', 'wpv' ), ' ' );?>
						</div>
						<div class="comment-author vcard">
							<?php comment_author_link()?>
						</div><!-- .comment-author .vcard -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em><?php _e( 'Your comment is awaiting moderation.', 'wpv' ); ?></em>
							<br />
						<?php endif; ?>

						<div class="comment-body"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</div><!-- .comment-right -->
				</div><!-- .comment-wrapper -->

	<?php
		break;

		case 'pingback'  :
		case 'trackback' :
	?>
			<li class="post pingback">
				<p><?php _e( 'Pingback:', 'wpv' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'wpv'), ' ' ); ?></p>
        <?php
		break;
	endswitch;

}
endif;

/*
 * "posted on" meta
 */

if ( ! function_exists( 'wpv_posted_on' ) ) :
function wpv_posted_on() {
	printf( __( '%2$s <span class="meta-sep">|</span> by %3$s', 'wpv' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'wpv' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

/*
 * "posted in" meta
 */

if ( ! function_exists( 'wpv_posted_in' ) ) :
function wpv_posted_in() {
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list )
		$posted_in = __( 'Posted in %1$s <span class="meta-sep">|</span> tags %2$s', 'wpv' );
	elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) )
		$posted_in = __( 'Posted in %1$s', 'wpv' );

	printf($posted_in,
		get_the_category_list( ', ' ),
		$tag_list
	);
}
endif;

/**
 * displays blog post featured image/video/audio/gallery part
 */
function wpv_post_media() {
	global $post;

	extract(wpv_post_info());

	if(has_post_format('audio')):
		ob_start();
		wpv_post_audio();
		return array('has-audio', ob_get_clean());
	elseif(has_post_format('video')):
		ob_start();
		?><div class="post-video"><?php wpv_post_video(wpv_str_to_width($width)) ?></div><?php
		return array('has-video', ob_get_clean());
	else:
		if(has_post_format('image') || has_post_format('gallery')) {
			$show_image = true;
			$img_style = 'fullimage';
		}

		ob_start();
		if($show_image) {
			if(has_post_format('gallery')) {
				$has_image = 'fullimage';
				echo do_shortcode('[gallery style="1 featured" slider="true"]');
			} else {
				$has_image = wpv_post_image($img_style, $width);
			}
		} else {
			$has_image = 'no-image';
		}

		return array($has_image, ob_get_clean());
	endif;
}

/**
 * echos the html for the post's featured image
 *
 * @returns 'no-image' or $img_style
 */
function wpv_post_image($img_style, $width="full") {
	$has_image = 'no-image';

	$width = apply_filters('wpv_post_fullimage_width', wpv_str_to_width($width), $width);
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	if(isset($img[0])):
		$has_image = $img_style;
?>
		<div class="post-full-thumb">
			<?php if(!is_single()): ?>
				<a href="<?php the_permalink(); ?>">
			<?php else: ?>
				<span class="thumbnail">
			<?php endif ?>
					<?php wpv_lazy_load( wpv_resize_image($img[0], $width, wpv_featured_image_height()), get_the_title(), wpv_featured_image_atts($width))?>
			<?php if(!is_single()): ?>
				</a>
			<?php else: ?>
				</span>
			<?php endif ?>
		</div>
<?php
	endif;

	return $has_image;
}

/**
 * similar to wpv_post_image
 * used for "news" listings
 */
function wpv_news_image($column=1) {
	echo wpv_get_news_image($column);
}

function wpv_get_news_image($column=1) {
	ob_start();
	$width = round( (wpv_get_central_column_width() * (1-0.02 * ($column-1))) /$column);
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	if(isset($img[0])):
?>
		<a href="<?php the_permalink(); ?>">
			<?php wpv_lazy_load( wpv_resize_image($img[0], $width, wpv_featured_image_height()), get_the_title(), wpv_featured_image_atts($width))?>
		</a>
<?php
	endif;

	return ob_get_clean();
}

/**
 * echos the html for the page's featured image
 *
 * @returns 'no-image' or'fullimage'
 */
function wpv_page_image() {
	$has_image = 'no-image';

	$width = apply_filters('wpv_page_image_width', wpv_get_central_column_width());
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	if(isset($img[0])):
		$has_image = 'fullimage';
?>
		<div class="post-full-thumb">
			<span class="thumbnail">
				<?php wpv_lazy_load(wpv_resize_image($img[0], $width, wpv_get_option('fullimage-height')), get_the_title())?>
			</span>
		</div>
<?php
	endif;

	return $has_image;
}

function wpv_post_audio() {
	global $post;
?>
	<div class="post-audio">
		<?php
			global $wp_embed;
			echo do_shortcode( $wp_embed->run_shortcode('[embed]'.get_post_meta($post->ID, 'post-link', true).'[/embed]') );
		?>
	</div>
<?php
}

function wpv_title() {
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $post;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'wpv' ), max( $paged, $page ) );
}

function wpv_get_header_sidebars($title=null) {
	$result = false;
	global $wpv_has_header_sidebars;
	if( $wpv_has_header_sidebars) {?>
		<div class="pane">
			<div class="row">
			<?php
				$result = true;
				theme_page_header_inner($title);
				wpv_header_sidebars();
			?>
			</div>
		</div>
		<?php
	}

	return $result;
}

function wpv_page_header($page_header_placed, $title=null) {
	if (!$page_header_placed)
		theme_page_header_inner($title);
}

function wpv_title_style() {
	if(!current_theme_supports('wpv-page-title-style'))
		return;

	$bgcolor = wpv_post_default('local-title-background-color', 'title-background-color', false, true);
	$bgimage = wpv_post_default('local-title-background-image', 'title-background-image', false, true);
	$bgrepeat = wpv_post_default('local-title-background-repeat', 'title-background-repeat', false, true);
	$bgsize = wpv_post_default('local-title-background-size', 'title-background-size', false, true);
	$bgattachment = wpv_post_default('local-title-background-attachment', 'title-background-attachment', false, true);
	$bgposition = wpv_post_default('local-title-background-position', 'title-background-position', false, true);

	$style = '';
	if(!empty($bgcolor))
		$style .= "background-color:$bgcolor;";
	if(!empty($bgimage)) {
		$style .= "background-image:url('$bgimage');";
		if(!empty($bgrepeat))
			$style .= "background-repeat:$bgrepeat;";
		if(!empty($bgsize))
			$style .= "background-size:$bgsize;";
	}

	echo $style;
}

function wpv_title_description_style() {
	if(!current_theme_supports('wpv-page-title-style'))
		return;

	$color = wpv_get_option('h1-color');

	$style = "color:$color;";

	echo $style;
}

function wpv_description($id, $desc) {
	if(!empty($desc)): ?>
		<div class="row-desc">
			<a href="#" class="va-icon va-icon-info desc-handle"></a>
			<div>
				<section class="content"><?php echo $desc ?></section>
				<footer><a href="<?php echo esc_attr( 'http://support.vamtam.com' ) ?>" title="<?php esc_attr_e( 'Read more on our Help Desk', 'wpv' ) ?>"><?php _e( 'Read more on our Help Desk', 'wpv' ) ?></a></footer>
			</div>
		</div>
	<?php endif;
}

function wpv_background_portfolio_template() {
	$data = wpv_get_fancy_portfolio_items();
	?>
	<script>wpvBgSlides = <?php echo json_encode($data)?>;</script>
	<h3 class="fast-slider-caption"></h3>
	<div class="fast-slider-navbar">
		<div class="fast-slider-next icon theme"><b><?php wpv_icon('theme-angle-right')?></b></div>
		<?php
			$view_all = wpv_get_option('portfolio-all-items');
			if(!empty($view_all)):
		?>
			<a href="<?php echo $view_all?>" class="fast-slider-view-all icon theme"><b><?php wpv_icon('theme-x')?></b></a>
		<?php endif ?>
		<div class="fast-slider-prev icon theme"><b><?php wpv_icon('theme-angle-left')?></b></div>
		<div class="fast-slider-gall-prev icon theme"><b><?php wpv_icon('theme-angle-top')?></b></div>
		<div class="fast-slider-gall-next icon theme"><b><?php wpv_icon('theme-angle-bottom')?></b></div>
	</div>
	<?php
}

function wpv_background_portfolio() {
	global $post;

	$fancy_portfolio_cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
	$fancy_portfolio_type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';

	if(!empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'background') {
		wp_enqueue_script('front-wpvbgslider');
		add_action('wp_footer', 'wpv_background_portfolio_template');
		define('WPV_NO_PAGE_CONTENT', true);
		get_footer();
		exit;
	}
}
add_action('wpv_header_box', 'wpv_background_portfolio');

function wpv_footer_map_template() {
	if (wpv_get_option('enable-fmap')): $FMAP_ID = uniqid(); ?>
		<div class="footer-map">
			<a class="show-map-button" data-opentext="<?php _e('View Map', 'wpv')?>" data-closetext="<?php _e('Close', 'wpv')?>" href="#"><?php _e('View Map', 'wpv')?></a>
		</div>
		<script type="text/javascript">
		/*<![CDATA[*/
		(function($) {

			function floatVal( x, defaultValue ) {
				var out = parseFloat(x);
				if ( isNaN(out) || !isFinite(out) )
					out = defaultValue === undefined ? 0 : floatVal( defaultValue );
				return out;
			}

			var ID          = '<?php echo $FMAP_ID; ?>';
			var address     = <?php echo json_encode(wpv_get_option('fmap-address')); ?>;
			var latitude    = floatVal('<?php wpvge('fmap-latitude'); ?>');
			var longitude   = floatVal('<?php wpvge('fmap-longitude'); ?>');
			var zoom        = floatVal('<?php wpvge('fmap-zoom'); ?>', 14);
			var marker      = !!'<?php wpvge('fmap-marker'); ?>';
			var html        = <?php echo json_encode(wpv_get_option('fmap-html')); ?>;
			var popup       = !!'<?php wpvge('fmap-popup'); ?>';
			var controls    = '<?php wpvge('fmap-controls'); ?>';
			var scrollwheel = !!'<?php wpvge('fmap-scrollwheel'); ?>';
			var maptype     = '<?php wpvge('fmap-maptype'); ?>' || "ROADMAP";
			var invert_lightness = !!'<?php wpvge('fmap-invert-lightness'); ?>';
			var color       = '<?php echo wpv_sanitize_accent(wpv_get_option('fmap-color')); ?>';

			function createMap() {

				var cfg = { zoom : zoom };

				if (marker) {
					cfg.markers = [{
						address  : address,
						latitude : latitude,
						longitude: longitude,
						html     : html,
						popup    : popup
					}];
				} else {
					cfg.latitude  = latitude;
					cfg.longitude = longitude;
					cfg.address   = address;
				}

				cfg.maptype     = maptype;
				cfg.controls    = controls || [];
				cfg.scrollwheel = scrollwheel;
				cfg.custom = {
					styles: [
						{
							stylers: [
								{ inverse_lightness: invert_lightness },
								{ hue : color }
							]
						}
					]
				}

				return $('<div id="google_map_' + ID + '" class="map"/>').appendTo(".footer-map").gMap(cfg);


			}

			$(".show-map-button").click(function(e) {
				e.preventDefault();

				if ($("body").is(".footer-map-expanded")) {
					$(this).text($(this).data("opentext"));
					$("body").removeClass("footer-map-expanded");
				} else {
					var map = $("#google_map_" + ID);
					if (!map.length) {
						map = createMap();
					}
					$("body").addClass("footer-map-expanded");
					$(this).text($(this).data("closetext"));
					setTimeout(function() {
						map[0].scrollIntoView();
					}, 400);
				}
			});
		})(jQuery);
		/*]]>*/
		</script>
	<?php endif;
}
add_action('wpv_before_sub_footer', 'wpv_footer_map_template');

function wpv_responsive_select_enhancements() {
	if(class_exists('ResponsiveMenuSelect')): ?>
	<style>
		<?php $responsiveMenuSelect = new ResponsiveMenuSelect(); ?>
		@media (max-width: <?php echo $responsiveMenuSelect->getSettings()->op( 'max-menu-width' ); ?>px) {
			.fixed-header-box {
				padding: 0;
			}

			header.main-header .header-left,
			header.main-header .header-center {
				display: block;
				text-align: center;
				padding: 0;
			}

			header.main-header .logo {
				display: inline-block;
				padding: 30px 0;
			}

			#menus {
				float: none;
				display: inline-block;
			}

			header.main-header .header-right {
				display: none;
			}

			#top-nav {
				float: none;
				text-align: center;
				border-bottom: 1px solid <?php wpvge('accent-color-8') ?>;
			}

			#top-nav > div {
				display: inline-block;
			}
		}
	</style>
	<?php endif;
}
add_action('wp_footer', 'wpv_responsive_select_enhancements');