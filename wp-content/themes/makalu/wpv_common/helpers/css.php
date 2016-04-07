<?php

/**
 * echo the font family based on option id
 */

function wpv_font_family($opt_id) {
	echo wpv_get_font_family($opt_id);
}

/**
 * return the font family based on option id
 */

function wpv_get_font_family($opt_id) {
	global $wpv_fonts;

	$font = wpv_get_option($opt_id . '-face');

	return $wpv_fonts[$font]['family'];
}

// marks a font as "used"
function wpv_use_font($opt_id) {
	global $wpv_fonts, $used_google_fonts, $used_local_fonts;

	// we need the google and local fonts cached, so we can generate the correct @import rules

	$font = wpv_get_option($opt_id . '-face');

	if(isset($wpv_fonts[$font]['gf'])) {
		$used_google_fonts[$font][] = wpv_get_option($opt_id . '-weight');
	} elseif(isset($wpv_fonts[$font]['local'])) {
		$used_local_fonts[]= $wpv_fonts[$font]['family'];
	}
}

/**
 * return the font family based on option id
 */

function wpv_get_font_url($font, $weight='') {
	global $wpv_fonts;

	if(isset($wpv_fonts[$font]['gf'])) {
		// this is a google font
		return "//fonts.googleapis.com/css?family=".urlencode($font).':'.$weight."&subset=".wpv_get_option('google-fonts-subsets');
	} elseif(isset($wpv_fonts[$font]['local'])) {
		// this is a local @font-face font

		return WPV_FONTS_URI."$font/stylesheet.css";
	}

	return '';
}

function wpv_finalize_custom_css() {
	global $used_google_fonts, $used_local_fonts, $mocked;

	$font_imports = '';
	$font_imports_urls = array();

	$pages = array('general', 'layout', 'styles', 'sliders', 'import');
	foreach($pages as $page_str) {
		$tabs = include WPV_THEME_OPTIONS . $page_str . '/list.php';

		foreach($tabs as $tab) {
			$tab_contents = include WPV_THEME_OPTIONS.$page_str."/$tab.php";
			foreach($tab_contents as $opt) {
				if(isset($opt['type']) && $opt['type'] == 'font') {
					wpv_use_font($opt['id']);
				}
			}
		}
	}

	if(is_array($used_google_fonts) && count($used_google_fonts)) {
		$param = array();
		foreach($used_google_fonts as $font => $weights) {
			$param[] = urlencode($font).':'.implode(',', array_unique($weights));
		}
		$param = implode('|', $param);

		$font_imports .= "@import url('//fonts.googleapis.com/css?family=".$param."&subset=".wpv_get_option('google-fonts-subsets')."');\n";
		$font_imports_urls['gfonts'] = "//fonts.googleapis.com/css?family=".$param."&subset=".wpv_get_option('google-fonts-subsets');
	}

	if(is_array($used_local_fonts) && count($used_local_fonts)) {
		foreach($used_local_fonts as $font) {
			$font_imports .= "@import url('".WPV_FONTS_URI."$font/stylesheet.css');\n";
			$font_imports_urls[$font] = WPV_FONTS_URI."$font/stylesheet.css";
		}
	}

	if(!isset($mocked)) {
		wpv_update_option('external-fonts', $font_imports_urls);

		wpvge('custom_css');

		return ob_get_clean();
	} else {
		return array(
			'styles' => ob_get_clean(),
			'imports' => $font_imports,
		);
	}
}

function wpv_hex2rgba($color, $opacity) {
	return wpv_hex2rgba_plain(wpv_get_option($color), wpv_get_option($opacity));
}

function wpv_hex2rgba_plain($color, $opacity) {
	$result = '';
	if(!empty($color) && $color[0] === '#') {
		$result .= 'rgba(';
		$result .= (string)hexdec($color[1].$color[2]) . ', ';
		$result .= (string)hexdec($color[3].$color[4]) . ', ';
		$result .= (string)hexdec($color[5].$color[6]) . ', ';
		$result .= round($opacity,2) . ')';

		return $result;
	}

	return '';
}

function wpv_grad_filter($color, $opacity = 1) {
	if($color[0] != '#') {
		return '#00000000';
	}

	$color = substr($color, 1);

	$result = '#';
	$opacity = dechex(floor($opacity*255));
	if(strlen($opacity) == 1) {
		$opacity .= $opacity;
	}
	$result .= $opacity;

	if(strlen($color) == 3) {
		$color .= $color;
	}

	$result .= $color;

	return $result;
}

function wpv_font($opt, $important=false) {
?>
	font: <?php wpvge($opt.'-weight')?> <?php wpvge($opt.'-size')?>px / <?php wpvge($opt.'-lheight')?>px <?php wpv_font_family($opt);?><?php echo $important ? ' !important' : ''?>;
<?php
}

function wpv_background($opt, $important=false, $skipColor = false) {
	$color   = trim(wpv_get_option("$opt-color"));
	$opacity = wpv_get_option("$opt-opacity");
	$hasColor = (!empty($color) && $color != 'transparent' && ($opacity != 0 || $opacity === false));
	if (!$hasColor && wpv_get_option("$opt-image") == '') {
		echo 'background: transparent' .($important?' !important':'') . ";\n";
		return;
	}

	$img = wpv_get_option("$opt-image");
	$bg[] = $color;
	$size = '';
	if(!empty($img)) {
		$size = wpv_get_option("$opt-size");
		$size = empty($size) ? '' :
				('background-size:'.$size.($important ? '!important' : '').';');

		$bg[] = "url('$img')";
		$bg[] = wpv_get_option("$opt-position");
		$bg[] = wpv_get_option("$opt-repeat");
		$bg[] = wpv_get_option("$opt-attachment");
	}
	if ($important) {
		$bg[] = '!important';
	}
	echo 'background: ' . implode(' ', $bg) . ";\n";
	echo $size;

	if(!$skipColor && $hasColor && $opacity != 0) {
		echo "\tbackground-color: " . wpv_hex2rgba("$opt-color", "$opt-opacity").($important?' !important':'') . ";\n";
	}
}

function wpv_background_ie8($opt, $important=false) {
	$color = wpv_get_option("$opt-color");
	$img   = wpv_get_option("$opt-image");

	if(!empty($color) && !empty($img)) {
		wpv_background($opt, $important, true);
		?>
	background-color: <?php wpvge("$opt-color")?>;
	<?php
		return;
	}

	if(empty($color))
		return;

	$opacity = wpv_get_option("$opt-opacity");

	if ( !empty($color) && wpv_is_hex($color) && !empty($opacity) ):
		$alpha = dechex((float)$opacity * 255);
	?>
		zoom: 1;
		background: none !important;
		-ms-filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr=#<?php echo $alpha . str_replace('#', '', $color)?>, endColorstr=#<?php echo $alpha . str_replace('#', '', $color) ?>)";
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#<?php echo $alpha . str_replace('#', '', $color)?>, endColorstr=#<?php echo $alpha . str_replace('#', '', $color) ?>);
	<?php endif;
}

function wpv_is_hex($hex) {
	return preg_match('/^#?([a-f0-9]{3}){1,2}$/i', $hex);
}

function wpv_sanitize_accent($color) {
	if(preg_match('/accent(?:-color-)?(\d)/i', $color, $matches)) {
		$num = (int)$matches[1];
		$color = wpv_get_option("accent-color-$num");
	}

	return $color;
}