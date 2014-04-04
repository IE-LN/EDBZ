<?php
require_once '../../../../wp-load.php';
$address_map = $_REQUEST['add'];
$event_loc_lat = $_REQUEST['lat'];
$event_loc_long = $_REQUEST['long'];
$event_loc_zoom = $_REQUEST['zoom'];
$post_id = $_REQUEST['post_id'];
?>
<div id="map<?php echo $post_id;?>" style="height:182px; width:100%; float:left;"></div>
<script type="text/javascript">
	var styles = [
    {
      stylers: [
        { hue: "#000000" },
        { saturation: -100 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: -40 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "on" }
      ]
    }
  ];
    var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});
	var locationsw = [
	['<?php echo $address_map;?>', '<?php echo $event_loc_lat;?>', '<?php echo $event_loc_long;?>', '<?php echo $event_loc_zoom;?>'],
	];
	var mapw = new google.maps.Map(document.getElementById('map<?php echo $post_id;?>'), {
		zoom: <?php echo $event_loc_zoom;?>,
		disableDefaultUI: true,
		backgroundColor: '#000',
		center: new google.maps.LatLng(<?php echo $event_loc_lat;?>, <?php echo $event_loc_long;?>),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	var myOptions = {
		autoScroll: false,
		strokeColor: '#000000',
		backgroundColor: '#000',
		mapTypeControlOptions: {
		  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
		},
		boxStyle: {
			opacity: 0.75,
			width: "280px"
		}
	};
	var infowindow = new google.maps.InfoWindow(myOptions);
	var i,marker;
	for (i = 0; i < locationsw.length; i++) {
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(locationsw[i][1], locationsw[i][2]),
			map: mapw,
			borderRadius: 20,
			animation: google.maps.Animation.DROP
		});
		google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
			return function() {
				infowindow.setContent(locationsw[i][0]);
				infowindow.open(mapw, marker);
			}
		})(marker, i));
	}
	 mapw.mapTypes.set('map_style', styledMap);
  	mapw.setMapTypeId('map_style');
</script>

  <!-- Open Map End --> 