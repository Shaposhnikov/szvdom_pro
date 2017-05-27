function initialize() {

	var mapProp = {
		center:new google.maps.LatLng(59.896110, 30.357950),
		zoom:16,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};

	var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
	
	var office=new google.maps.LatLng(59.896110, 30.357950);
	
	var image = {
		url: '/bitrix/templates/szvdom/images/mark.png',
		size: new google.maps.Size(94, 67),
		origin: new google.maps.Point(0,0),
		anchor: new google.maps.Point(45, 67)
	};
	
	var marker=new google.maps.Marker({
		position:office,
		icon: image
	});

	marker.setMap(map);
 
}

google.maps.event.addDomListener(window, 'load', initialize);