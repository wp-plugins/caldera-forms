<div class="caldera-config-group">
	<label><?php _e('Default'); ?></label>
	<div class="caldera-config-field">
		<input type="text" class="block-input field-config is-not-cfdatepicker magic-tag-enabled" data-dontprovide="cfdatepicker" id="{{id}}" data-date-format="{{format}}" name="{{_name}}[default]" value="{{default}}">
	</div>
</div>
<div class="caldera-config-group">
	<label><?php _e('Format', 'caldera-forms'); ?></label>
	<div class="caldera-config-field">
		<input type="text" class="cfdatepicker-set-format block-input field-config" id="{{id}}" name="{{_name}}[format]" value="{{format}}">
	</div>
</div>
<div class="caldera-config-group">
	<label><?php _e('language', 'caldera-forms'); ?></label>
	<div class="caldera-config-field">
		<input type="text" class="cfdatepicker-set-language block-input field-config" id="{{id}}" name="{{_name}}[language]" value="{{language}}" style="width: 90px;">
		<p class="description"><?php _e('Language to use. e.g. pt-BR', 'caldera-forms'); ?></p>
	</div>
</div>
