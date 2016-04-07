<?php

class WPV_Text_Divider {
	public function __construct() {
		add_shortcode('text_divider',array(&$this, 'text_divider'));
	}

	public function text_divider($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'more' => '',
			'type' => 'single'
		), $atts));

		$content = preg_replace('#<\s*/?\s*p[^>]*>#', '', $content);

		$has_html = preg_match('/^\s*</', $content);

		$link = '';
		$class = 'single';
		if(!empty($more)) {
			$class = 'has-more';
			$link = "<span class='fr content'><a href='$more' title='".__('Read more', 'wpv')."' class='more'>".__('More', 'wpv').'</a></span>';
		}

		ob_start();

		if($type == 'single'):
	?>
		<div class="sep-text <?php echo $class?>">
			<div class="content">
				<?php if(!$has_html) echo '<h3>'; ?>
					<?php echo do_shortcode($content) ?>
				<?php if(!$has_html) echo '</h3>'; ?>
			</div>
			<span class="sep-text-after"></span>
			<?php echo $link ?>
		</div>
	<?php elseif($type == 'double'): ?>
		<?php if(!$has_html) echo '<h3>'; ?>
			<?php echo do_shortcode($content) ?>
		<?php if(!$has_html) echo '</h3>'; ?>
		<?php echo do_shortcode('[divider type="1"]') ?>
	<?php
		endif;
		return apply_filters('wpv_shortcode_text_divider_html', ob_get_clean(), $content, $atts);
	}
}

new WPV_Text_Divider;
