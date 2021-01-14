$(document).ready(function(){
	var revapi;
	jQuery(document).ready(function() {
	      revapi = jQuery('.tp-banner').revolution(
	        {
	            delay:9000,
	            startwidth:1170,
	            startheight:500,
	            hideThumbs:10,
	            fullWidth:"on",
	            fullScreen:"on",
	            fullScreenOffsetContainer: ""
	        });

	      $('.subMenu').smint({
	          'scrollSpeed' : 1000
	      });
	});


	var facebook_0 = $("span.facebook_0").text() ;
	$("a#facebook_0").attr("href",facebook_0) ;

	if ( $('#mapContainer').length ){
	    var $lat = $('#mapContainer').data('lat');
	    var $lon = $('#mapContainer').data('lon');
	    var $zoom = $('#mapContainer').data('zoom');
	    var $marker = $('#mapContainer').data('marker');
	    var $site_name = $('#mapContainer').data('site_name');
	    var $markerLat = $('#mapContainer').data('mlat');
	    var $markerLon = $('#mapContainer').data('mlon');
	    var map = new GMaps({
	        el: '#mapContainer',
	        lat: $lat,
	        lng: $lon,
	        scrollwheel: false,
	        scaleControl: true,
	        streetViewControl: false,
	        panControl: true,
	        disableDoubleClickZoom: true,
	        mapTypeControl: false,
	        zoom: $zoom,
	        
	    });

	    map.addMarker({
	        lat: $markerLat,
	        lng: $markerLon,
	        icon : $marker ,
	        title: $site_name,
	    });
	}
}) ;