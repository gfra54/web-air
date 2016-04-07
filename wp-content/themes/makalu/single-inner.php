<?php
	extract(wpv_post_info());
	$format = get_post_format();
    $format = empty($format)? 'standard' : $format;

	if(defined('WPV_ARCHIVE_TEMPLATE'))
		$show_content = false;

	list($has_media, $the_media) = wpv_post_media();
	$the_media = trim($the_media);

	// comment-count -----------------------------------------------------------
	$comment_count = '';
	if(wpv_get_optionb('meta_comment_count')):
		ob_start();
		?><div class="comment-count">
			<span class="icon theme"><?php wpv_icon('comments')?></span><?php comments_popup_link(__('0 <span class="comment-word">Comments</span>', 'wpv'), __('1 <span class="comment-word">Comment</span>', 'wpv'), __('% <span class="comment-word">Comments</span>', 'wpv')); ?>
		</div><?php
		$comment_count = ob_get_clean();
	endif;

	// post-meta ---------------------------------------------------------------
	ob_start();
	?>
	<div class="post-meta">

		<?php
		// Comment count
		echo $comment_count;


		// Author
		if(!wpv_get_optionb('hide-post-author')): ?>
			<div class="author"><span class="icon theme"><?php wpv_icon('ink-tool');?></span><?php the_author_posts_link()?></div>
		<?php endif ?>

		<?php

		if(wpv_get_optionb('meta_posted_in')):
			// Category
			?>
			<div><span class="icon"><?php wpv_icon('folder1'); ?></span><span class="visuallyhidden"><?php _e('Category', 'wpv') ?></span><?php the_category(', '); ?></div>
			<?php
			// Tags
			the_tags('<div class="the-tags"><span class="icon theme">' . wpv_get_icon('theme-bookmark') . '</span><span class="visuallyhidden">'.__('Category', 'wpv').'</span>', ', ', '</div>')?>
		<?php endif ?>

		<?php
		// Buttons
		if (!is_single()): ?>
			<div class="blog-buttons">
				<?php if($show_content != 'false'): ?>
					<a class="blog-read-more" href="<?php the_permalink() ?>"><span class="icon theme"><?php wpv_icon('read-more'); ?></span><span><?php _e('Read More', 'wpv') ?></span></a>
				<?php endif ?>
				<?php edit_post_link('<span class="icon">' . wpv_get_icon('pencil') . '</span><span>'. __('Edit', 'wpv') .'</span>') ?>
			</div>
		<?php endif ?>

	</div>
	<?php
	$post_meta = ob_get_clean();

	// post-date ---------------------------------------------------------------
	ob_start();
	?>
	<div class="post-subheader">
		<?php if(wpv_get_optionb('meta_posted_on')): ?>
			<h6 class="post-date"><?php the_time(get_option('date_format')) ?></h6>
			<div class="post-date-after"></div>
		<?php endif ?>
		<?php if($news == 'true') echo $comment_count; ?>
	</div>
	<?php
	$post_date = ob_get_clean();


	// post-format icon --------------------------------------------------------
	ob_start();
	?>
	<a class="single-post-format" href="<?php echo add_query_arg( 'format_filter',$format, home_url()) ?>" title="<?php echo get_post_format_string($format) ?>">
		<?php echo do_shortcode('[icon name="'.theme_get_post_format_icon($format).'"]') ?>
	</a>
	<?php
	$post_format_icon = ob_get_clean();



	// post-content ------------------------------------------------------------
	ob_start();
	$format = get_post_format();
	$format = empty($format)? 'standard' : $format;
	$content = get_the_content();
	?>
	<div class="post-content the-content">
		<?php if(is_single() && !wpv_get_optionb('hide-post-author')): ?>
			<p class="author"><span class="icon theme"><?php wpv_icon('ink-tool');?></span> <span class="visuallyhidden"><?php _e('By', 'wpv') ?></span> <?php the_author_posts_link()?></p>
		<?php endif ?>
		<?php if(!empty($content)):?>
			<!-- QUOTE -->
			<?php if(has_post_format('quote')): ?>
				<blockquote>
					<div>
						<?php the_content() ?>
						<div class="cite">
							<?php
								$post_link = get_post_meta(get_the_id(), 'post-link', true);
								$quote_author = get_post_meta(get_the_id(), 'quote-author', true);
							?>
							<a href="<?php echo $post_link?>" title="<?php echo $quote_author?>"><?php echo $quote_author?></a>
						</div>
					</div>
				</blockquote>

			<!-- CONTENT (NOT QUOTE) -->
			<?php else:
				if(is_single()) {
					the_content();
					wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpv' ), 'after' => '</div>' ) );
				} else {
					if($show_content == 'true') {
						global $more;
						$more = 0;
						the_content(__("Read More", 'wpv'), false);
					} else {
						the_excerpt();
					}
				}
			endif ?>

		<?php endif ?>

		<!-- POST FORMAT ICON -->
		<?php if (!empty($the_media)) {
			echo $post_meta;
		}
		else {
			echo $post_format_icon;
		}
		?>
	</div>
	<?php
	$post_content = ob_get_clean();


	if (!empty($the_media))
		$the_media = "<div class=\"media-inner\">$the_media $post_format_icon</div>";

// Output ----------------------------------------------------------------------
?>
<div class="post-article <?php echo $has_media?>-wrapper <?php echo (is_single()?'single':'list-item')?>">
	<div class="<?php echo $format?>-post-format clearfix">
	<?php
	// Single post -------------------------------------------------------------
	if (is_single()):

		// TITLE
		theme_post_header($news);

		// DATE
		echo $post_date;

		?><div class="post-content-outer <?php echo $has_media ?>"><?php
			if (!empty($the_media)):?>
				<div class="post-media">

					<!-- MEDIA -->
					<?php echo $the_media; ?>


				</div>
			<?php endif;

			echo $post_content;

		?></div><?php

	// Post in loop ------------------------------------------------------------
	else:
		$news_image = wpv_get_news_image($column);
		if($news =='true' && !empty($news_image)): ?>
			<div class="thumbnail">
				<?php echo $news_image ?>
				<?php echo $post_format_icon; ?>
			</div>
		<?php endif;

		// TITLE
		theme_post_header($news);

		// DATE
		echo $post_date;

		?><div class="post-content-outer <?php echo $has_media ?>"><?php
		if(!wpv_sanitize_bool($news)):

			if (!empty($the_media)):?>
				<div class="post-media">

					<!-- MEDIA -->
					<?php echo $the_media; ?>


				</div>
			<?php endif;

			if (empty($the_media)) {
				echo "<div class=\"left-content\">$post_content</div>";
				echo $post_meta;
			} else {
				echo $post_content;
			}

		elseif(wpv_sanitize_bool($show_content)):
			echo the_excerpt();
?>
			<a href="<?php the_permalink()?>" class="read-more-button excerpt-more icon-a theme" data-icon="<?php wpv_icon('theme-angle-right')?>"><?php _e('Read more', 'wpv') ?></a>
<?php
		endif; // no news
		?></div><?php
	endif ?>
	</div>
</div>
