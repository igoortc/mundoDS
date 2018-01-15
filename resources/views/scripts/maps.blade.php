<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaxZQ5aXz07xuSCLHlLAl8Jnbx5m-7wdU&language=en&libraries=places"></script>
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