<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpv'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Icon Alt Title:', 'wpv'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $alt; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('package'); ?>"><?php _e('Icon Package:', 'wpv'); ?></label>
	<select name="<?php echo $this->get_field_name('package'); ?>" id="<?php echo $this->get_field_id('package'); ?>" class="widefat">
		<?php foreach ($this->packages as $name => $value): ?>
			<option value="<?php echo $name; ?>"<?php selected($package, $name); ?>><?php echo $value['name']; ?></option>
		<?php endforeach; ?>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Icon Hover Animation:', 'wpv'); ?></label>
	<select name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>" class="widefat">
		<option value="fade"<?php selected($animation, 'fade'); ?>><?php _e('Fade', 'wpv'); ?></option>
		<option value="scale"<?php selected($animation, 'scale'); ?>><?php _e('Scale', 'wpv'); ?></option>
		<option value="bounce"<?php selected($animation, 'bounce'); ?>><?php _e('Bounce', 'wpv'); ?></option>
		<option value="combo"<?php selected($animation, 'combo'); ?>><?php _e('Combo', 'wpv'); ?></option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('enable_sites'); ?>"><?php _e('Enable Social Icon:', 'wpv'); ?></label>
	<span class="description">Click ctrl if you want to choose more than one icon</span>
	<select name="<?php echo $this->get_field_name('enable_sites'); ?>[]" style="height:10em" id="<?php echo $this->get_field_id('enable_sites'); ?>" class="social_icon_select_sites widefat" multiple="multiple">
		<?php foreach ($this->sites as $site): ?>
			<option value="<?php echo $site; ?>"<?php echo in_array($site, $enable_sites) ? 'selected="selected"' : ''; ?>><?php echo $site; ?></option>
		<?php endforeach; ?>
	</select>
</p>
		
<p>
	<em><?php _e("Note: Please input FULL URL <br/>(e.g. <code>http://example.com</code>)", 'wpv'); ?></em>
</p>

<div class="social_icon_wrap">
	<?php foreach($this->sites as $i=>$site): ?>
		<p class="social_icon_<?php echo $site; ?>" <?php if (!in_array($site, $enable_sites)): ?>style="display:none"<?php endif; ?>>
			<label for="<?php echo $this->get_field_id($site); ?>"><?php echo $site . ' ' . __('URL:', 'wpv') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id($site); ?>" name="<?php echo $this->get_field_name($site); ?>" type="text" value="<?php echo $sites[$i]; ?>" />
		</p>
	<?php endforeach; ?>
</div>

<p>
	<label for="<?php echo $this->get_field_id('custom_count'); ?>"><?php _e('How many custom icons to add?', 'wpv'); ?></label>
	<select id="<?php echo $this->get_field_id('custom_count'); ?>" class="num_shown" name="<?php echo $this->get_field_name('custom_count'); ?>">
		<option <?php selected(0, $custom_count) ?>>0</option>
		<?php for($i=1; $i<=$this->max_custom; $i++): ?>
			<option <?php selected($i, $custom_count) ?>><?php echo $i ?></option>
		<?php endfor ?>
	</select>
</p>

<div class="hidden_wrap">
	<?php for ($i=1; $i<=$this->max_custom; $i++):
		$custom_name = "custom_name_$i";
		$custom_url = "custom_url_$i";
		$custom_icon = "custom_icon_$i"; ?>
		<div class="hidden_el" <?php if ($i > $custom_count):?>style="display:none"<?php endif; ?>>
		
			<p>
				<label for="<?php echo $this->get_field_id($custom_name); ?>"><?php printf(__('Name:', 'wpv') , $i); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id($custom_name); ?>" name="<?php echo $this->get_field_name($custom_name); ?>" type="text" value="<?php echo $custom_names[$i]; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id($custom_url); ?>"><?php printf(__('URL:', 'wpv') , $i); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id($custom_url); ?>" name="<?php echo $this->get_field_name($custom_url); ?>" type="text" value="<?php echo $custom_urls[$i]; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id($custom_icon); ?>"><?php printf(__('Icon:', 'wpv') , $i); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id($custom_icon); ?>" name="<?php echo $this->get_field_name($custom_icon); ?>" type="text" value="<?php echo $custom_icons[$i]; ?>" />
			</p>
		</div>

	<?php endfor; ?>
</div>