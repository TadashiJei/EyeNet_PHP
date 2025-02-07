<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php _e('Dashboard'); ?></h1>
		<ol class="breadcrumb"><li><a href="?route=dashboard"><i class="fa fa-dashboard"></i> <?php _e('Home'); ?></a></li><li class="active"><?php _e('Dashboard'); ?></li></ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php if(!empty($statusmessage)): ?>
				<div class="row"><div class='col-md-12'><div class="alert alert-<?php print $statusmessage["type"]; ?> alert-dismissible" role="alert">
					<?php print __($statusmessage["message"]); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div></div></div>
		<?php endif; ?>

		<?php if(file_exists("install") == 1): ?>
			<div class="alert alert-danger">
				<?php _e('Please delete the "install" directory!'); ?>
			</div>
		<?php endif; ?>

		<!-- Stats Overview -->
		<div class="row stats-row">
			<div class="col-md-3 stat-box">
				<div class="stat-icon">
					<i class="fa fa-server"></i>
				</div>
				<div class="stat-count"><?php echo $servers_count; ?></div>
				<div class="stat-label"><?php _e('Servers'); ?></div>
				<a href="?route=servers" class="stat-link">View all →</a>
			</div>

			<div class="col-md-3 stat-box">
				<div class="stat-icon">
					<i class="fa fa-globe"></i>
				</div>
				<div class="stat-count"><?php echo $websites_count; ?></div>
				<div class="stat-label"><?php _e('Websites'); ?></div>
				<a href="?route=websites" class="stat-link">View all →</a>
			</div>

			<div class="col-md-3 stat-box">
				<div class="stat-icon">
					<i class="fa fa-check-circle"></i>
				</div>
				<div class="stat-count"><?php echo $checks_count; ?></div>
				<div class="stat-label"><?php _e('Checks'); ?></div>
				<a href="?route=checks" class="stat-link">View all →</a>
			</div>

			<div class="col-md-3 stat-box">
				<div class="stat-icon">
					<i class="fa fa-users"></i>
				</div>
				<div class="stat-count"><?php echo $contacts_count; ?></div>
				<div class="stat-label"><?php _e('Contacts'); ?></div>
				<a href="?route=alerting/contacts" class="stat-link">View all →</a>
			</div>
		</div>

		<?php if(!$isGoogleMaps) { ?>
			<div class="alert alert-info maps-alert">
				<?php _e('Add a Google Maps API key in System > Settings to display monitors status on map.'); ?>
			</div>
		<?php } ?>

		<div class="row">
			<div class="col-md-8">
				<div class="map-section">
					<div class="section-header">
						<h3><?php _e('Around the world'); ?></h3>
						<button class="collapse-btn">
							<i class="fa fa-minus"></i>
						</button>
					</div>
					<div class="section-body">
						<?php if(!$isGoogleMaps) { ?>
							<div id="world-map-markers" style="height: 450px;"></div>
						<?php } else { ?>
							<div id="googleMap" style="width:100%;height:450px;"></div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="overview-section">
					<div class="section-header">
						<h3><?php _e('Servers Overview'); ?></h3>
						<button class="collapse-btn">
							<i class="fa fa-minus"></i>
						</button>
					</div>
					<div class="section-body">
						<div class="status-box">
							<i class="fa fa-check-circle status-icon"></i>
							<div class="status-text">
								<p class="status-title"><?php _e("All Systems Operational") ?></p>
								<p class="status-desc"><?php _e("Hooray! All servers are healthy.") ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="overview-section">
					<div class="section-header">
						<h3><?php _e('Websites Overview'); ?></h3>
						<button class="collapse-btn">
							<i class="fa fa-minus"></i>
						</button>
					</div>
					<div class="section-body">
						<div class="status-box">
							<i class="fa fa-check-circle status-icon"></i>
							<div class="status-text">
								<p class="status-title"><?php _e("All Systems Operational") ?></p>
								<p class="status-desc"><?php _e("Hooray! All websites are healthy.") ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="overview-section">
					<div class="section-header">
						<h3><?php _e('Checks Overview'); ?></h3>
						<button class="collapse-btn">
							<i class="fa fa-minus"></i>
						</button>
					</div>
					<div class="section-body">
						<div class="status-box">
							<i class="fa fa-check-circle status-icon"></i>
							<div class="status-text">
								<p class="status-title"><?php _e("All Systems Operational") ?></p>
								<p class="status-desc"><?php _e("Hooray! All checks are healthy.") ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<style>
/* Alert Styles */
.alert {
    border: none;
    border-radius: 0;
    padding: 15px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #dc3545;
    color: white;
}

.maps-alert {
    background-color: #17a2b8;
    color: white;
}

/* Stats Row */
.stats-row {
    margin: 0 -10px 20px;
    display: flex;
    flex-wrap: wrap;
}

.stat-box {
    background: white;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
}

.stat-icon {
    color: #666;
    margin-bottom: 10px;
}

.stat-count {
    font-size: 24px;
    font-weight: 500;
    margin-bottom: 5px;
}

.stat-label {
    color: #666;
    margin-bottom: 5px;
}

.stat-link {
    color: #666;
    text-decoration: none;
}

/* Map and Overview Sections */
.map-section,
.overview-section {
    background: white;
    margin-bottom: 20px;
}

.section-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: normal;
}

