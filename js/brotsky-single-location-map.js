$ = jQuery;

var map;
function initBrotskyMap() {
    
    var mapElement = $("#brotsky-map");
    
    var locationLatLng = {lat: $(mapElement).data("lat"), lng: $(mapElement).data("lng")};
    
    map = new google.maps.Map(document.getElementById('brotsky-map'), {
      center: locationLatLng,
      zoom: 14
    });
    
    var marker = new google.maps.Marker({
        position: locationLatLng,
        map: map,
    });
}

$(document).ready(function(){
    initBrotskyMap();
});
