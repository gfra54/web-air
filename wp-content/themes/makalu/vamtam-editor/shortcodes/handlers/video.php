<?php

/**
 * displays some video
 * 
 * we support youtube, vimeo and dailymotion
 * you can also use mp4, webm, ogg or swf files
 */

class WPV_Video {
	public function __construct() {
		add_shortcode('video', array(&$this, 'video'));
	}

	public function video($atts) {
		if(!isset($atts['type']) || empty($atts['type'])) {
			$link = $atts['src'];
			if(strpos($link, 'youtube') !== false || strpos($link, 'youtu.be') !== false) {
				$atts['type'] = 'youtube';
			} elseif(strpos($link, 'vimeo') !== false) {
				$atts['type'] = 'vimeo';
			} elseif(strpos($link, 'dailymotion') !== false) {
				$atts['type'] = 'dailymotion';
			} elseif(preg_match('/\.swf$/i', $link)) {
				$atts['type'] = 'flash';
			} elseif(preg_match('/\.(mp4|ogg|webm)$/i', $link)) {
				$atts['type'] = 'html5';
			} else {
				return '';
			}
		}
			
		$size = shortcode_atts(array(
			'width' => false,
			'height' => false
		), $atts);
		
		if($size['height'] && !$size['width']) 
			$size['width'] = intval($size['height'] * 16 / 9);
		if(!$size['height'] && $size['width']) 
			$size['height'] = intval($size['width'] * 9 / 16);
		
		return $this->$atts['type']($atts, $size); // use the correct parser for this type of video
	}
	
	private function html5($atts, $size){
		$atts = shortcode_atts(array(
			'mp4' => '',
			'webm' => '',
			'ogg' => '',
			'src' => '',
			'poster' => '',
			'preload' => false,
			'autoplay' => false,
		), $atts);
		extract($atts);
		extract($size);
		
		// if the correct file type is not specified - we will try to guess it
		if(preg_match('/\.mp4$/i', $src)) {
			$atts['mp4'] = $src;
		} elseif(preg_match('/\.webm$/i', $src)) {
			$atts['webm'] = $src;
		} elseif(preg_match('/\.og(g|v)/i', $src)) {
			$atts['ogg'] = $src;
		}
	
		$sources = array();
		$available_sources = array(
			'mp4',
			'webm',
			'ogg',
		);
		foreach($available_sources as $source) {
			$sources[$source.'_source'] = $atts[$source] ? '<source src="'.$atts[$source].'" type="video/'.$source.'">' : '';
			$sources[$source.'_link'] = $atts[$source] ? '<a href="'.$source.'">'.$source.'</a>' : '';
		}
		
		if($poster) {
			$poster_attribute = 'poster="'.$poster.'"';
			$image_fallback = wpv_get_lazy_load($poster, __('No video playback capabilities.', 'wpv'));
		}
	
		if($preload == "true") {
			$preload_attribute = 'preload="auto"';
			$flow_player_preload = ',"autoBuffering":true';
		} else {
			$preload_attribute = 'preload="none"';
			$flow_player_preload = ',"autoBuffering":false';
		}
	
		if($autoplay == "true") {
			$autoplay_attribute = "autoplay";
			$flow_player_autoplay = ',"autoPlay":true';
		} else {
			$autoplay_attribute = "";
			$flow_player_autoplay = ',"autoPlay":false';
		}
	
		$uri = WPV_URI;

		wp_enqueue_script('video-js');

		$output = <<<HTML
		<video id="my_video_1" class="video-js vjs-default-skin" {$poster_attribute} controls {$preload_attribute} width="{$width}" height="{$height}" {$autoplay_attribute} data-setup="{}">
  			{$sources['mp4_source']}
			{$sources['webm_source']}
			{$sources['ogg_source']}
		</video>
HTML;
	
		return $output;
	}

