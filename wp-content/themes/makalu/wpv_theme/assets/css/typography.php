
/* primary font */
*,
p,
.main-container,
.contact_form input[type="text"], 
.contact_form input[type="email"], 
.contact_form textarea {
	<?php wpv_font('primary-font') ?>
}

/* em font */
.page-header .desc,
em {
	<?php wpv_font('em') ?>
	color: <?php wpvge('em-color') ?>;
}

<?php 
for($i=1; $i<=6; $i++):
	$h = "h$i";
?>
	<?php echo "$h, $h a, $h a:visited"?> {
		color: <?php wpvge("$h-color")?>;
	}
	<?php echo "$h, $h a"?> {
		<?php wpv_font($h) ?>
	}
<?php endfor; ?>

#footer-sidebars,
#footer-sidebars p {
	<?php wpv_font('footer-sidebars-font') ?>
	color: <?php wpvge('footer-sidebars-font-color') ?>;
}

#footer-sidebars h4 {
	<?php wpv_font('footer-sidebars-titles', true) ?>
}

#footer-sidebars .wpv_icon_link a .content {
	font-family: <?php wpv_font_family('footer-sidebars-titles') ?>;
}

#footer-sidebars h4 {
	color: <?php wpvge('footer-sidebars-titles-color')?>;
}

.copyrights,
.copyrights * {
	<?php wpv_font('sub-footer') ?>
	color: <?php wpvge('sub-footer-color') ?>;
}

<?php 
$links = array(
	'' => '',
	'footer.main-footer ' => 'footer_',
	'#footer-sidebars ' => 'footer_',
	//'#header-slider ' => 'header_'
);

foreach($links as $selector=>$substr): ?>
	
<?php echo $selector ?> a,
<?php echo $selector ?> .comments-link a b,
<?php echo $selector ?> .toggle_title,
<?php echo $selector ?> .accordion .tab,
<?php echo $selector ?> .wpv-tabs .ui-tabs-nav a,
<?php echo $selector ?> .woocommerce-tabs .ui-tabs-nav a {
	color: <?php wpvge('css_'.$substr.'link_color')?>;
}

<?php echo $selector ?> a:visited {
	color: <?php wpvge('css_'.$substr.'link_visited_color')?>;
}

<?php echo $selector ?> a:hover,
<?php echo $selector ?> .more-btn:hover span,
<?php echo $selector ?> .comments-link a:hover b, 
<?php echo $selector ?> .accordion .tab.ui-state-active,
<?php echo $selector ?> .accordion .tab:hover {
	color: <?php wpvge('css_'.$substr.'link_hover_color')?> !important;
} 

<?php endforeach ?>
