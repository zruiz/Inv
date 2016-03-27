function GoogleGeocode() {
  geocoder = new google.maps.Geocoder();
  this.geocode = function(address, callbackFunction) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var result = {};
          result.latitude = results[0].geometry.location.lat();
          result.longitude = results[0].geometry.location.lng();
          callbackFunction(result);
        } else {
          //alert("Geocode was not successful for the following reason: " + status);
          callbackFunction(null);
        }
      });
  };
}
var $lat, $long, $this_area, address;
jQuery(".view-distance").live('click',function(){
	//alert("sainath");
	$this_area = jQuery(this).find("a").attr("id");
	jQuery(this).find(".get-distance").show();
	jQuery(this).find(".search-dist").show();
		$lat = jQuery(this).find(".car-lat").text();
		$long = jQuery(this).find(".car-long").text();
		address = jQuery(this).find(".get-distance").val();
		//alert($lat);
var g = new GoogleGeocode();
      
	  var km;
      g.geocode(address, function(data) {
		  //alert($lat);
        if(data != null) {
          olat = data.latitude;
          olng = data.longitude;
		  //alert(olat);
			km = getDistanceFromLatLonInKm(olat,olng,$lat,$long,searches.measure);
		jQuery("#"+$this_area).empty();
		jQuery("#"+$this_area).append(Math.floor(km)+" "+searches.measure+" away");
		jQuery(this).find(".get-distance").hide();
	jQuery(this).find(".search-dist").hide();
        } else {
          //Unable to geocode
          //alert('ERROR! Unable to geocode address');
        }
	  });
	  return false;
	  });
jQuery(".search-icon-boxed").click(function(){
	var $id;
	var $lat;
	var $long;
	var result = {};
	jQuery(".user-location").each(function(index, element) {
        $id = jQuery(this).find(".user-id").text();
		$lat = jQuery(this).find(".lat").text();
		$long = jQuery(this).find(".long").text();
		result[$id]=($lat+"|"+$long || "");
    });
	
var g = new GoogleGeocode();
      var address = jQuery("#search-add").val();
 
      g.geocode(address, function(data) {
        if(data != null) {
          olat = data.latitude;
          olng = data.longitude;
		  var arrs = {};
 		jQuery.each( result, function(index, value) {
			var arr = value.split('|');
			var km = getDistanceFromLatLonInKm(olat,olng,arr[0],arr[1],searches.measure);
			arrs[km]=(index);
		   //alert('element at index ' + index + ' is ' + value);
		});
		jQuery.each(arrs, function(index, value) {
			//alert('element at index ' + index + ' is ' + value);
		});
		jQuery("#dealer-search-load").show();
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_dealers',
                values: arrs,
				//paginate: $page_val,
            },
            success: function(data) {
				//alert(data);
				jQuery("#dealer-search-load").hide();
				jQuery("#dealer-search-result").empty();
				jQuery("#dealer-search-result").html(data);
				jQuery('#dealer-search-result').focus();
            },
            error: function(errorThrown) {
            }
        });
          //alert(olat +"-"+ olng)
		  //alert($lat);
 		//alert(getDistanceFromLatLonInKm(olat,olng,$lat,$long));
        } else {
          //Unable to geocode
          //alert('ERROR! Unable to geocode address');
        }
	  });
	  });
function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2,units) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  var miles = d / 1.609344; 
  if ( units == 'km' ) {  
	return d; 
	 } else {
	return miles; }
	  //return d;
}
//alert(getDistanceFromLatLonInKm(28.419423,77.36689649999994,28.3899664,77.29797819999999));
function deg2rad(deg) {
  return deg * (Math.PI/180)
}