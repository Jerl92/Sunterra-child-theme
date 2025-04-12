  function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 46.829853, lng: -71.254028},
        zoom: 13,
        mapTypeControl: false
      });
      var input = document.getElementById('searchInput');
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      var infowindow = new google.maps.InfoWindow();
      var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
      });

      autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
              window.alert("Autocomplete's returned place contains no geometry");
              return;
          }
    
          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
          } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);
          }
          marker.setIcon(({
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
      
          var address = '';
          if (place.address_components) {
              address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
              ].join(' ');
          }
      
          //infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          //infowindow.open(map, marker);
        
          //Location details

        if(place.formatted_address.indexOf(place.name) != -1){
            var place_address_ = place.formatted_address;
        } else {
            var place_address_ = place.name + '\n' + place.formatted_address;
        }

        var myDiVElem = document.getElementById("ns-ticket-return-adresse");
        myDiVElem.value = place_address_;

      });
  }