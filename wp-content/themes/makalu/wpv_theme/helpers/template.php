<?php

function theme_post_header($news='false') {
	global $post;

	$tag = 'h3';
	if($news == 'true') {
		$tag = 'h3';
	}

	$show = !has_post_format('aside') && !has_post_format('quote');
	$has_date = $news == 'true';
	
	if($show || ($has_date && $news != 'true')):
		$link = has_post_format('link') ? 
					get_post_meta($post->ID, 'post-link', true) :
					get_permalink();
		?>
			<header class="sep-text single">
				<div class="content">
				<?php if($has_date): ?>
					<span class="entry-date">
						<span class="entry-month"><?php the_time('M')?></span>
						<span class="entry-day"><?php the_time('d')?></span>
					</span>
				<?php endif ?>
				<?php if($show): ?>
					<<?php echo $tag?>>
						<a href="<?php echo $link ?>" title="<?php the_title()?>"><?php the_title(); ?></a>
					</<?php echo $tag?>>
				<?php endif ?>
				</div>
				<span class="sep-text-after"></span>
			</header>
		<?php
	endif;
}

// Custom callback to list comments
function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class($args['has_children'] ? 'has-children' : '') ?>>
		<div class="comment-author">
			<?php echo get_avatar( get_comment_author_email(), 73 ); ?>
		</div>
		<div class="comment-content">
			<div class="comment-meta">
				<h5 class="comment-author-link"><?php comment_author_link(); ?></h5>
				<h6 title="<?php comment_time(); ?>" class="comment-time"><?php comment_date(); ?></h6>
				<?php edit_comment_link(sprintf('[%s]', __('Edit', 'wpv'))) ?>
				<?php
					if($args['type'] == 'all' || get_comment_type() == 'comment') :
						comment_reply_link(array_merge($args, array(
						'reply_text' => __('Reply','shape'), 
						'login_text' => __('Log in to reply.','shape'),
						'depth' => $depth,
						'before' => '<h6 class="comment-reply-link">', 
						'after' => '</h6>'
						)));
					endif;
				?>
			</div>
			<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'shape') ?>
			<?php comment_text() ?>
		</div>
		<div class="clearfix"></div>
	<?php
}

function theme_breadcrumbs() {
	if(wpv_get_optionb('enable-breadcrumbs') && !is_front_page()): ?>
		<h6 id="header-breadcrumbs">
			<?php dimox_breadcrumbs('/') ?>
		</h6>
	<?php endif;
}

/**
 * echoes prev/next links
 */
function theme_post_siblings_links() {
	global $post;

	$same_cat = count(wp_get_object_terms($post->ID, 'category', array('fields' => 'ids'))) > 0;
	if($post->post_type == 'portfolio')
		$same_cat = false;

	$view_all = wpv_get_option($post->post_type.'-all-items');

	echo '<span class="post-siblings">';
	
	previous_post_link('%link', '<span class="icon theme">'.wpv_get_icon('theme-angle-left').'</span>', $same_cat);

	if(!empty($view_all))
		echo '<a href="'.$view_all.'" class="all-items">'.do_shortcode('[icon name="theme-x"]').'</a>';

	next_post_link('%link', '<span class="icon theme">'.wpv_get_icon('theme-angle-right').'</span>', $same_cat);

	echo '</span>';
}

function theme_page_header_inner($title) {
	global $post;

	if(is_null($title))
		$title = get_the_title();

	$needHeaderTitle = !!wpv_post_default('show_page_header', 'has-page-header');
	$needButtons = is_singular(array('post','portfolio')) && current_theme_supports('wpv-ajax-siblings');
	$description = is_object($post) ? get_post_meta($post->ID, 'description', true) : '';

	if ($needHeaderTitle || $needButtons):
		?><header class="page-header <?php echo $needButtons ? 'has-buttons':'' ?>">
			<div class="limit-wrapper">
				<div class="page-header-content">
					<h1>
					<?php if($needHeaderTitle): ?>
						<span class="title"><?php echo $title;?></span>
						<?php if(!empty($description)): ?>
							<span class="desc" style="<?php wpv_title_description_style() ?>"><?php echo $description ?></span>
						<?php endif ?>
					<?php endif ?>
					</h1>
					<span class="spacer"></span>
					<?php if($needButtons) theme_post_siblings_links() ?>
				</div>
			</div>
			<style>
				header.page-header,
				body.wide.has-page-header .page-header:before,
				body.wide.has-page-header .page-header:after {
					<?php wpv_title_style()?>
				}
			</style>
		</header><?php
	endif;
}

function theme_header_share($context) {
	global $post;
	
	ob_start();
	
	if(wpv_get_option("share-$context-twitter") || wpv_get_option("share-$context-facebook") ||
	   wpv_get_option("share-$context-gplus") || wpv_get_option("share-$context-pinterest")):
	?>
	<span id="like-btns-template"><!--
		<div class="clearfix <?php echo apply_filters('theme_header_share_class', 'share-btns')?>">
			<?php if(wpv_get_option("share-$context-pinterest")): ?>
				<div class="clearfix">
					<span class="icon"><?php wpv_icon('pinterest1') ?></span>
					<div class="content">
						<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()) ?>" class="pin-it-button" count-layout="none" target="_blank"><?php _e('Pinterest', 'wpv') ?></a>
					</div>
				</div>
			<?php endif	?>

			<?php if(wpv_get_option("share-$context-twitter")): ?>
				<div class="clearfix">
					<span class="icon"><?php wpv_icon('twitter1') ?></span>
					<div class="content">
						<a href="http://twitter.com/share?text=<?php echo urlencode(get_the_title()) ?>&amp;url=<?php echo urlencode(get_permalink()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><?php echo _e('Twitter', 'wpv') ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php if(wpv_get_option("share-$context-facebook")): ?>
				<div class="clearfix">
					<span class="icon"><?php wpv_icon('facebook1') ?></span>
					<div class="content">
						<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()) ?>&amp;t=<?php echo urlencode(get_the_title()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><?php echo _e('Facebook', 'wpv') ?></a>
					</div>
				</div>
			<?php endif	?>

			<?php if(wpv_get_option("share-$context-gplus")): ?>
				<div class="clearfix">
					<span class="icon"><?php wpv_icon('google plus2') ?></span>
					<div class="content">
						<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><?php _e('Google+', 'wpv') ?></a>
					</div>
				</div>
			<?php endif	?>
		</div>
	--></span>
	<?php
	endif;
	
	echo apply_filters('theme_header_share', ob_get_clean(), $context);
}

function theme_column_title($title, $type) {
	if($type === 'no-divider')
		return "<h3 class='column-title'>$title</h3>";

	return do_shortcode('[text_divider more="" type="'.$type.'"]'.$title.'[/text_divider]');
}
add_filter('wpv_column_title', 'theme_column_title', 10, 2);