<?php

class WPV_Slider_Editor extends WPV_Ajax{
	public function __construct() {
		$this->actions = array(
			'get-attachments' => 'get_attachments',
			'slide-get-config' => 'get_slide_config',
			'slide-save-config' => 'save_slide_config',
			'create-slider' => 'create_slider',
			'get-slider-data' => 'get_slider_data',
			'get-sliders' => 'get_sliders',
			'get-slides' => 'get_slides',
			'create-slide' => 'create_slide',
			'slide-trash' => 'trash_slide',
			'slide-delete' => 'delete_slide',
			'slide-restore' => 'restore_slide',
			'slider-save-order' => 'slider_save_order',
			'slider-delete' => 'delete_slider',
		);

		$this->html_thumbnails = array(
			-1 => WPV_ADMIN_ASSETS_URI . 'images/html-slide.jpg',
			-2 => WPV_ADMIN_ASSETS_URI . 'images/apple-slide.jpg',
			-3 => WPV_ADMIN_ASSETS_URI . 'images/sintia-slide.jpg',
		);

		parent::__construct();
	}

	public function delete_slider() {
		$slider = (int)$_POST['id'];
		$slides = $this->get_slides_by_slider_id($slider);
		wp_delete_term($slider, 'slideshow_category');

		foreach($slides as $slide_id=>$data) {
			wp_delete_post($slide_id, true);
		}

		die(1);
	}

	// saves the order of some slides, the array should be in the form slide_id:menu_order
	public function slider_save_order() {
		foreach($_POST['order'] as $slide=>$menu_order) {
			wp_update_post(array(
				'ID' => $slide,
				'menu_order' => $menu_order,
			));
		}
		die('1');
	}

	// returns a json object of image attachments in the form "id":"thumbnail"
	public function get_attachments() {
		$attachments = get_posts(array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
		));

		$result = $this->html_thumbnails;

		if(!current_theme_supports('wpv-apple-slider'))
			unset($result[-2]);

		if(!current_theme_supports('wpv-sintia-slider'))
			unset($result[-3]);

		foreach($attachments as $a) {
			$result[$a->ID] = wp_get_attachment_image_src($a->ID, array(150,150));
			$result[$a->ID] = $result[$a->ID][0];
		}

		header('Content-type: application/json');
		echo json_encode($result);

		exit;
	}

	// returns the form fields for an image slide
	public function get_slide_config() {
		global $post;
		$id = (int)$_POST['id'];
		$post = get_post($id);

		$config = array(
			'id' => 'slide-options',
			'ondemand' => true,
		);

		require_once WPV_ADMIN_HELPERS . 'metaboxes_generator.php';

		$thumbnail_id = get_post_thumbnail_id($id);
		$htmlslide = ($thumbnail_id <= 0);

		$options = include WPV_THEME_METABOXES . $this->config_file($id);

		$options = array_merge($options, array(array(
			'title' => __('Save changes', 'wpv'),
			'type' => 'button',
			'class' => 'wpv-save-slide-config',
		)));

		$form = new metaboxes_generator($config, $options);
		$form->render();
	
		exit;
	}

	// saves slide config
	public function save_slide_config() {
		global $post;
		$id = (int)$_POST['id'];
		$post = get_post($id);
		$_POST['post_type'] = 'slideshow';

		$config = array(
			'id' => 'slide-options',
			'ondemand' => true,
		);

		require_once WPV_ADMIN_HELPERS . 'metaboxes_generator.php';
		$options = include WPV_THEME_METABOXES . $this->config_file($id);
		$form = new metaboxes_generator($config, $options);
		$form->save($id);
	
		die(1);
		exit;
	}

	private function config_file($id) {
		$thumbnail_id = get_post_thumbnail_id($id);
		$htmlslide = ($thumbnail_id <= 0);

		$meta = array(
			-3 => 'sintia.php',
			0 => 'slideshow.php',
		);

		if(isset($meta[$thumbnail_id]))
			return $meta[$thumbnail_id];

		return $meta[0];
	}

	// creates a new slider
	public function create_slider() {
		if(!term_exists($_POST['title'], 'slideshow_category')) {
			$term = wp_insert_term($_POST['title'], 'slideshow_category');
			echo $term['term_id'];
			exit;
		}

		die('0');
	}

	// returns a json object with info about the slider
	public function get_slider_data() {
		$slider = get_term($_POST['id'], 'slideshow_category');

		header('Content-type: application/json');
		echo json_encode(array(
			'name' => $slider->name,
		));
		exit;
	}

	public function get_slides() {
		header('Content-type: application/json');
		echo json_encode($this->get_slides_by_slider_id((int)$_POST['id']));
		exit;
	}

	private function get_slides_by_slider_id($id) {
		$slides = array();
		$query = array(
			'post_type' => 'slideshow',
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'post_status' => array('publish', 'trash'),
			'tax_query' => array(
				array(
					'taxonomy' => 'slideshow_category',
					'field' => 'id',
					'terms' => $id,
					'operator' => 'IN',
				)
			),
		);
		
		$raw_slides = get_posts($query);
		foreach($raw_slides as $s) {
			$thumbnail_id = get_post_thumbnail_id($s->ID);
			if($thumbnail_id > 0) {
				$image = wp_get_attachment_image_src( $thumbnail_id , array(150,150));
				$image = $image[0];
			} else {
				$image = $this->html_thumbnails[empty($thumbnail_id) ? -1 : $thumbnail_id];
			}

			$slides[] = array(
				'id' => $s->ID,
				'img' => $image,
				'status' => $s->post_status,
				'menu_order' => $s->menu_order,
			);
		}

		return $slides;
	}

	// returns a json array with all slider ids
	public function get_sliders() {
		$sliders = get_terms('slideshow_category', array(
			'hide_empty' => false,
		));

		$ids = array();
		foreach($sliders as $s) {
			$ids[]= $s->term_id;
		}

		header('Content-type: application/json');
		echo json_encode($ids);
		exit;
	}

	// create a slide and attach an image if present
	public function create_slide() {
		$catid = (int)$_POST['slider'];
		$thumbnail_id = (int)$_POST['image'];

		$slide = wp_insert_post(array(
			'post_title' => ' ',
			'post_content' => ' ',
			'post_status' => 'publish',
			'post_type' => 'slideshow',
			'tax_input' => array('slideshow_category' => array($catid)),
		), true);

		update_post_meta($slide, '_thumbnail_id', $thumbnail_id);

		echo $slide;
		exit;
	}

	// trashes a slide
	public function trash_slide() {
		$slide = (int)$_POST['id'];

		echo wp_update_post(array(
			'ID' => $slide,
			'post_status' => 'trash',
		));
		exit;
	}

	// deletes a slide
	public function delete_slide() {
		$slide = (int)$_POST['id'];

		wp_delete_post($slide);
		die('1');
	}

	// restores a slide
	public function restore_slide() {
		$slide = (int)$_POST['id'];

		echo wp_update_post(array(
			'ID' => $slide,
			'post_status' => 'publish',
		));
		exit;
	}
}
new WPV_Slider_Editor;