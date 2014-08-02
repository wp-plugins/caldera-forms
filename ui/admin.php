<?php

// Just some basics.
$per_page_limit = 20;


// get all forms
$forms = get_option( '_caldera_forms' );
$forms = apply_filters( 'caldera_forms_admin_forms', $forms );

$style_includes = get_option( '_caldera_forms_styleincludes' );
if(empty($style_includes)){
	$style_includes = array(
		'alert'	=>	true,
		'form'	=>	true,
		'grid'	=>	true,
	);
	update_option( '_caldera_forms_styleincludes', $style_includes);
}

// Modal Height
$modal_height = '400';

// check there are groups
if(!empty($meta_groups['groups'])){
	if( count($meta_groups['groups']) > 7){
		$multiplier = count($meta_groups['groups']) - 7;
		$modal_height = $modal_height + ( 30 * $multiplier );
	}
}
// load fields
//$field_types = apply_filters('caldera_forms_get_field_types', array() );

// create user modal buttons
$modal_new_form = __('Create Form', 'caldera-forms').'|{"data-action" : "create_form", "data-active-class": "disabled", "data-load-class": "disabled", "data-callback": "new_form_redirect", "data-before" : "serialize_modal_form", "data-modal-autoclose" : "new_form" }';

?><div class="caldera-editor-header">
	<ul class="caldera-editor-header-nav">
		<li class="caldera-editor-logo">
			Caldera Forms
		</li>
		<li class="caldera-forms-version">
			v<?php echo CFCORE_VER; ?>
		</li>
		<li class="caldera-forms-toolbar-item">
			<a class="button ajax-trigger" data-request="start_new_form" data-modal-buttons='<?php echo $modal_new_form; ?>' data-modal-width="600" data-modal-height="400" data-load-class="none" data-modal="new_form" data-modal-title="<?php echo __('Create New Form', 'caldera-forms'); ?>" data-template="#new-form-tmpl"><?php echo __('New Form', 'caldera-forms'); ?></a>
		</li>
		<li class="caldera-forms-toolbar-item">
			<a class="button ajax-trigger" data-request="start_new_form" data-modal-width="400" data-modal-height="192" data-load-class="none" data-modal="new_form" data-template="#import-form-tmpl" data-modal-title="<?php echo __('Import Form', 'caldera-forms'); ?>" ><?php echo __('Import', 'caldera-forms'); ?></a>
		</li>
		<li class="caldera-forms-toolbar-item">
			<button type="button" id="updated-extensions-button" title="<?php echo __('Caldera Forms Extensions', 'caldera-forms'); ?>" data-modal-buttons="Close|dismiss" data-load-class="spinner" data-active-class="none" data-set="alert" data-request="<?php echo CFCORE_EXTEND_URL . 'extensions/?version=' . CFCORE_VER; ?>" data-modal="extend_cf" data-error="extend_fail_notice" data-template="#extensions-modal-tmpl" data-modal-width="720" data-modal-title="<?php echo __('Caldera Forms Extensions & Addons', 'caldera-forms'); ?>" class="ajax-trigger button"><?php echo __('Extensions' , 'caldera-forms'); ?></button>
		</li>
		<li class="caldera-forms-toolbar-item">
			<button type="button" id="updated-news-button" title="<?php echo __('Caldera Forms Updates, News & Tips', 'caldera-forms'); ?>" data-modal-buttons="Close|dismiss" data-load-class="spinner" data-active-class="none" data-set="alert" data-request="<?php echo CFCORE_EXTEND_URL . 'updates/?version=' . CFCORE_VER; ?>" data-modal="extend_cf" data-error="extend_fail_notice" data-template="#extensions-modal-tmpl" data-modal-width="720" data-modal-title="<?php echo __('Caldera Forms Updates, News & Tips', 'caldera-forms'); ?>" class="ajax-trigger button"><?php echo __('Updates & Tips' , 'caldera-forms'); ?></button>
		</li>
		<li class="caldera-forms-toolbar-item ajax-trigger" data-request="<?php echo CFCORE_EXTEND_URL . 'freshness'; ?>" data-callback="news_update_check" data-autoload="true" data-event="none">
		&nbsp;
		</li>
		<li class="caldera-forms-headtext">
			<?php echo __('Front-end Style Includes', 'caldera-forms'); ?>
		</li>
		<li class="caldera-forms-toolbar-item">
			<div class="toggle_option_preview">
				<button type="button" title="<?php echo __('Includes Bootstrap 3 styles on the frontend for form alert notices', 'caldera-forms'); ?>" data-action="save_cf_setting" data-active-class="none" data-set="alert" data-callback="update_setting_toggle" class="ajax-trigger setting_toggle_alert button <?php if(!empty($style_includes['alert'])){ ?>button-primary<?php } ?>"><?php echo __('Alert' , 'caldera-forms'); ?></button>
				<button type="button" title="<?php echo __('Includes Bootstrap 3 styles on the frontend for form fields and buttons', 'caldera-forms'); ?>" data-action="save_cf_setting" data-active-class="none" data-set="form" data-callback="update_setting_toggle" class="ajax-trigger setting_toggle_form button <?php if(!empty($style_includes['form'])){ ?>button-primary<?php } ?>"><?php echo __('Form' , 'caldera-forms'); ?></button>
				<button type="button" title="<?php echo __('Includes Bootstrap 3 styles on the frontend for form grid layouts', 'caldera-forms'); ?>" data-action="save_cf_setting" data-active-class="none" data-set="grid" data-callback="update_setting_toggle" class="ajax-trigger setting_toggle_grid button <?php if(!empty($style_includes['grid'])){ ?>button-primary<?php } ?>"><?php echo __('Grid' , 'caldera-forms'); ?></button>
			</div>
		</li>
		<li class="caldera-forms-toolbar-item">
		&nbsp;
		</li>

	</ul>
