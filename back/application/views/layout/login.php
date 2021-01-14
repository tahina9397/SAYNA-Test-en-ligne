<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo THEMES_URL?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php echo THEMES_URL?>css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Endless -->
	<link href="<?php echo THEMES_URL?>css/endless.min.css" rel="stylesheet">

	<!-- main css -->
	<link href="<?php echo THEMES_URL?>css/main.css" rel="stylesheet">

	<!-- growl -->
	<link href="<?php echo PLUGINS_URL?>jquery.growl/css/jquery.growl.css" rel="stylesheet">


</head>
<body>
	<?php echo $contents ?>

    <!-- Jquery -->
    <?php /* ?>
	<script src="<?php echo THEMES_URL ?>js/jquery-1.10.2.min.js"></script>
	<?php */ ?>
	<script src="<?php echo THEMES_URL ?>js/jquery-2.1.0.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="<?php echo THEMES_URL ?>bootstrap/js/bootstrap.min.js"></script>
   
	<!-- Modernizr -->
	<script src='<?php echo THEMES_URL ?>js/modernizr.min.js'></script>
   
    <!-- Pace -->
	<script src='<?php echo THEMES_URL ?>js/pace.min.js'></script>
   
	<!-- Popup Overlay -->
	<script src='<?php echo THEMES_URL ?>js/jquery.popupoverlay.min.js'></script>
   
    <!-- Slimscroll -->
	<script src='<?php echo THEMES_URL ?>js/jquery.slimscroll.min.js'></script>
   
	<!-- Cookie -->
	<script src='<?php echo THEMES_URL ?>js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="<?php echo THEMES_URL ?>js/endless/endless.js"></script>

	<!-- growl -->
	<script src="<?php echo PLUGINS_URL ?>jquery.growl/js/jquery.growl.js"></script>

	<!-- BLOCK UI -->
	<script src="<?php echo PLUGINS_URL ?>blockui.min.js"></script>

	<script type="text/javascript">
		var root = "<?php echo BASE_URL ?>"
	</script>

	<script src="<?php echo THEMES_URL ?>js/scripts/login/index.js"></script>

</body>
</html>
