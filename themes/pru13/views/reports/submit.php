<div id="content">

	<div class="content-bg neat-report">

		<?php if ($site_submit_report_message != ''): ?>
			<div class="green-box" style="margin: 25px 25px 0px 25px">
				<h3><?php echo $site_submit_report_message; ?></h3>
			</div>
		<?php endif; ?>

		<!-- start report form block -->
		<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>
		<input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
		<input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
		<input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
		<input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />
		<div class="big-block">
			<h1><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>
			<?php if ($form_error): ?>
			<!-- red-box -->
			<div class="red-box">
				<h3>Error!</h3>
				<ul>
					<?php
						foreach ($errors as $error_item => $error_description)
						{
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
					?>
				</ul>
			</div>
			<?php endif; ?>
			<div class="row">
				<input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">
			</div>
			
			<?php /* See: https://github.com/kaixiong/bersih-pemantau/issues/12 */ ?>
			<div id="person">
			
				<?php /* See: submit_custom_forms.php */ ?>
				<?php $custom_fields_personal = array_filter($custom_forms->disp_custom_fields, function($f) {
					return preg_match('/^NO.I.C/i', $f['field_name']) || preg_match('/^No.Tel/i', $f['field_name']);
				}); ?>
				<?php foreach ($custom_fields_personal as $f): ?>
					<div class="report_row">
						<?php echo "<h4>" . $f['field_name'] . '<font color=red> *</font>' . "</h4>"; ?>
						<?php echo form::input('custom_field['.$f['field_id'].']', $form['custom_field'][$f['field_id']], 'id="custom_field_'.$f['field_id'].'"' .' class="text custom_text long"'); ?>
					</div>
				<?php endforeach ?>
					
				<div class="report_optional">
					<div class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_first'); ?></h4>
						<?php print form::input('person_first', $form['person_first'], ' class="text long"'); ?>
					</div>
					<div class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_last'); ?></h4>
						<?php print form::input('person_last', $form['person_last'], ' class="text long"'); ?>
					</div>
					<div class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_email'); ?></h4>
						<?php print form::input('person_email', $form['person_email'], ' class="text long"'); ?>
					</div>
					<?php Event::run('ushahidi_action.report_form_optional'); ?>
				</div>
				
			</div>
			
			<hr/>
			
			<div id="report">
			
				<div class="report_location">
				
					<div id="divMap" class="report_map">
						<div id="geometryLabelerHolder" class="olControlNoSelect">
							<div id="geometryLabeler">
								<div id="geometryLabelComment">
									<span id="geometryLabel">
										<label><?php echo Kohana::lang('ui_main.geometry_label');?>:</label> 
										<?php print form::input('geometry_label', '', ' class="lbl_text"'); ?>
									</span>
									<span id="geometryComment">
										<label><?php echo Kohana::lang('ui_main.geometry_comments');?>:</label> 
										<?php print form::input('geometry_comment', '', ' class="lbl_text2"'); ?>
									</span>
								</div>
								<div>
									<span id="geometryColor">
										<label><?php echo Kohana::lang('ui_main.geometry_color');?>:</label> 
										<?php print form::input('geometry_color', '', ' class="lbl_text"'); ?>
									</span>
									<span id="geometryStrokewidth">
										<label><?php echo Kohana::lang('ui_main.geometry_strokewidth');?>:</label> 
										<?php print form::dropdown('geometry_strokewidth', $stroke_width_array, ''); ?>
									</span>
									<span id="geometryLat">
										<label><?php echo Kohana::lang('ui_main.latitude');?>:</label> 
										<?php print form::input('geometry_lat', '', ' class="lbl_text"'); ?>
									</span>
									<span id="geometryLon">
										<label><?php echo Kohana::lang('ui_main.longitude');?>:</label> 
										<?php print form::input('geometry_lon', '', ' class="lbl_text"'); ?>
									</span>
								</div>
							</div>
							<div id="geometryLabelerClose"></div>
						</div>
					</div>
					
					<div class="report-find-location">
					    <div id="panel" class="olControlEditingToolbar"></div>
						<div class="btns" style="float:left;">
							<ul style="padding:4px;">
								<li><a href="#" class="btn_del_last"><?php echo utf8::strtoupper(Kohana::lang('ui_main.delete_last'));?></a></li>
								<li><a href="#" class="btn_del_sel"><?php echo utf8::strtoupper(Kohana::lang('ui_main.delete_selected'));?></a></li>
								<li><a href="#" class="btn_clear"><?php echo utf8::strtoupper(Kohana::lang('ui_main.clear_map'));?></a></li>
							</ul>
						</div>
						<div style="clear:both;"></div>
						<?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext"'); ?>
						<div style="float:left;margin:9px 0 0 5px;">
							<input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find" />
						</div>
						<div id="find_loading" class="report-find-loading"></div>
						<div style="clear:both;" id="find_text"><?php echo Kohana::lang('ui_main.pinpoint_location'); ?>.</div>
					</div>
					
				</div>
				<?php Event::run('ushahidi_action.report_form_location', $id); ?>
				<div class="report_row">
					<h4>
						<?php echo Kohana::lang('ui_main.reports_location_name'); ?> 
						<span class="required">*</span><br />
					</h4>
					<?php print form::input('location_name', $form['location_name'], ' class="text long"'); ?>
					<span class="example"><?php echo Kohana::lang('ui_main.detailed_location_example'); ?></span>
				</div>
			
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_title'); ?> <span class="required">*</span> </h4>
					<?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?>
				</div>
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_description'); ?> <span class="required">*</span> </h4>
					<?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?>
				</div>
				<div class="report_row" id="datetime_default">
					<h4>
						<?php echo Kohana::lang('ui_main.date_time'); ?>
					</h4>
					<div class="form_value">
						<a href="#" id="date_toggle" class="show-more"><?php echo Kohana::lang('ui_main.modify_date'); ?></a>
						<?php echo Kohana::lang('ui_main.today_at')." "."<span id='current_time'>".$form['incident_hour']
							.":".$form['incident_minute']." ".$form['incident_ampm']."</span>"; ?>
						<?php if($site_timezone): ?>
							<small>(<?php echo $site_timezone; ?>)</small>
						<?php endif; ?>
					</div>
				</div>
				<div class="hide" id="datetime_edit">
					<div class="report_row date-box">
						<h4><?php echo Kohana::lang('ui_main.reports_date'); ?></h4>
						<div class="form_value">
							<?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>
							<script type="text/javascript">
								$().ready(function() {
									$("#incident_date").datepicker({ 
										showOn: "both", 
										buttonImage: "<?php echo url::file_loc('img'); ?>media/img/icon-calendar.gif", 
										buttonImageOnly: true 
									});
								});
							</script>
						</div>
					</div>
					<div class="report_row time">
						<h4><?php echo Kohana::lang('ui_main.reports_time'); ?></h4>
						<div class="form_value">
							<?php
								for ($i=1; $i <= 12 ; $i++)
								{
									// Add Leading Zero
									$hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);
								}
								for ($j=0; $j <= 59 ; $j++)
								{
									// Add Leading Zero
									$minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);
								}
								$ampm_array = array('pm'=>'pm','am'=>'am');
								print form::dropdown('incident_hour',$hour_array,$form['incident_hour']);
								print '<span class="dots">:</span>';
								print form::dropdown('incident_minute',$minute_array,$form['incident_minute']);
								print '<span class="dots">:</span>';
								print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm']);
							?>
							<?php if ($site_timezone != NULL): ?>
								<small>(<?php echo $site_timezone; ?>)</small>
							<?php endif; ?>
						</div>
					</div>
					<div style="clear:both; display:block;" id="incident_date_time"></div>
				</div>
				<div class="report_row">
					<!-- Adding event for endtime plugin to hook into -->
					<?php Event::run('ushahidi_action.report_form_frontend_after_time'); ?>
				</div>
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_categories'); ?> <span class="required">*</span></h4>
					<div class="report_category form_value" id="categories">
					<?php
						$selected_categories = (!empty($form['incident_category']) AND is_array($form['incident_category']))
							? $selected_categories = $form['incident_category']
							: array();
							
						echo category::form_tree('incident_category', $selected_categories, 2);
						?>
					</div>
				</div>


				<?php
				// Action::report_form - Runs right after the report categories
				Event::run('ushahidi_action.report_form');
				?>
				
				<?php echo $custom_forms ?>
				
				<?php if (count($cities) > 1): ?>
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_find_location'); ?></h4>
					<?php print form::dropdown('select_city',$cities,'', ' class="select" '); ?>
				</div>
				<?php endif; ?>
				
				<hr/>

				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_news'); ?></h4>
					<div class="form_value">
						<?php $i = (empty($form['incident_news'])) ? 1 : 0; ?>
						<div id="divNews" class="scalable">
							<?php if (empty($form['incident_news'])): ?>
								<div>
									<?php print form::input('incident_news[]', '', ' class="text long2"'); ?>
									<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>
								</div>
							<?php else: ?>
								<?php foreach ($form['incident_news'] as $value): ?>
									<div id="<?php echo $i; ?>">
										<?php echo form::input('incident_news[]', $value, ' class="text long2"'); ?>
										<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>

										<?php if ($i != 0): ?>
											<?php $css_id = "#incident_news_".$i; ?>
											<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
										<?php endif; ?>
									</div>
									<?php $i++; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php print form::input(array('name'=>'news_id', 'type'=>'hidden', 'id'=>'news_id'), $i); ?>
						</div>
					</div>
				</div>

				<div class="report_row">
					<h4><?php print Kohana::lang('ui_main.external_video_link'); ?></h4>
					<div class="form_value">
						<?php $i = (empty($form['incident_video'])) ? 1 : 0; ?>
						<div id="divVideo" class="scalable">
							<?php if (empty($form['incident_video'])): ?>
								<div>
									<?php print form::input('incident_video[]', '', ' class="text long2"'); ?>
									<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>
								</div>
							<?php else: ?>
								<?php foreach ($form['incident_video'] as $value): ?>
									<div id="<?php  echo $i; ?>">
										<?php print form::input('incident_video[]', $value, ' class="text long2"'); ?>
										<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>

										<?php if ($i != 0): ?>
											<?php $css_id = "#incident_video_".$i; ?>
											<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
										<?php endif; ?>
									</div>
									<?php $i++; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php print form::input(array('name'=>'video_id','type'=>'hidden','id'=>'video_id'), $i); ?>
						</div>
					</div>
				</div>
				<?php Event::run('ushahidi_action.report_form_after_video_link'); ?>

				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_photos'); ?></h4>
					<div class="form_value">
						<?php $i = (empty($form['incident_photo']['name'][0])) ? 1 : 0; ?>
						<div id="divPhoto" class="scalable">
							<?php if (empty($form['incident_photo']['name'][0])): ?>
								<div>
									<?php print form::upload('incident_photo[]', '', ' class="file long2"'); ?>
									<a href="#" class="add" onClick="addFormField('divPhoto', 'incident_photo','photo_id','file'); return false;">add</a>
								</div>
							<?php else: ?>
								<?php foreach ($form['incident_photo']['name'] as $value): ?>
									<div id="<?php echo $i; ?>">
										<?php print form::upload('incident_photo[]', $value, ' class="file long2"'); ?>
										<a href="#" class="add" onClick="addFormField('divPhoto','incident_photo','photo_id','file'); return false;">add</a>

										<?php if ($i != 0): ?>
											<?php $css_id = "#incident_photo_".$i; ?>
											<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
										<?php endif; ?>
									</div>
									<?php $i++; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php print form::input(array('name'=>'photo_id','type'=>'hidden','id'=>'photo_id'), $i); ?>
						</div>
					</div>
				</div>
				
				<div class="report_row">
					<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" /> 
				</div>
				
			</div>
		</div>
		<?php print form::close(); ?>
		<!-- end report form block -->
	</div>
</div>

<script type="text/javascript">
	$().ready(function() {

		// Extract text in brackets to help text.
		$('.report_row h4').each(function(){

			var desc = $(this).html();
			var f_bracket = desc.indexOf('(');
			var e_bracket = desc.indexOf(')');

			if(f_bracket === -1 || e_bracket == -1){
				return;
			}

			$(this).html(desc.substring(0, f_bracket));
			$(this).next(':input').after('<span class="example">' + desc.substring(f_bracket + 1, e_bracket) + '</span>')
		});
	});
</script>
