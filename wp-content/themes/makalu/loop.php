<?php

// display full post/image or thumbs
if(!isset($called_from_shortcode)) {
	$image = 'true';
	$show_content = 'true';
	$nopaging = 'false';
	$img_style = 'full';
	$width = 'full';
	$news = 'false';
	$column = 1;
}

$img_style = $img_style.'image';

global $wpv_loop_vars;
$old_wpv_loop_vars = $wpv_loop_vars;
$wpv_loop_vars = array(
	'image' => $image,
	'show_content' => $show_content,
	'img_style' => $img_style,
	'width' => $width,
	'news' => $news,
	'column' => $column,
);

?>
<div class="loop-wrapper clearfix <?php if(wpv_sanitize_bool($news)) echo 'news'?> force-full-width">
<?php
$useColumns = $column > 1;
$i = 0;
global $wp_query;
if(have_posts()) while(have_posts()): the_post();
	$last_in_row = (($i+1)%$column == 0 ||  $wp_query->post_count == $wp_query->current_post + 1);
?>
	<?php if($news === 'true' && $i%$column == 0): ?>
		<div class="row">
	<?php endif ?>
	<div class="page-content post-head<?php echo $useColumns ? '' : ' clearfix'?> <?php echo get_post_type()?> grid-1-<?php echo $column?> <?php if($last_in_row) echo 'last' ?>">
		<div>
			<?php get_template_part('single', 'inner');	?>
		</div>
	</div>
	<?php if($news === 'true' && $last_in_row): ?>
		</div>
	<?php endif?>
<?php
	$i++;
endwhile;
?>
</div>

<?php $wpv_loop_vars = $old_wpv_loop_vars; ?>
<?php if($nopaging != 'true' && function_exists('wpv_load_more') && $news!='true') wpv_load_more() ?>
