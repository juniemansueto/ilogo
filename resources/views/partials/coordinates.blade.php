<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>

<script type="application/javascript">
    function initMap() {
        @forelse($dataTypeContent->getCoordinates() as $point)
            var center = {lat: {{ $point['lat'] }}, lng: {{ $point['lng'] }}};
        @empty
            var center = {lat: {{ config('logoinc.googlemaps.center.lat') }}, lng: {{ config('logoinc.googlemaps.center.lng') }}};
        @endforelse
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: {{ config('logoinc.googlemaps.zoom') }},
            center: center
        });
        var markers = [];
        @foreach($dataTypeContent->getCoordinates() as $point)
            var marker = new google.maps.Marker({
                    position: {lat: {{ $point['lat'] }}, lng: {{ $point['lng'] }}},
                    map: map
                });
            markers.push(marker);
        @endforeach
    }
</script>
<div id="map"/>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('logoinc.googlemaps.key') }}&callback=initMap"></script>