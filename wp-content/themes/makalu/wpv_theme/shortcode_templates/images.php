<?php
	
	$class .= ($underline == 'true') ? ' has-shadow' : '';

	$res =  '<span class="image_styled'.($align?' align'.$align:'').' '. $class .'">';
	if(!empty($link)) {
		$res .= '<a'.($group?' rel="'.$group.'"':'').' class="'.$link_class.' thumbnail '.$no_link.($lightbox =='true'?' lightbox':' no-lightbox').'" title="'.$title.'" href="'.$link.'">' ;
	}
	$res .= $image;
	if(!empty($link)) {
		$res .= '</a>';
	}
	$res .= '</span>';
	
	echo $res;