.collapse-btn {
    background: none;
    border: none;
    color: #666;
    padding: 0;
}

.section-body {
    padding: 15px;
}

/* Status Box */
.status-box {
    display: flex;
    align-items: center;
    padding: 10px;
}

.status-icon {
    font-size: 20px;
    color: #28a745;
    margin-right: 15px;
}

.status-text {
    flex: 1;
}

.status-title {
    margin: 0;
    font-weight: 500;
}

.status-desc {
    margin: 5px 0 0;
    color: #666;
    font-size: 14px;
}
</style>

<?php if(!$isGoogleMaps) { ?>
	<script type="text/javascript">
		$(document).ready(function() {

			/* jVector Maps
		     * ------------
		     * Create a world map with markers
		     */
		    $('#world-map-markers').vectorMap({
		      	map              : 'world_mill_en',
		      	normalizeFunction: 'polynomial',
		      	hoverOpacity     : 0.7,
		      	hoverColor       : false,
		      	backgroundColor  : 'transparent',
		      	regionStyle      : {
			        initial      : {
			          	fill            : 'rgba(210, 214, 222, 1)',
			          	'fill-opacity'  : 1,
			          	stroke          : 'none',
			          	'stroke-width'  : 0,
			          	'stroke-opacity': 1
			        },
			        hover        : {
			          	'fill-opacity': 0.7,
			          	cursor        : 'pointer'
			        },
			        selected     : {
			          	fill: 'yellow'
			        },
			        selectedHover: {}
		        },
		      	markerStyle      : {
		        	initial: {
		          	fill  : '#00a65a',
		          	stroke: '#111'
		        	}
		      	},
				markers          : [
					<?php foreach($checks as $check) {
						$hasGeodata = false;
						if($check['lat'] != "" && $check['lng'] != "") $hasGeodata = true;

						if($hasGeodata) {

							$lat = $check['lat'];
							$lng = $check['lng'];

							if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
							if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

							if($check['status'] == 0) $fill = "#CCCCCC";
							if($check['status'] == 1) $fill = "#00a65a";
							if($check['status'] == 2) $fill = "#f39c12";
							if($check['status'] == 3) $fill = "#dd4b39";

							echo "{ latLng: [".$lat.", ".$lng."], name: '".__("Check: ") . $check['name']."', style: {fill: '".$fill."'} },";
						}

					}
					?>
					<?php foreach($servers as $server) {
						$hasGeodata = false;
						if($server['lat'] != "" && $server['lng'] != "") $hasGeodata = true;

						if($hasGeodata) {

							$lat = $server['lat'];
							$lng = $server['lng'];

							if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
							if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

							if($server['status'] == 0) $fill = "#CCCCCC";
							if($server['status'] == 1) $fill = "#00a65a";
							if($server['status'] == 2) $fill = "#f39c12";
							if($server['status'] == 3) $fill = "#dd4b39";

							echo "{ latLng: [".$lat.", ".$lng."], name: '".__("Server: ") . $server['name']."', style: {fill: '".$fill."'} },";
						}


					}
					?>
					<?php foreach($websites as $website) {
						$hasGeodata = false;
						if($website['lat'] != "" && $website['lng'] != "") $hasGeodata = true;

						if($hasGeodata) {

							$lat = $website['lat'];
							$lng = $website['lng'];

							if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
							if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

							if($website['status'] == 0) $fill = "#CCCCCC";
							if($website['status'] == 1) $fill = "#00a65a";
							if($website['status'] == 2) $fill = "#f39c12";
							if($website['status'] == 3) $fill = "#dd4b39";

							echo "{ latLng: [".$lat.", ".$lng."], name: '".__("Website: ") . $website['name']."', style: {fill: '".$fill."'} },";
						}


					}
					?>

				]
			});

		});
	</script>
<?php } ?>

