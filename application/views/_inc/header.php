<!DOCTYPE html>
<html ng-app="translateApp">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- include css -->
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/bootstrap.min.css">  -->
		<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/bootstrap.theme.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/jumbotron-narrow.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/style.css">

		<!-- include js plugins -->
		<script type="text/javascript" src="<?=base_url();?>public/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		
		
		<script type="text/javascript" src="<?=base_url();?>public/js/angular.min.js"></script>
		<script type="text/javascript" src="<?=base_url();?>public/js/ui-bootstrap-tpls-0.11.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url();?>public/js/underscore-min.js"></script>
		
		<!-- script do master controller -->
		<script type="text/javascript" src="<?=base_url();?>public/scripts/MasterController.js"></script>
	</head>
	
	<body ng-controller ="MasterController">
		<div class="divAlert">
			<alert style="display: block" ng-repeat="alert in alerts" type="danger" close="CloseAlert($index)">{{ShowAlert($index)}}</alert>
		</div>
		<div class="container">
			<!--  MENU  -->
			<div class="header">
				<ul class="nav nav-pills pull-right" role="tablist">
					<li role="presentation" class="active"><a
						href="./Narrow Jumbotron Template for Bootstrap_files/Narrow Jumbotron Template for Bootstrap.html">Home</a></li>
					<li role="presentation"><a
						href="./Narrow Jumbotron Template for Bootstrap_files/Narrow Jumbotron Template for Bootstrap.html">About</a></li>
					<li role="presentation"><a
						href="./Narrow Jumbotron Template for Bootstrap_files/Narrow Jumbotron Template for Bootstrap.html">Contact</a></li>
				</ul>
				<h3 class="text-muted">Project name</h3>
			</div>
			<!-- END OF MENU --> 