</div>
<div class="form-admin-page-wrap">
	<div class="form-panel-wrap">
	<?php if(!empty($forms)){ ?>
		<table class="widefat fixed">
			<thead>
				<tr>
					<th>Form</th>
					<th style="width:4em; text-align:center;">Entries</th>
				</tr>		
			</thead>
			<tbody>
		<?php

			global $wpdb;

			$class = "alternate";
			foreach($forms as $form_id=>$form){

				if(!empty($form['db_support'])){
					$total = $wpdb->get_var($wpdb->prepare("SELECT COUNT(`id`) AS `total` FROM `" . $wpdb->prefix . "cf_form_entries` WHERE `form_id` = %s && `status` = 'active';", $form_id));
				}else{
					$total = __('Disabled', 'caldera-forms');
				}
				/*
				?>

				<div class="form-panel postbox">
					<h4><?php echo $form['name']; ?></h4>
					<?php if(!empty($form['description'])){ ?><h5><?php echo $form['description']; ?></h5><?php } ?>

					<ul class="form-controls">
						<li><a class="form-control" href="admin.php?page=caldera-forms&edit=<?php echo $form_id; ?>"><?php echo __('Edit Form', 'caldera-forms'); ?></a></li>
						<li><a class="form-control ajax-trigger" href="#entres"

						data-action="browse_entries"
						data-target="#form-entries-viewer"
						data-form="<?php echo $form_id; ?>"



						><?php echo __('Entries: ' . $total, 'caldera-forms'); ?></a></li>
						<li class="form-delete"><a class="form-control" data-confirm="<?php echo __('This will delete this form permanently. Continue?', 'caldera-forms'); ?>" href="admin.php?page=caldera-forms&delete=<?php echo $form_id; ?>&cal_del=<?php echo wp_create_nonce( 'cf_del_frm' ); ?>"><?php echo __('Delete Form', 'caldera-forms'); ?></a></li>
					</ul>					
				</div>

				<?php
				*/
				?>

				<tr id="form_row_<?php echo $form_id; ?>" class="<?php echo $class; ?> form_entry_row">						
					<td>
						<?php echo $form['name']; ?>
						<div class="row-actions">
						<span class="edit"><a class="form-control" href="admin.php?page=caldera-forms&edit=<?php echo $form_id; ?>"><?php echo __('Edit', 'caldera-forms'); ?></a> | </span>
						<?php if(!empty($form['db_support'])){ ?><span class="edit"><a class="form-control form-entry-trigger ajax-trigger" href="#entres"

						data-action="browse_entries"
						data-target="#form-entries-viewer"
						data-form="<?php echo $form_id; ?>"
						data-template="#forms-list-alt-tmpl"
						data-active-element="#form_row_<?php echo $form_id; ?>"
						data-load-class="spinner"
						data-active-class="highlight"
						data-group="entry_nav"
						data-callback="setup_pagination"
						data-status="active"
						data-page="1"

						><?php echo __('View Entries', 'caldera-forms'); ?></a> | </span><?php } ?>
						<span class="export"><a class="form-control" href="admin.php?page=caldera-forms&export-form=<?php echo $form_id; ?>&cal_del=<?php echo wp_create_nonce( 'cf_del_frm' ); ?>"><?php echo __('Export Form', 'caldera-forms'); ?></a> | </span>
						<span class="trash form-delete"><a class="form-control" data-confirm="<?php echo __('This will delete this form permanently. Continue?', 'caldera-forms'); ?>" href="admin.php?page=caldera-forms&delete=<?php echo $form_id; ?>&cal_del=<?php echo wp_create_nonce( 'cf_del_frm' ); ?>"><?php echo __('Delete', 'caldera-forms'); ?></a></span>


						</div>
					</td>
					<td style="width:4em; text-align:center;" class="entry_count_<?php echo $form_id; ?>"><?php echo $total; ?></td>
				</tr>


				<?php
				if($class == 'alternate'){
					$class = '';
				}else{
					$class = "alternate";
				}

			}
		?></tbody>
		</table>
		<?php }else{ ?>
		<p><?php echo __('You don\'t have any forms.', 'caldera-forms'); ?></p>
		<?php } ?>
	</div>
	<div class="form-entries-wrap">
		<div class="caldera-entry-exporter" style="display:none;">

			<span class="toggle_option_preview" style="">
				<button type="button" class="status_toggles button button-primary ajax-trigger" style="margin-top: 1px;"
					data-action="browse_entries"
					data-target="#form-entries-viewer"
					data-form=""
					data-template="#forms-list-alt-tmpl"
					data-load-class="spinner"
					data-active-class="button-primary"
					data-group="status_nav"
					data-callback="setup_pagination"
					data-page="1"
					data-status="active"
				>Active <span class="current-status-count"></span></button>
				<button type="button" class="status_toggles button ajax-trigger" style="margin-top: 1px; margin-right: 10px;"
					data-action="browse_entries"
					data-target="#form-entries-viewer"
					data-form=""
					data-template="#forms-list-alt-tmpl"
					data-load-class="spinner"
					data-active-class="button-primary"
					data-group="status_nav"
					data-callback="setup_pagination"
					data-page="1"
					data-status="trash"
				>Trash <span class="current-status-count"></span></button>
			</span>


			<a href="" class="button caldera-forms-entry-exporter"><?php echo __('Export Entries', 'caldera-forms'); ?></a>

			<select id="cf_bulk_action" name="action">
			</select>
			<button type="button" class="button cf-bulk-action"><?php echo __('Apply'); ?></button>

		</div>

		<?php do_action('caldera_forms_entries_toolbar'); ?>
		<div class="tablenav caldera-table-nav" style="display:none;">
			<div class="tablenav-pages">
				<span class="displaying-num"></span>
				<span class="pagination-links">
					<a href="#first" title="Go to the first page" data-page="first" class="first-page">«</a>
					<a href="#prev" title="Go to the previous page" data-page="prev" class="prev-page">‹</a>
					<span class="paging-input"><input type="text" size="1" name="paged" title="Current page" class="current-page"> of <span class="total-pages"></span></span>
					<a href="#next" title="Go to the next page" data-page="next" class="next-page">›</a>
					<a href="#last" title="Go to the last page" data-page="last" class="last-page">»</a>
				</span>
			</div>
		</div>
		<div id="form-entries-viewer"></div>
	</div>