<?php if($isGoogleMaps) { ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo getConfigValue("google_maps_api_key"); ?>"></script>
	<script type="text/javascript">
		var mlocations = [
			<?php foreach($checks as $check) {
				$hasGeodata = false;
				if($check['lat'] != "" && $check['lng'] != "") $hasGeodata = true;

				if($hasGeodata) {

					$lat = $check['lat'];
					$lng = $check['lng'];

					if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
					if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

					if($check['status'] == 0) $icon = "check-gray";
					if($check['status'] == 1) $icon = "check-green";
					if($check['status'] == 2) $icon = "check-orange";
					if($check['status'] == 3) $icon = "check-red";

					echo "['".__("Check: ") . $check['name']."', ".$lat.",".$lng.", 2, '".$icon."', '".__("Check: ") . $check['name']."'],";
				}

			}
			?>

			<?php foreach($servers as $server) {
				$hasGeodata = false;
				if($server['lat'] != "" && $server['lng'] != "") $hasGeodata = true;

				if($hasGeodata) {

					$lat = $server['lat'];
					$lng = $server['lng'];

					if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
					if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

					if($server['status'] == 0) $icon = "server-gray";
					if($server['status'] == 1) $icon = "server-green";
					if($server['status'] == 2) $icon = "server-orange";
					if($server['status'] == 3) $icon = "server-red";

					echo "['".__("Server: ") . $server['name']."', ".$lat.",".$lng.", 2, '".$icon."', '".__("Server: ") . $server['name']."'],";
				}


			}
			?>
			<?php foreach($websites as $website) {
				$hasGeodata = false;
				if($website['lat'] != "" && $website['lng'] != "") $hasGeodata = true;

				if($hasGeodata) {

					$lat = $website['lat'];
					$lng = $website['lng'];

					if(!is_decimal($lat)) $lat = $lat . "." . rand(1000,9999);
					if(!is_decimal($lng)) $lng = $lng . "." . rand(1000,9999);

					if($website['status'] == 0) $icon = "website-gray";
					if($website['status'] == 1) $icon = "website-green";
					if($website['status'] == 2) $icon = "website-orange";
					if($website['status'] == 3) $icon = "website-red";

					echo "['".__("Website: ") . $website['name']."', ".$lat.",".$lng.", 2, '".$icon."', '".__("Website: ") . $website['name']."'],";
					//echo "{ latLng: [".$lat.", ".$lng."], name: '".__("Website: ") . $website['name']."', style: {fill: '".$fill."'} },";
				}


			}
			?>
		];

		var mapCenter = new google.maps.LatLng(0, 0);
		var bounds = new google.maps.LatLngBounds();

		function initialize() {
			var mapData = {
				center:mapCenter,
				zoom:2,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			};

			var map = new google.maps.Map(document.getElementById("googleMap"),mapData);

			for (i = 0; i < mlocations.length; i++) {
				var infowindow = new google.maps.InfoWindow({
					content: mlocations[i][5]
				});

				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(mlocations[i][1], mlocations[i][2]),
					map: map,
					title: mlocations[i][0],
					icon:'template/images/'+mlocations[i][4]+'.png',
					infowindow: infowindow
				});
				bounds.extend(marker.position);

				marker.addListener('click', function() {
					this.infowindow.open(map, this);
				});


				marker.setMap(map);
			}

			map.fitBounds(bounds);

		}

		google.maps.event.addDomListener(window, 'load', initialize);



	</script>
<?php } ?>
