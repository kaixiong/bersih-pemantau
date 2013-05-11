<!-- main body -->
<div id="main" class="clearingfix">
	<div id="mainmiddle">
		<!-- content column -->
		<div id="content" class="clearingfix">
			<div>
				<!-- filters -->
				<div class="filters">
					<div style="float:left; width:365px;">
						<strong><?php echo Kohana::lang('ui_main.filters'); ?></strong>
						<ul>
							<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
							<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
							<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
							<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
							<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
						</ul>
					</div>

					<?php
					// Action::main_filters - Add items to the main_filters
					//Event::run('ushahidi_action.map_main_filters');
					// Action::main_sidebar_pre_filters - Add Items to the Entry Page before filters
					Event::run('ushahidi_action.main_sidebar_pre_filters');
					?>
				</div>
				<!-- / filters -->

                <div id="kat" style="float:left; margin-left:1em;">
			<!-- category filters -->
			<div class="cat-filters clearingfix">
				<strong>
					<?php echo Kohana::lang('ui_main.category_filter');?>
					<span>
						[<a href="javascript:toggleLayer('category_switch_link', 'category_switch')" id="category_switch_link">
							<?php echo Kohana::lang('ui_main.hide'); ?>
						</a>]
					</span>
				</strong>
			</div>

			<ul id="category_switch" class="category-filters">
				<?php
				$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
				$all_cat_image = '';
				if ($default_map_all_icon != NULL)
				{
					$all_cat_image = html::image(array(
						'src'=>$default_map_all_icon,
						'style'=>'float:left;padding-right:5px;'
					));
					$color_css = '';
				}
				?>
				<li>
					<a class="active" id="cat_0" href="#">
						<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
						<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
					</a>
				</li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = html::escape($category_info[0]);
						$category_color = $category_info[1];
						$category_image = ($category_info[2] != NULL)
						    ? url::convert_uploaded_to_abs($category_info[2])
						    : NULL;
						$category_description = html::escape(Category_Lang_Model::category_description($category));

						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						if ($category_info[2] != NULL)
						{
							$category_image = html::image(array(
								'src'=>$category_image,
								'style'=>'float:left;padding-right:5px;'
								));
							$color_css = '';
						}

						echo '<li>'
						    . '<a href="#" id="cat_'. $category .'" title="'.$category_description.'">'
						    . '<span '.$color_css.'>'.$category_image.'</span>'
						    . '<span class="category-title">'.$category_title.'</span>'
						    . '</a>';

						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
						if (sizeof($category_info[3]) != 0)
						{
							echo '<ul>';
							foreach ($category_info[3] as $child => $child_info)
							{
								$child_title = html::escape($child_info[0]);
								$child_color = $child_info[1];
								$child_image = ($child_info[2] != NULL)
								    ? url::convert_uploaded_to_abs($child_info[2])
								    : NULL;
								$child_description = html::escape(Category_Lang_Model::category_description($child));

								$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
								if ($child_info[2] != NULL)
								{
									$child_image = html::image(array(
										'src' => $child_image,
										'style' => 'float:left;padding-right:5px;'
									));

									$color_css = '';
								}

								echo '<li style="padding-left:20px;">'
								    . '<a href="#" id="cat_'. $child .'" title="'.$child_description.'">'
								    . '<span '.$color_css.'>'.$child_image.'</span>'
								    . '<span class="category-title">'.$child_title.'</span>'
								    . '</a>'
								    . '</li>';
							}
							echo '</ul>';
						}
						echo '</div></li>';
					}
				?>
			</ul>
			<!-- / category filters -->
				</div>

				<ul id="social">
					<li><a target="_blank" href="https://twitter.com/jompantau" class="twitter">Twitter</a></li>
					<li><a target="_blank" href="https://facebook.com/JomPantau" class="facebook">Facebook</a></li>
					<li><a target="_blank" href="<?php echo url::site(); ?>feed/" class="rss">RSS</a></li>
					<li><a target="_blank" href="https://youtube.com/user/jompantau" class="yt">Youtube</a></li>
					<li><a target="_blank" href="https://pinterest.com/jompantau/" class="ptr">Pinterest</a></li>
				</ul>

				<?php
				// Map and Timeline Blocks
				echo $div_map;
				echo $div_timeline;
				echo "<br />";

				?>

			</div>
		</div>

		<div style="margin-top:10px;padding:10px;overflow:hidden;background: url('../images/groovepaper.png') repeat scroll 0 0 #FFFFFF;">
			<div class="clearingfix">
				<ul>
				<?php
				blocks::render();
				?>
				</ul>
				<div style="float:left;width:300px;margin-right:10px;">
