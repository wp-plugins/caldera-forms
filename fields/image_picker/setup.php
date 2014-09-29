<div class="caldera-config-group">
	<label><?php _e('Picker').' ' . _e('Size'); ?></label>
	<div class="caldera-config-field">
		<select class="block-input field-config image-picker-size" name="{{_name}}[picker]">
			<option value="image-thumb"{{#is picker value="image-thumb"}}selected=\"selected\"{{/is}}>Small</option>
			<option value="image-thumb-lrg"{{#is picker value="image-thumb-lrg"}}selected=\"selected\"{{/is}}>Large</option>
		</select>
	</div>
</div>
<div class="caldera-config-group caldera-config-group-full">
	<label>Default Image</label>
	<div class="caldera-config-field">
		<div class="image-picker-content {{picker}}">
			<div class="image-picker-side-bar">
				<img class="image-picker-thumbnail" 
				data-placehold="<?php echo CFCORE_URL . "fields/image_picker/img/image-thumb.png"; ?>" src="{{#if default/thumbnail}}{{default/thumbnail}}{{else}}<?php echo CFCORE_URL . "fields/image_picker/img/image-thumb.png"; ?>{{/if}}">
			</div>
			<div class="image-picker-main-content">
				<div>
					<select name="{{_name}}[default][size]" class="image-picker-sizer" {{#unless default/id}}disabled="true"{{/unless}} {{#if size}}{{#is_single size}}style="display:none;"{{/is_single}}{{/if}}>
						<?php
						$size_checks = array();
						foreach(get_intermediate_image_sizes() as $size){
							echo "<option value=\"".$size."\" {{#if default/size}}{{#is default/size value=\"".$size."\"}}selected=\"selected\"{{/is}}{{/if}}
							{{#if size}}
								{{#unless size/".$size."}}
								disabled=\"disabled\" style=\"display:none;\"
								{{/unless}}
							{{/if}}
							>".$size."</option>\r\n";
							$size_checks[] = "<label><input class=\"image-picker-allowed-size\" type=\"checkbox\" name=\"{{_name}}[size][".$size."]\" value=\"".$size."\" {{#if size}}{{#if size/".$size."}}checked=\"true\"{{/if}}{{else}}checked=\"checked\"{{/if}}> ".$size."</label>";
						}
						?>
					</select>
				</div>
				<button class="button image-picker-button cu-image-picker{{#if size}}{{#is_single size}} image-picker-button-solo{{/is_single}}{{/if}}" data-title="<?php echo __('Select Image', 'caldera-forms'); ?>" data-button="<?php echo __('Use Image', 'caldera-forms'); ?>" type="button"><?php echo __('Select Image', 'caldera-forms'); ?></button>
				<button class="button button-primary image-picker-button cu-image-remover{{#if size}}{{#is_single size}} image-picker-button-solo{{/is_single}}{{/if}}" data-title="<?php echo __('Select Image', 'caldera-forms'); ?>" data-button="<?php echo __('Use Image', 'caldera-forms'); ?>" type="button" {{#unless default/id}}disabled="true"{{/unless}}><?php echo __('Remove', 'caldera-forms'); ?></button>
			</div>
		</div>
		<input class="image-picker-image-id" name="{{_name}}[default][id]" type="hidden" value="{{default/id}}">
		<input class="image-picker-image-thumb" name="{{_name}}[default][thumbnail]" type="hidden" value="{{default/thumbnail}}">
	</div>
</div>
<div class="caldera-config-group">
	<label>Allowed Sizes</label>
	<div class="caldera-config-field">
		<?php echo implode($size_checks); ?>
	</div>
</div>