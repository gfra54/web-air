<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	Makalu/WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$id_override = is_single() ? $post->id : (woocommerce_get_page_id( 'shop' ) ? woocommerce_get_page_id( 'shop' ) : null);

if(is_shop() || is_product_category() || is_product_tag())
	define('WPV_LAYOUT_TYPE', wpv_post_default('layout-type', 'default-body-layout', false, false, $id_override));

?>

<div class="pane main-pane">
	<div class="row">
		<div class="page-outer-wrapper">
			<div class="clearfix page-wrapper">
				<?php wpv_has_left_sidebar() ?>
				
				<article class="<?php echo wpv_get_layout(); ?>">
					<?php 
						global $wpv_has_header_sidebars;
						if( $wpv_has_header_sidebars) wpv_header_sidebars(); 
					?>
					<div class="page-content no-image">