<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lokasi - OpenStreetMap</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        #map { height: 400px; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">🗺 Pilih Lokasi</h2>

        <div class="relative w-full mb-4">
            <input type="text" id="search-box" placeholder="🔍 Cari lokasi..."
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            <div id="search-results" class="absolute left-0 right-0 mt-1 bg-white border rounded-lg shadow-lg z-10 hidden"></div>
        </div>

        <form method="POST" action="{{ route('locations.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-gray-600 font-medium">Nama Lokasi</label>
                <input type="text" id="location-name" name="name" required
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-600 font-medium">Latitude</label>
                    <input type="text" id="latitude" name="latitude" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100 outline-none">
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Longitude</label>
                    <input type="text" id="longitude" name="longitude" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100 outline-none">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                ✅ Simpan Lokasi
            </button>
        </form>
    </div>

    <div id="map" class="w-full max-w-lg mt-6"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([-6.200, 106.816], 13); // Default Jakarta
        var marker = L.marker([-6.200, 106.816], { draggable: true }).addTo(map);

        // Load tile dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Coba dapatkan lokasi pengguna
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;

                var userLocation = [userLat, userLng];
                map.setView(userLocation, 15);
                marker.setLatLng(userLocation);

                document.getElementById('latitude').value = userLat;
                document.getElementById('longitude').value = userLng;
            }, function (error) {
                console.log("Gagal mendapatkan lokasi: ", error.message);
            });
        } else {
            console.log("Geolocation tidak didukung di browser ini.");
        }

        // Event marker drag
        marker.on('dragend', function () {
            var latlng = marker.getLatLng();
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        });

        // Event klik peta
        map.on('click', function (e) {
            var latlng = e.latlng;
            marker.setLatLng(latlng);
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        });

        // Event pencarian lokasi
        document.getElementById('search-box').addEventListener('input', function () {
            var query = this.value;
            if (query.length < 3) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(response => response.json())
                .then(data => {
                    var resultsDiv = document.getElementById('search-results');
                    resultsDiv.innerHTML = '';
                    resultsDiv.classList.remove('hidden');

                    data.forEach(place => {
                        var item = document.createElement('div');
                        item.className = 'p-2 hover:bg-gray-200 cursor-pointer';
                        item.textContent = place.display_name;
                        item.onclick = function () {
                            document.getElementById('search-box').value = place.display_name;
                            document.getElementById('location-name').value = place.display_name;
                            document.getElementById('latitude').value = place.lat;
                            document.getElementById('longitude').value = place.lon;

                            var newLatLng = new L.LatLng(place.lat, place.lon);
                            marker.setLatLng(newLatLng);
                            map.setView(newLatLng, 15);

                            resultsDiv.innerHTML = '';
                            resultsDiv.classList.add('hidden');
                        };
                        resultsDiv.appendChild(item);
                    });
                });
        });

        // Klik di luar dropdown untuk menutup hasil pencarian
        document.addEventListener('click', function (event) {
            var resultsDiv = document.getElementById('search-results');
            if (!document.getElementById('search-box').contains(event.target)) {
                resultsDiv.innerHTML = '';
                resultsDiv.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
