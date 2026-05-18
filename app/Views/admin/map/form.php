<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<div class="mb-6">
    <a href="<?= base_url('admin/map') ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar
    </a>
    <h2 class="text-2xl font-bold text-gray-800"><?= $location->id ? 'Edit Lokasi' : 'Tambah Lokasi Baru' ?></h2>
    <p class="text-sm text-gray-500 mt-1">Klik peta atau drag marker untuk menentukan koordinat secara akurat</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <!-- Form Panel -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider mb-5">Informasi Lokasi</h3>

        <form action="<?= base_url('admin/map/save') ?>" method="POST" class="space-y-5">
            <input type="hidden" name="id" value="<?= $location->id ?>">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?= esc($location->name) ?>" required
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-2.5 outline-none transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-2.5 outline-none transition text-sm resize-none"><?= esc($location->description) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Latitude <span class="text-red-500">*</span></label>
                    <input type="text" id="latInput" name="latitude" value="<?= esc($location->latitude) ?>" required
                        class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-3 py-2.5 outline-none transition text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Longitude <span class="text-red-500">*</span></label>
                    <input type="text" id="lngInput" name="longitude" value="<?= esc($location->longitude) ?>" required
                        class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-3 py-2.5 outline-none transition text-xs font-mono">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Media Terlampir</label>
                <select name="media_type"
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-2.5 outline-none transition text-sm mb-3">
                    <option value="none" <?= $location->media_type == 'none' ? 'selected' : '' ?>>— Tanpa Media</option>
                    <option value="photo" <?= $location->media_type == 'photo' ? 'selected' : '' ?>>📷 Foto (.webp)</option>
                    <option value="drone_video" <?= $location->media_type == 'drone_video' ? 'selected' : '' ?>>🎬 Video Drone (.mp4)</option>
                </select>
                <input type="text" name="media_url" value="<?= esc($location->media_url) ?>"
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-2.5 outline-none transition text-sm"
                    placeholder="Paste URL dari File Manager…">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/25 transition">
                Simpan Lokasi
            </button>
        </form>
    </div>

    <!-- Map Panel -->
    <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div id="map" class="w-full" style="height: 560px;"></div>
    </div>
</div>

<script>
    let currentLat = <?= $location->latitude ?: '-3.791552' ?>;
    let currentLng = <?= $location->longitude ?: '102.261895' ?>;

    const map = L.map('map').setView([currentLat, currentLng], 15);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri', maxZoom: 18
    }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO', maxZoom: 18
    }).addTo(map);

    const marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    const latInput = document.getElementById('latInput');
    const lngInput = document.getElementById('lngInput');

    function updateInputs(latlng) {
        latInput.value = latlng.lat.toFixed(8);
        lngInput.value = latlng.lng.toFixed(8);
    }

    marker.on('dragend', () => updateInputs(marker.getLatLng()));
    map.on('click', (e) => { marker.setLatLng(e.latlng); updateInputs(e.latlng); });

    function updateMarker() {
        const lat = parseFloat(latInput.value), lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.panTo([lat, lng]);
        }
    }
    latInput.addEventListener('input', updateMarker);
    lngInput.addEventListener('input', updateMarker);

    L.Control.geocoder({ defaultMarkGeocode: false, placeholder: 'Cari lokasi…' })
        .on('markgeocode', e => {
            map.fitBounds(e.geocode.bbox);
            marker.setLatLng(e.geocode.center);
            updateInputs(e.geocode.center);
        }).addTo(map);
</script>

<?= $this->endSection() ?>