	private function flash($atts, $size) {
		extract(shortcode_atts(array(
			'src' 	=> '',
			'autoplay' => 'true',
			'flashvars' => '',
			'wrapper' => 'video_frame',
		), $atts));
		extract($size);
	
		$uri = WPV_ASSETS_URI;

		if(!empty($src))
			return <<<HTML
	<div class="{$wrapper} clearfix">
	<object width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="{$src}">
		<param name="movie" value="{$src}" />
		<param name="allowFullScreen" value="true" />
		<param name="allowscriptaccess" value="always" />
		<param name="expressInstaller" value="{$uri}swf/expressInstall.swf"/>
		<param name="play" value="{$autoplay}"/>
		<param name="wmode" value="transparent" />
		<embed src="$src" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" />
	</object>
	</div>
HTML;
	}

	private function vimeo($atts, $size) {
		extract(shortcode_atts(array(
			'clip_id' 	=> '',
			'src' => '',
			'wrapper' => 'video_frame',
			'autoplay' => 'false',
		), $atts));
		extract($size);
		
		// if a full url is provided, get the clip_id
		if(empty($clip_id)) {
			preg_match('%vimeo\.com/(?:.*#|.*videos?/)?([0-9]+)%', $src, $matches);
			
			if(isset($matches[1])) {
				$clip_id = $matches[1];
			}
		}

		if(!empty($clip_id) && is_numeric($clip_id)) {
			$id = uniqid('vimeo');
			$autoplay = $this->sanitize_bool($autoplay);

			wp_enqueue_script('froogaloop');

			return 
				"<div class='{$wrapper} clearfix'>
					<iframe src='http://player.vimeo.com/video/$clip_id?byline=0&amp;portrait=0&amp;api=1&amp;id=$id&amp;autoplay=$autoplay' width='$width' height='$height' frameborder='0' style='border:0' id='$id' class='vimeo'></iframe>
				</div>";
		}
	}
	
	private function youtube($atts, $size) {
		extract(shortcode_atts(array(
			'clip_id' 	=> '',
			'src' => '',
			'wrapper' => 'video_frame',
			'autoplay' => 'false',
		), $atts));
		extract($size);
		
		// if a full url is provided, get the clip_id
		if(empty($clip_id)) {
			preg_match('%youtu(?:\.be|be\.com)/(?:.*v(?:/|=)|(?:.*/)?)([a-zA-Z0-9-_]+)%', $src, $matches);
			
			if(isset($matches[1])) {
				$clip_id = $matches[1];
			}
		}

		if(!empty($clip_id)) {
			$origin = site_url();
			$id = uniqid('youtube');
			$autoplay = $this->sanitize_bool($autoplay);
			wp_enqueue_script('youtube-api');

			return 
				"<div class='{$wrapper} clearfix'>
					<iframe src='http://www.youtube.com/embed/{$clip_id}?wmode=transparent&amp;html5=1&amp;enablejsapi=1&amp;version=3&amp;playerapiid=$id&amp;origin=$origin&amp;autoplay=$autoplay' width='$width' height='$height' frameborder='0' style='border:0' id='$id' class='youtube'></iframe>
				</div>";
		}
	}
	
	private function dailymotion($atts, $size) {
		extract(shortcode_atts(array(
			'clip_id' => '',
			'src' => '',
			'wrapper' => 'video_frame',
			'autoplay' => 'false',
		), $atts));
		extract($size);
		
		// if a full url is provided, get the clip_id
		if(empty($clip_id)) {
			preg_match('%dailymotion\.com/video/([a-z\d]+)_%', $src, $matches);
			
			if(isset($matches[1])) {
				$clip_id = $matches[1];
			}
		}

		$autoplay = $this->sanitize_bool($autoplay);
	
		if(!empty($clip_id)) {
			return 
				"<div class='{$wrapper} clearfix'>
					<iframe src='http://www.dailymotion.com/embed/video/$clip_id?width=$width&amp;theme=none&amp;foreground=%23F7FFFD&amp;highlight=%23FFC300&amp;background=%23171D1B&amp;start=&amp;animatedTitle=&amp;iframe=1&amp;additionalInfos=0&amp;autoPlay=$autoplay&amp;hideInfos=0&amp;wmode=transparent' width='$width' height='$height' frameborder='0' style='border:0'></iframe>
				</div>";
		}
	}

	private function sanitize_bool($b) {
		return $b === 'true' || $b === true ? 1 : 0;
	}
}

new WPV_Video;