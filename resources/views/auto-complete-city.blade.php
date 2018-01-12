<!DOCTYPE html>
<html>
<head>
	<title>User list - PDF</title>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe1exctmeJjIb4guyT6newSpyJ7kA3aLc&libraries=places"></script>
</head>
<body>
<div class="container">
	<form>
		<div class="form-group">
            <label>City<star>*</star></label>
            <input type="text" name="city" placeholder="City" class="form-control" value="{{ old('city') }}" id="city">
        </div>
	</form>
	<script type="text/javascript">
		function initialize() {
		    var options = {
		        types: ['(cities)']
		    };
		    var input = document.getElementById('city');
		    var autocomplete = new google.maps.places.Autocomplete(input, options);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</div>
</body>
</html>