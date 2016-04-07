<?php
/**
 * @package WordPress
 * @subpackage makalu
 */

wp_reset_postdata();

?>

<?php if ( 'open' == $post->comment_status ) : ?>

	<div id="comments">
		<?php
			$req = get_option('require_name_email'); // Checks if fields are required.
			if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) ) {
				die ( 'Please do not load this page directly. Thanks!' );
			}
			
			if ( ! empty($post->post_password) ):
				if ( post_password_required() ) :
		?>
					</div><!-- #comments -->
	
	<?php
					return;
				endif;
			endif;
	?>

	<?php if ( have_comments() ) : ?>
		<?php // numbers of pings and comments 
		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment )
			get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
		?>
		
		<?php if ( $comment_count ) : ?>
			<div id="comments-list" class="comments">
				<?php /* <h3><?php printf($comment_count > 1 ? '<span>%d</span> Comments' : '<span>One</span> Comment', $comment_count) ?></h3> */ ?>
				<ol>
					<?php wp_list_comments('type=comment&callback=theme_comments'); ?>
				</ol>
			</div><!-- #comments-list .comments -->
		<?php endif; /* if ( $comment_count ) */ ?>
		
		<?php if ( $ping_count ) : ?>
			<div id="trackbacks-list" class="comments">
				<h3><?php printf($ping_count > 1 ? '<span>%d</span> Trackbacks' : '<span>One</span> Trackback', $ping_count) ?></h3>
				<ol>
					<?php wp_list_comments('type=pings&callback=theme_comments'); ?>
				</ol>				
			</div><!-- #trackbacks-list .comments -->
		<?php endif /* if ( $ping_count ) */ ?>
	<?php endif /* if ( $comments ) */ ?>

	<?php
		$comment_pages = paginate_comments_links(array(
			'echo' => false
		));

		if(!empty($comment_pages)):
	?>
		<div class="wp-pagenavi comment-paging"><?php echo $comment_pages ?></div>
	<?php endif ?>

	<div class="respond-box">
		<div class="respond-box-title sep-text">
			<div class="sep-text-before"></div>
			<h4 class="content"><?php _e('Write a comment:', 'wpv')?></h4>
			<div class="sep-text-after"></div>
		</div>
  				
		<?php // cancel_comment_reply_link() ?>

		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'shape'), get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>
		<?php else : ?>
			<?php 
				comment_form(array(
					'title_reply' => '',
					'title_reply_to' => '',
					'title_reply_to' => '',
					'logged_in_as' => '<p class="logged-in-as grid-1-2">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), wp_get_current_user()->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
					'fields' => array(
							'author' => '<div class="input-text-holder grid-1-2"><div class="comment-form-author form-input">' . '<label for="author">' . __('Name', 'wpv') . '</label>' . ( $req ? ' <span class="required">*</span>' : '' ) . 
				            			'<input id="author" name="author" type="text" required="required" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.__('Name', 'wpv').' *" /></div>',
							'email'  => '<div class="comment-form-email form-input"><label for="email">' . __('Email', 'wpv') . '</label> ' . ( $req ? ' <span class="required">*</span>' : '' ) .
				            			'<input id="email" name="email" type="email" required="required" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="'.__('Email', 'wpv').' *" /></div>',
							'url'    => '<div class="comment-form-url form-input"><label for="url">' . __('Website', 'wpv') . '</label>' .
				            			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="'.__('Website', 'wpv').'" /></div>	<p class="comment-notes">' . __( 'Your email address will not be published.', 'wpv') . '</p></div>',
					),
					'comment_field' => '<div class="comment-form-comment grid-1-2 last"><label for="comment">' . _x( 'Comment', 'noun', 'wpv' ) . '</label><textarea id="comment" name="comment" required="required" aria-required="true" placeholder="'._x('Comment', 'noun', 'wpv').'"></textarea></div>',
					'comment_notes_before' => '',
					'comment_notes_after' => '',
				)); 
			?>
			
		<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>
	</div><!-- .respond-box -->
</div><!-- #comments -->

<?php endif /* if ( 'open' == $post->comment_status ) */ ?>
