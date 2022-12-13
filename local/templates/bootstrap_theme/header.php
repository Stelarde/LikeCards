<?php 
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); 
use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();

$asset->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.css');
$asset->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.min.css');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php $APPLICATION->ShowTitle(); ?></title>
	<?php $APPLICATION->ShowHead(); ?>
</head>
<body>
	<main>
	<?php $APPLICATION->ShowPanel(); ?>

	<div class="container col-xxl-8 px-4 py-5">
		<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
			<div class="col-10 col-sm-8 col-lg-6">
				<!-- <img src="/images/bootstrap-themes.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy"> -->
				<video width="700" height="500" controls="controls" poster="/images/bootstrap-themes.png"></video>
			</div>
			<div class="col-lg-6">
				<h1 class="display-6 fw-bold pb-2">Centered hero</h1>
				<p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
				<div class="d-grid gap-2 d-md-flex justify-content-md-start">
					<button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary button</button>
					<button type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</button>
				</div>
			</div>
		</div>
	</div>
