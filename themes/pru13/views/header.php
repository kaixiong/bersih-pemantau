<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo html::specialchars($page_title.$site_name); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $header_block; ?>
	<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>

	<script type="text/javascript">
	(function($) {
        $(document).ready(function() {
            var help = "<?php echo Kohana::lang('ui_main.search'); ?>...";
            $('#search input').val(help)
                .focus(function() {
                    var input = $(this);
                    if (input.val() == help) {
                        input.val('');
                    }
                })
                .focusout(function() {
                    var input = $(this);
                    if (input.val() == '') {
                        input.val(help);
                    }
                });
        });

        $(document).ready(function() {
            var obj = $('#kat');
            obj.find('li a').click(function() {
                $('#category_switch').hide();
            });
            obj.hover(function() {
                $('#category_switch').show();
            }, function() {
                $('#category_switch').hide();
            });
        });
	})(jQuery);
	</script>
	
</head>

<?php
  // Add a class to the body tag according to the page URI

  // we're on the home page
  if (count($uri_segments) == 0)
  {
    $body_class = "page-main";
  }
  // 1st tier pages
  elseif (count($uri_segments) == 1)
  {
    $body_class = "page-".$uri_segments[0];
  }
  // 2nd tier pages... ie "/reports/submit"
  elseif (count($uri_segments) >= 2)
  {
    $body_class = "page-".$uri_segments[0]."-".$uri_segments[1];
  }
?>

<body id="page" class="<?php echo $body_class; ?>">

	<!-- wrapper -->
	<div class="rapidxwpr floatholder">
		<!-- header -->
		<div id="header">

		<!-- searchbox -->
		<div id="searchbox">
			<!-- searchform -->
			<?php echo $search; ?>
			<!-- / searchform -->
		</div>
		<!-- / searchbox -->

        <!-- Google translate -->
        <div id="google_translate_element"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'ms', includedLanguages: 'en,ta,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <!-- / Google translate -->

		<div id="topmenu" class="clearingfix">
			<ul>
				<?php nav::main_tabs($this_page); ?>
			</ul>
		</div>

		<!-- logo -->
		<?php if ($banner == NULL): ?>
		<div id="logo">
			<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
			<span><?php echo $site_tagline; ?></span>
		</div>
		<?php else: ?>
		<a href="<?php echo url::site();?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
		<?php endif; ?>
		<!-- / logo -->

		<!-- mainmenu -->
		<div id="mainmenu" class="clearingfix" style="background:#000;float:left;">
			<!--tombol relawan-->
            <!--
			<div id="rela">
				<a href="http://bit.ly/JSztNY">Daftar Pemantau</a>
			</div><!--rela-->

			<!--tombol aduan-->
			<!--<div id="tomat">
			<a href="reports/#middle"><?php echo "<span>Aduan :</span> ".Incident_Model::get_total_reports(TRUE); ?></a>
			</div><!--tomat-->

			<!--<div id="lapor">
			<a href="<?php echo url::site('reports/submit/#mainmiddle'); ?>">Hantar Aduan</a>
			</div><!--lapor-->

			<!--<div id="sitemsg">
			Sebarang aduan berkenaan pilihanraya boleh dibuat melalui salah satu cara berikut:
			</div>-->

			<p style="font-size:24px;color:#fff;padding:1em;">Sebarang aduan berkenaan pilihanraya boleh dibuat melalui salah satu cara berikut:</p>
			<ul>
				<?php //nav::main_tabs($this_page); ?>
				<li>
					<div id="icon-sms" class="icon"></div>
					<div class="caption">
						<span>SMS Aduan</span>
						013-7711071
					</div>
				</li>
				<li>
					<div id="icon-phone" class="icon"></div>
					<div class="caption">
						<span>Talian Aduan</span>
						03-7931 0840
					</div>
				</li>
				<li>
					<div id="icon-email" class="icon"></div>
					<div class="caption">
						<a href="mailto:jompantau@komas.org"><span>E-Mail Aduan</span></a>
						jompantau@komas.org
					</div>
				</li>
				<li style="border-right:1px solid #000;">
					<div id="icon-twitter" class="icon"></div>
					<div class="caption">
						<a href="https://twitter.com/search?q=%23jompantau" target="_blank"><span>Tweet Aduan</span></a>
						#jompantau
					</div>
				</li>
				<li style="background:yellow;color:#000">
					<div id="icon-form" class="icon"></div>
					<div class="caption">
						<a style="color:#000" href="<?php echo url::site('reports/submit'); ?>"><span>Hantar aduan</span></a>
						online form
					</div>
				</li>
			</ul>
		</div>
		<!-- / mainmenu -->
	</div>
	<!-- / header -->
    <!-- / header item for plugins -->
	<?php
		// Action::header_item - Additional items to be added by plugins
		Event::run('ushahidi_action.header_item');
	?>
	<!-- main body -->
	<div id="middle">
		<div class="background layoutleft">
