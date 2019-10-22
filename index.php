<?php
	include "inc.db.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Hydrantenerfassung</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<!-- leaflet CSS -->
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>

		<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0; 
			}
			#map { 
				height: 100%; 
				width: 100vw; 
			}
		</style>
	</head>
	<body>
<?php
	if(isset($_REQUEST['gesendet']))
	{
		if(empty($_REQUEST['lat']))
		{
			$fehler['lat']="Bitte erst GPS lesen";
		}
		if(empty($_REQUEST['lon']))
		{
			$fehler['lon']="Bitte erst GPS lesen";
		}

		$lat = $_REQUEST['lat'];
		$lon = $_REQUEST['lon'];
		$groesse = $_REQUEST['groesse'];
		$bemerkung = $_REQUEST['bemerkung'];

		if(empty($fehler))
		{
			$statement = $pdo->prepare("INSERT INTO hydranten (lat, lon, groesse, bemerkung) VALUES (:lat, :lon, :groesse, :bemerkung)");
			$statement->execute(array('lat' => $lat,'lon' => $lon,'groesse' => $groesse,'bemerkung' => $bemerkung));   
			mail("hydrantenpflege@sebastian-schreiner.de","Neuer Hydrant eingetragen","Es wurde soeben ein neuer Hydrant hinzugefügt.\n\n".$lat.":".$lon."\nGröße: ".$groesse."\nBemerkung: ".$bemerkung);
		}
	}
?>
		<div id='map'></div>
		<!-- Optional JavaScript -->
		<script>
			var map = L.map('map').setView([49.2592, 8.12264], 13);

			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				id: 'mapbox.streets'
			}).addTo(map);

			function onLocationFound(e) 
			{
				var radius = e.accuracy / 2;
				var LatLonArray;
				L.marker(e.latlng)
					.addTo(map)
					.bindPopup("<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#saveModal\">Position &uuml;bernehmen</button>").openPopup();
				L.circle(e.latlng, radius).addTo(map);

				document.getElementById("lat").value=e.latlng.lat;
				document.getElementById("lon").value=e.latlng.lng;
				
			}

			function onLocationError(e) 
			{
				alert(e.message);
			}

			map.on('locationfound', onLocationFound);
			map.on('locationerror', onLocationError);

			map.locate({setView: true, maxZoom: 16});
		</script>

		<!-- Modal -->
		<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<input type="hidden" name="gesendet" id="gesendet" value="1">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Hydrant speichern</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="lat">Latitude</label>
							<input type="text" class="form-control" name="lat" id="lat">
						</div>
						<div class="form-group">
							<label for="lon">Longitude</label>
							<input type="text" class="form-control" name="lon" id="lon">
						</div>
						<div class="form-group">
							<label for="groesse">Gr&ouml;&szlig;e</label>
							<input type="text" class="form-control" name="groesse" id="groesse">
						</div>
						<div class="form-group">
							<label for="bemerkung">Bemerkung</label>
							<input type="text" class="form-control" name="bemerkung" id="bemerkung">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">abbrechne</button>
						<input type="submit" value="speichern" class="btn btn-primary">
					</div>
					</form>
				</div>
			</div>
		</div>
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>		
	</body>
</html>