<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FJomPantau&amp;width=292&amp;height=395&amp;show_faces=false&amp;colorscheme=light&amp;stream=true&amp;border_color&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:395px;" allowTransparency="true"></iframe>
				</div>

		<div style="float:left;width:300px;margin-left:10px;">
			<p style="font-weight:bold;background:url(themes/default/images/twitter.gif) no-repeat 0 50%;padding-left:20px;">Jom Pantau Tweets</p>
<?php

			$hashtag = "jompantau";
			$cachefile = "application/cache/" . $hashtag ."-json.cache";
			$cachetime = 1 * 60; // where 1 is how many minutes you want to cache

			if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile)))
			{
			  $json = file_get_contents($cachefile);
			}
			else
			{
			  $json = file_get_contents("http://search.twitter.com/search.json?rpp=5&result_type=recent&q=" .$hashtag);
			  $fp = fopen($cachefile, 'w');
			  fwrite($fp, $json);
			  fclose($fp);
			}
			$results = json_decode($json)->results;

			?>
			<?php foreach( $results as $result) { ?>
				<div class="result">
					<div class="by"><a href="http://twitter.com/<?php echo $result->from_user ?>"><?php echo $result->from_user ?></a></div><div class="date"><?php echo date("M j \- g:ia",strtotime($result->created_at)); ?></div>
					<div class="tweet"><?php echo $result->text ?></div>
				</div>
			 <?php } ?>

					</div>
			</div>
			<div style="float:right;padding: 0 0 0 15px;width: 285px;" class="clearingfix">
			<?php if ($layers): ?>
				<!-- Layers (KML/KMZ) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?> 
						<span>
							[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link">
								<?php echo Kohana::lang('ui_main.hide'); ?>
							</a>]
						</span>
					</strong>
				</div>
				<ul id="kml_switch" class="category-filters">
				<?php
					foreach ($layers as $layer => $layer_info)
					{
						$layer_name = $layer_info[0];
						$layer_color = $layer_info[1];
						$layer_url = $layer_info[2];
						$layer_file = $layer_info[3];

						$layer_link = ( ! $layer_url)
						    ? url::base().Kohana::config('upload.relative_directory').'/'.$layer_file
						    : $layer_url;

						echo '<li>'
						    . '<a href="#" id="layer_'. $layer .'">'
						    . '<span class="swatch" style="background-color:#'.$layer_color.'"></span>'
						    . '<span class="layer-name">'.$layer_name.'</span>'
						    . '</a>'
						    . '</li>';
					}
				?>
				</ul>
				<!-- /Layers -->
			<?php endif; ?>

					   <?php
					   // Action::main_sidebar_post_filters - Add Items to the Entry Page after filters
					   Event::run('ushahidi_action.main_sidebar_post_filters');
					   ?>

				<!-- Checkins -->
				<?php if (Kohana::config('settings.checkins')): ?>
				<br/>
				<div class="additional-content">
					<h5><?php echo Kohana::lang('ui_admin.checkins'); ?></h5>
					<div id="cilist"></div>
				</div>
				<?php endif; ?>
				<!-- /Checkins -->

				<?php
				// Action::main_sidebar - Add Items to the Entry Page Sidebar
				Event::run('ushahidi_action.main_sidebar');
				?>

			</div>
		</div>
	</div>
</div>