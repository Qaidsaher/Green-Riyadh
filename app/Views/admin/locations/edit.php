<?php
$active = 'admin.locations';
$title = 'تعديل موقع - لوحة الإدارة';
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$location = \App\Models\Location::find($id);
if (!$location) {
    echo "<p class='text-red-600 text-center'>الموقع غير موجود.</p>";
    exit;
}
$authorities = \App\Models\Authority::all();

?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل بيانات الموقع</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
   
    ?>

    <form action="<?= route('admin.locations.update', ['id' => $location->id]); ?>" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Location Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">اسم الموقع</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($location->name); ?>" required
                class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
        </div>

        <!-- Coordinates Input (Read-Only) -->
        <div>
            <label for="coordinates" class="block text-sm font-medium text-gray-700">الإحداثيات</label>
            <input type="text" id="coordinates" name="coordinates" value="<?= htmlspecialchars($location->coordinates); ?>"
                class="mt-1 w-full p-2 border border-gray-300 rounded bg-gray-100 focus:outline-none" readonly>
        </div>

        <!-- Description -->
        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
            <textarea id="description" name="description"
                class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"><?= htmlspecialchars($location->description); ?></textarea>
        </div>

        <!-- Status Dropdown -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
            <select id="status" name="status" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
                <option value="active" <?= $location->status == 'active' ? 'selected' : ''; ?>>نشط</option>
                <option value="inactive" <?= $location->status == 'inactive' ? 'selected' : ''; ?>>غير نشط</option>
                <option value="pending" <?= $location->status == 'pending' ? 'selected' : ''; ?>>قيد الانتظار</option>
            </select>
        </div>

       
        <!-- Authority Dropdown (Newly Updated) -->
        <div>
            <label for="authorityId" class="block text-sm font-medium text-gray-700 ">الجهة</label>
            <select id="authorityId" name="authorityId" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
                <option value="">-- اختر الجهة --</option>
                <?php if (!empty($authorities)): ?>
                    <?php foreach ($authorities as $auth): ?>
                        <option value="<?= htmlspecialchars($auth->id); ?>"
                            <?= (isset($location) && $location->authorityId == $auth->id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($auth->name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">لا توجد جهات متوفرة</option>
                <?php endif; ?>
            </select>
        </div>


        <!-- Map Section (Displayed Inside the Form) -->
        <div class="col-span-2">
            <label for="map" class="block text-sm font-medium text-gray-700 mb-3">حدد الموقع على الخريطة</label>
            <div id="map" class="w-full h-96 border border-gray-300 rounded-lg shadow-md"></div>
        </div>

        <!-- Submit Button -->
        <div class="col-span-2 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
                تحديث
            </button>
        </div>
    </form>
</div>

<!-- Include Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    let map;
    let marker;
    let selectedCoordinates = "<?= htmlspecialchars($location->coordinates); ?>"; // Default coordinates

    function initializeMap() {
        if (!map) {
            map = L.map("map").setView([24.7136, 46.6753], 13); // Default to Riyadh

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // If coordinates exist, place the marker
            if (selectedCoordinates) {
                const [lat, lng] = selectedCoordinates.split(',').map(Number);
                marker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 13);
            }

            // Event to place a new marker when clicking on the map
            map.on("click", function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById("coordinates").value = e.latlng.lat.toFixed(4) + "," + e.latlng.lng.toFixed(4);
            });
        }

        // Ensure the map resizes properly
        setTimeout(() => {
            map.invalidateSize();
        }, 500);
    }

    // Load the map when the page loads
    document.addEventListener("DOMContentLoaded", initializeMap);
</script>


<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
