<style>
    #map{ 
        height: 180px;
    }
</style>

<div id="map"></div>
<script>
    var lokasi = "{{ $presensi->lokasi_in }}";
    var lok = lokasi.split(",");
    var latitude = lok[0];
    var longitude = lok[1];
    var map = L.map('map').setView([latitude, longitude], 18);
    var marker = L.marker([latitude, longitude]).addTo(map);
    var circle = L.circle([-6.904601096406407, 107.58408868052425], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 85
}).addTo(map);
var popup = L.popup()
    .setLatLng([latitude, longitude])
    .setContent("{{ $presensi->nama_lengkap }}")
    .openOn(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
</script>