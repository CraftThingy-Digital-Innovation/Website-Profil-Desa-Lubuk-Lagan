<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi - Desa Lubuk Lagan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>
<body class="bg-gray-100 p-8 font-sans">

<div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-6">
    <!-- Form Area -->
    <div class="w-full md:w-1/3 bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Informasi Lokasi</h1>
        
        <form action="<?= base_url('admin/map/save') ?>" method="POST">
            <input type="hidden" name="id" value="<?= $location->id ?>">
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Lokasi</label>
                <input type="text" name="name" class="w-full border p-2 rounded focus:ring" value="<?= htmlspecialchars($location->name) ?>" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Singkat</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded focus:ring"><?= htmlspecialchars($location->description) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Latitude</label>
                    <input type="text" id="latInput" name="latitude" class="w-full border p-2 rounded focus:ring text-sm" value="<?= htmlspecialchars($location->latitude) ?>" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Longitude</label>
                    <input type="text" id="lngInput" name="longitude" class="w-full border p-2 rounded focus:ring text-sm" value="<?= htmlspecialchars($location->longitude) ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Media Terlampir</label>
                <select name="media_type" class="w-full border p-2 rounded focus:ring mb-2">
                    <option value="none" <?= $location->media_type == 'none' ? 'selected' : '' ?>>Tanpa Media</option>
                    <option value="photo" <?= $location->media_type == 'photo' ? 'selected' : '' ?>>Foto (.webp/.jpg)</option>
                    <option value="drone_video" <?= $location->media_type == 'drone_video' ? 'selected' : '' ?>>Video Drone (.mp4)</option>
                </select>
                <input type="text" name="media_url" class="w-full border p-2 rounded focus:ring text-sm" placeholder="Paste link dari File Manager..." value="<?= htmlspecialchars($location->media_url) ?>">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                Simpan Lokasi
            </button>
            <a href="<?= base_url('admin/map') ?>" class="block text-center mt-3 text-gray-500 hover:text-gray-700 text-sm">Batal & Kembali</a>
        </form>
    </div>

    <!-- Map Area -->
    <div class="w-full md:w-2/3 bg-white rounded-xl shadow-lg p-6 relative">
        <h2 class="font-bold text-gray-800 mb-2">Peta Interaktif (Satelit)</h2>
        <p class="text-xs text-gray-500 mb-4">Gunakan search bar atau klik & drag marker merah untuk menentukan koordinat secara akurat.</p>
        
        <div id="map" class="w-full rounded-lg border-2 border-gray-300" style="height: 600px; z-index: 10;"></div>
    </div>
</div>

<script>
    // Inisialisasi Koordinat (Gunakan nilai dari database atau default)
    let currentLat = <?= $location->latitude ? $location->latitude : '-3.791552' ?>;
    let currentLng = <?= $location->longitude ? $location->longitude : '102.261895' ?>;

    // Inisialisasi Peta
    const map = L.map('map').setView([currentLat, currentLng], 15);

    // Memuat layer Satelit (Esri World Imagery yang gratis dan open untuk penggunaan dasar)
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EAP, and the GIS User Community',
        maxZoom: 18
    }).addTo(map);

    // Tambahkan layer jalan (Street/Labels) agar satelit lebih informatif
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        maxZoom: 18
    }).addTo(map);

    // Marker Draggable
    const marker = L.marker([currentLat, currentLng], {
        draggable: true
    }).addTo(map);

    // Elemen Input
    const latInput = document.getElementById('latInput');
    const lngInput = document.getElementById('lngInput');

    // Fungsi Update Input dari Marker
    function updateInputs(latlng) {
        latInput.value = latlng.lat.toFixed(8);
        lngInput.value = latlng.lng.toFixed(8);
    }

    // Event saat marker di-drag
    marker.on('dragend', function (e) {
        updateInputs(marker.getLatLng());
    });

    // Event saat peta diklik (pindahkan marker ke titik klik)
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng);
    });

    // Event saat user mengetik koordinat manual di input box
    function updateMarkerFromInput() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.panTo(newLatLng);
        }
    }

    latInput.addEventListener('input', updateMarkerFromInput);
    lngInput.addEventListener('input', updateMarkerFromInput);

    // Tambahkan Search Bar Geocoder (Nominatim OpenStreetMap)
    const geocoder = L.Control.geocoder({
        defaultMarkGeocode: false,
        placeholder: "Cari lokasi di peta..."
    }).on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const center = e.geocode.center;
        
        // Pindahkan view peta ke hasil pencarian
        map.fitBounds(bbox);
        
        // Pindahkan marker
        marker.setLatLng(center);
        updateInputs(center);
    }).addTo(map);
</script>
</body>
</html>
