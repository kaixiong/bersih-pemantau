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
	<div class="rapidxwpr">
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

			<a class="button" href="<?php echo url::site('reports/submit'); ?>">
				<div id="icon-form" class="icon"></div>
				<span class="caption">Hantar Aduan Berkenaan PRU13</span>
			</a>

			<div class="contact-details">
				<p>Pertanyaan</p>
				<ul>
					<li><div class="icon" id="icon-phone"></div>013-7711071</li>
					<li><div class="icon" id="icon-email"></div><a href="mailto:jompantau@komas.org">jompantau@komas.org</a></li>
				</ul>
			</div>
		</div>
		<?php else: ?>
		<a href="<?php echo url::site();?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
		<?php endif; ?>
		<!-- / logo -->
	</div>
	<!-- / header -->

	<!-- main body -->
	<div id="middle">
		<div class="background layoutleft">