</div>

<?php
do_action('caldera_forms_admin_templates');
?>
<script type="text/javascript">

function cf_refresh_view(obj){
	
	jQuery('.entry_count_' + obj.params.trigger.data('form')).html(obj.rawData.total);
	jQuery('.status_toggles[data-status="trash"] .current-status-count').html(obj.rawData.trash);
	jQuery('.status_toggles[data-status="active"] .current-status-count').html(obj.rawData.total);
	if(obj.rawData.undo === obj.params.trigger.data('panel')){
		obj.params.trigger.closest('tr').addClass('cf-deleted-row');
	}else{
		obj.params.trigger.closest('tr').removeClass('cf-deleted-row');
	}
	obj.params.trigger.data('do', obj.rawData.undo).html(obj.rawData.undo_text).removeClass('disabled');
}

function new_form_redirect(obj){
	if(typeof obj.data === 'string'){
		window.location = 'admin.php?page=caldera-forms&edit=' + obj.data;
	}else{
		alert(obj.data.error);
	}
}

// profile form saver
function serialize_modal_form(el){
	
	var clicked	= jQuery(el),
		data 	= clicked.closest('.caldera-modal-wrap').find('.new-form-form'),
		name = data.find('.new-form-name');
	
	//verify name is set
	if(name.val().length < 1){
		alert("<?php echo __('An form name is required', 'caldera-forms'); ?>");
		name.focus().addClass('has-error');
		return false;
	}


	clicked.data('data', data.serialize());

	return true;
}

