<!DOCTYPE html>

<html lang="fr">
	<head>
		<!-- Meta données -->
		<meta charset="UTF-8" />
		<meta name="description" content="<?php echo $desc; ?>" />
		<meta name="keywords" content="<?php echo $keywords; ?>" />
		<meta name="author" content="<?php echo $author; ?>" />
		<title><?php echo $title; ?></title>

		<!-- Les styles -->
		<link href="<?php echo css('style'); ?>" rel="stylesheet" /> <!-- Style personnel -->
		<link href="<?php echo css('bootstrap'); ?>" rel="stylesheet" /> <!-- Bootstrap elements -->
		<link rel="shortcut icon" href="<?php echo img('favicon.gif'); ?>" />
	
		<!-- Les scripts -->
		<script type="text/javascript" src="<?php echo js('jquery-1.8.2.min'); ?>"></script>
		<script type="text/javascript" src="<?php echo js('bootstrap'); ?>"></script>
		<script type="text/javascript" src="<?php echo js('script'); ?>"></script>
	
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
