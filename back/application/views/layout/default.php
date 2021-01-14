<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$controllerName = $this->router->fetch_class();
	$actionName = $this->router->fetch_method();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo THEMES_URL?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo THEMES_URL?>bootstrap/css/bootstrap-extras-margins-padding.css" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php echo THEMES_URL?>css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Pace -->
	<link href="<?php echo THEMES_URL?>css/pace.css" rel="stylesheet">
	
	<!-- Color box -->
	<link href="<?php echo THEMES_URL?>css/colorbox/colorbox.css" rel="stylesheet">
	
	<!-- Morris -->
	<link href="<?php echo THEMES_URL?>css/morris.css" rel="stylesheet"/>	
	
	<!-- Endless -->
	<link href="<?php echo THEMES_URL?>css/endless.min.css" rel="stylesheet">
	<link href="<?php echo THEMES_URL?>css/endless-skin.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_URL ?>swal/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_URL ?>swal/themes/google/google.css">

	<!-- main css -->
	<link href="<?php echo THEMES_URL?>css/main.css" rel="stylesheet">

	<!-- growl -->
	<link href="<?php echo PLUGINS_URL?>jquery.growl/css/jquery.growl.css" rel="stylesheet">

    <!-- Jquery -->
    <?php /* ?>
	<script src="<?php echo THEMES_URL ?>js/jquery-1.10.2.min.js"></script>
    <?php */ ?>
	<script src="<?php echo THEMES_URL ?>js/jquery-2.1.0.min.js"></script>

	<!-- datatable -->
	<link href="<?php echo PLUGINS_URL?>tables/jquery.dataTables_themeroller.css" rel="stylesheet">
	<script src="<?php echo PLUGINS_URL ?>tables/jquery.dataTables.min.js"></script>
	<script src="<?php echo PLUGINS_URL ?>tables/fnReloadAjax.js"></script>

	<?php if ($controllerName == 'medias'): ?>
		<link href="<?php echo PLUGINS_URL; ?>dropzone/dropzone.css" rel="stylesheet">
	<?php endif ?>

	<!-- headLink -->
	<?php 
		if ($headLink) {
			echo $headLink;
		}
	?>

</head>
<body>
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

	<div id="wrapper" class="preload">
		<?php echo $this->layout->setStatics('header.php') ?>
		<?php  echo $this->layout->setStatics('sidebar.php') ?>
		<?php echo $contents ?>
		<?php echo $this->layout->setStatics('footer.php') ?>
		<?php echo $this->layout->setStatics('modal_modification.php') ?>
	</div>

		<a href="#" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

    
    
    <!-- Bootstrap -->
    <script src="<?php echo THEMES_URL ?>bootstrap/js/bootstrap.min.js"></script>

    <!-- Flot -->
    <script src='<?php echo THEMES_URL ?>js/jquery.flot.min.js'></script>

    <!-- Morris -->
    <?php /* ?>
    <script src='<?php echo THEMES_URL ?>js/rapheal.min.js'></script>	
    <script src='<?php echo THEMES_URL ?>js/morris.min.js'></script>
    <?php */ ?>
   
	<!-- Colorbox -->
	<script src='<?php echo THEMES_URL ?>js/jquery.colorbox.min.js'></script>	

	<!-- Sparkline -->
	<script src='<?php echo THEMES_URL ?>js/jquery.sparkline.min.js'></script>
	
	<!-- Pace -->
	<script src='<?php echo THEMES_URL ?>js/uncompressed/pace.js'></script>
	
	<!-- Popup Overlay -->
	<script src='<?php echo THEMES_URL ?>js/jquery.popupoverlay.min.js'></script>
	
	<!-- Slimscroll -->
	<script src='<?php echo THEMES_URL ?>js/jquery.slimscroll.min.js'></script>
	
	<!-- Modernizr -->
	<script src='<?php echo THEMES_URL ?>js/modernizr.min.js'></script>
	
	<!-- Cookie -->
	<script src='<?php echo THEMES_URL ?>js/jquery.cookie.min.js'></script>
	
	<!-- Endless -->
	<script src="<?php echo THEMES_URL ?>js/endless/endless_dashboard.js"></script>
	<script src="<?php echo THEMES_URL ?>js/endless/endless.js"></script>
	
	<!-- swal -->
    <script src="<?php echo PLUGINS_URL; ?>swal/sweet_alert.min.js"></script>

	<!-- growl -->
	<script src="<?php echo PLUGINS_URL ?>jquery.growl/js/jquery.growl.js"></script>

	<!-- BLOCK UI -->
	<script src="<?php echo PLUGINS_URL ?>blockui.min.js"></script>

	<!-- autosize.min -->
	<script src="<?php echo THEMES_URL ?>js/autosize.min.js"></script>

	<!-- inputmask -->
	<script src="<?php echo THEMES_URL ?>js/jquery.mask.min.js"></script>

	<!-- barcode -->
	<script src="<?php echo THEMES_URL ?>js/JsBarcode_3.6.0.all.min.js"></script>
	<!-- <script src="<?php echo THEMES_URL ?>js/JsBarcode_3.5.7.all.min.js"></script> -->

	<?php if ($controllerName == 'medias'): ?>
		<script src="<?php echo PLUGINS_URL ?>dropzone/dropzone.min.js"></script>
	<?php endif ?>

	<script type="text/javascript">
		var root = "<?php echo BASE_URL ?>"
	</script>

	<!-- headScript -->
	<?php 
		if ($headScript) {
			echo $headScript;
		}
	?>

	<!-- mainjs -->
	<script src="<?php echo THEMES_URL ?>js/main.js"></script>

	<?php 
		// if ($controllerName == 'infos'){
		// 	echo $this->layout->setStatics('blueimp.php') ;
		// 	echo $this->layout->setStatics('profile_upload.php',array(
		// 		'target_element' => 'updateInfos'
		// 		,'url'           => BASE_URL.'/fileupload/receiveprofile/to/profile'
		// 		,'type' => 'profile'
		// 		,'accepted_files' => '/(\.|\/)(gif|jpe?g|png)$/i' 
		// 	)) ;
		// }
	?>

</body>
</html>
