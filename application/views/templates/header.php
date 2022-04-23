<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<!-- Leaflet -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
	<script defer src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
	<script defer src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	<script defer src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
	<script defer src="https://unpkg.com/leaflet.markercluster.layersupport@2.0.1/dist/leaflet.markercluster.layersupport.js"></script>
	<script defer src="http://aratcliffe.github.io/Leaflet.contextmenu/dist/leaflet.contextmenu.js"></script>
	<script  src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
	<link rel="stylesheet" href="http://aratcliffe.github.io/Leaflet.contextmenu/dist/leaflet.contextmenu.css"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
	<!-- stylesheet perso -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
	<script defer src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script defer src="<?php echo base_url('assets/js/map_display.js') ?>"></script>
	
</head>

	