function setup_pagination(obj){

	var total			= obj.rawData.total,
		trash			= obj.rawData.trash,
		active			= obj.rawData.active,		
		toggles			= jQuery('.status_toggles'),
		exporter		= jQuery('.caldera-entry-exporter'),
		tense			= ( total === 1 ? ' <?php echo __('entry', 'caldera-pages'); ?>' : ' <?php echo __('entries', 'caldera-pages'); ?>' ),
		pages			= obj.rawData.pages,
		current			= obj.rawData.current_page,
		form			= obj.params.trigger.data('form'),
		status			= obj.params.trigger.data('status'),
		pagenav			= jQuery('.caldera-table-nav'),
		page_links		= pagenav.find('.pagination-links'),
		entries_total	= pagenav.find('.displaying-num'),
		pages_total		= pagenav.find('.total-pages'),
		current_display	= pagenav.find('.current-page'),
		first_page		= pagenav.find('.first-page'),
		prev_page		= pagenav.find('.prev-page'),
		next_page		= pagenav.find('.next-page'),
		last_page		= pagenav.find('.last-page'),
		form_trigger	= jQuery('.form_entry_row.highlight').find('.form-entry-trigger'),
		bulk_actions	= jQuery('#cf_bulk_action'),
		bulk_template	= jQuery('#bulk-actions-'+status+'-tmpl').html(),
		entry_count		= jQuery('.entry_count_' + form);

	obj.params.trigger.data('page', current);
	form_trigger.data('status', status);
	bulk_actions.html(bulk_template);

	toggles.removeClass('button-primary').removeClass('disabled');
	toggles.filter('[data-status="'+status+'"]').addClass('button-primary');
	toggles.each(function(k,v){
		var el = jQuery(v);
		if(typeof obj.rawData[el.data('status')] === 'number'){
			if(obj.rawData[el.data('status')] > 0){
				el.find('.current-status-count').html(obj.rawData[el.data('status')]);
			}else{
				el.find('.current-status-count').html('');
			}
		}
	});
	// update count
	entry_count.html(active); 
	//bulk-actions-active-tmpl

	// add form id to toggles
	toggles.data('form', form)
	pagenav.data('total', pages);
	/*
	if(total < 1 && trash < 1){
		pagenav.hide();
		exporter.hide();
		return;	
	}else if(total < 1 && trash < 1){
	*/
	if(pages <= 1){
		page_links.hide();
	}else{
		page_links.show();		
	}
	exporter.find('.caldera-forms-entry-exporter').attr('href', 'admin.php?page=caldera-forms&export=' + form);
	exporter.show();
	pagenav.show();
	page_links.find('a').removeClass('disabled');

	// setup values
	page_links.data('total', total);
	entries_total.html(total + tense);
	pages_total.html(pages);
	current_display.val(current);

	if(current === 1){
		first_page.addClass('disabled');
		prev_page.addClass('disabled');
	}else if(current === pages){
		last_page.addClass('disabled');
		next_page.addClass('disabled');		
	}


}

function update_setting_toggle(obj){

	for( var k in obj.data){
		if(obj.data[k] === true){
			jQuery('.setting_toggle_' + k).addClass('button-primary');
		}else{
			jQuery('.setting_toggle_' + k).removeClass('button-primary');
		}
	}
	
	//for()

}

function extend_fail_notice(el){
	jQuery("#extend_cf_baldrickModalBody").html('<div class="alert error"><p><?php echo __('Looks like something is not working. Please try again a little later or post to the <a href="http://wordpress.org/support/plugin/caldera-forms" target="_blank">support forum</a>.', 'caldera-forms'); ?></p></div>');
}

function start_new_form(){
	return {};
}

function news_update_check(obj){
	if(obj.data.updates.days <= 7){
		jQuery('#updated-news-button').addClass('button-primary');
		if(obj.data.title){
			jQuery('#updated-news-button').html( obj.data.title );
		}
	}
	if(obj.data.extensions.days <= 7){
		jQuery('#updated-extensions-button').addClass('button-primary');
		if(obj.data.title){
			jQuery('#updated-extensions-button').html( obj.data.title );
		}
	}
}

jQuery(function($){


	
	function do_page_navigate(el){
	
		var clicked 		= $(el);

		if(clicked.hasClass('disabled')){
			return;
		}

		var	form_trigger	= $('.form_entry_row.highlight').find('.form-entry-trigger'),
			current			= parseInt(form_trigger.data('page')),
			pagenav			= jQuery('.caldera-table-nav'),
			page_links		= pagenav.find('.pagination-links'),
			total			= parseInt(pagenav.data('total'));

		

		if(clicked.data('page') === 'first'){
			form_trigger.data('page', 1).trigger('click');
		}else if(clicked.data('page') === 'prev'){
			var next = current - 1;
			form_trigger.data('page', next).trigger('click');
		}else if(clicked.data('page') === 'next'){
			var next = current + 1;
			form_trigger.data('page', next).trigger('click');
		}else if(clicked.data('page') === 'last'){
			form_trigger.data('page', total).trigger('click');
		}else{
			form_trigger.data('page', clicked.val()).trigger('click');
		}
	}

	$('body').on('change','.current-page', function(e){
		do_page_navigate(this);
	});
	$('body').on('click','.pagination-links a', function(e){
		e.preventDefault();
		do_page_navigate(this);
	});

});

</script>
<?php
do_action('caldera_forms_admin_footer');
?>
