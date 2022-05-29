<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Viasat-Connect-E5</title>
	<!-- Leaflet -->
	
	<link rel="stylesheet" href="<?php echo base_url('assets/js/leaflet/leaflet.css') ?>"> <!-- E5 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/js/leaflet/plugins/leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.css') ?>" /> <!-- E5 -->
	<script defer src="<?php echo base_url('assets/js/leaflet/leaflet.js') ?>"></script>

	<script defer src="<?php echo base_url('assets/js/leaflet/plugins/leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.js') ?>"></script>
	<script defer src="<?php echo base_url('assets/js/leaflet/plugins/Leaflet.markercluster-master/dist/leaflet.markercluster.js') ?>"></script>
	<script defer src="<?php echo base_url('assets/js/leaflet/plugins/Leaflet.markercluster-master/dist/leaflet.markercluster.layersupport.js') ?>"></script>
	
	<script defer src="<?php echo base_url('assets/js/leaflet/plugins/leaflet.contextmenu.js') ?>"></script>
	<script  src='<?php echo base_url('assets/js/leaflet/plugins/turf.min.js') ?>'></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/js/leaflet/plugins/leaflet.contextmenu.css') ?>"/>

	<link rel="stylesheet" href="<?php echo base_url('assets/js/leaflet/plugins/Leaflet.markercluster-master/dist/MarkerCluster.css') ?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/js/leaflet/plugins/Leaflet.markercluster-master/dist/MarkerCluster.Default.css') ?>" />



	<!-- stylesheet perso -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
	<!-- <script defer src="https://code.jquery.com/jquery-2.0.3.min.js"></script> -->
	<script defer src="<?php echo base_url('assets/js/jquery-2.0.3.min.js') ?>"></script> <!-- E5 -->
	<script defer src="<?php echo base_url('assets/js/map_display.js') ?>"></script>
	
</head>

	