    <div id="map" style="width: 100%; height: 768px; position: relative;" class="leaflet-container leaflet-fade-anim" tabindex="0"></div>
    </body>

<script>

		var map = L.map('map').setView([11.3333,123.0167], 5);

		L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
		}).addTo(map);

        <?php foreach($event as $key => $value){ ?>
            L.marker([<?php echo $value['latitude'];?>, <?php echo $value['longitude'];?> ]).addTo(map)
                .bindPopup("<?php echo $value['event_name'];?>"+ "<br><small><a href='<?php echo $this->createUrl('event/view',array('id'=>$value['event_id']))?>'>view</a></small>");
        <?php } ?>


        
		var popup = L.popup();

		function onMapClick(e) {
//			popup
//				.setLatLng(e.latlng)
//				.setContent("You clicked the map at " + e.latlng.toString())
//				.openOn(map);
//            console.log(e.latlng.lat +" "+e.latlng.lng)
            L.marker([e.latlng.lat, e.latlng.lng]).addTo(map)
                .bindPopup('<form method="post" action="<?php echo $this->createUrl("event/add")?>" style="width:300px"><input type="text" name="name" class="form-control"> <br><textarea name="details" class="form-control"></textarea><br><input type="hidden" name="lat" value="'+e.latlng.lat+'"><input type="hidden" name="long" value="'+e.latlng.lng+'"><input type="submit" value="Save" class="btn btn-primary">')
                .openPopup();
		}

		map.on('click', onMapClick);

	</script>