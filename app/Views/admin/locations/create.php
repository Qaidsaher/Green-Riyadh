<?php
$active = 'admin.locations';
$title = 'إضافة موقع - لوحة الإدارة';
ob_start();

// Retrieve all authorities for the dropdown
$authorities = \App\Models\Authority::all();
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">إضافة موقع جديد</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
   
    ?>
    <form action="<?= route('admin.locations.store'); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Title Input -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">اسم الموقع</label>
                <input type="text" id="name" name="name" required placeholder="أدخل اسم الموقع" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
            </div>

            <!-- Coordinates Input -->
            <div>
                <label for="coordinates" class="block text-sm font-medium text-gray-700">الإحداثيات</label>
                <input type="text" id="coordinates" name="coordinates" placeholder="مثلاً: 40.7128,-74.0060" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600" readonly>
            </div>

            <!-- Description Input -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                <textarea id="description" name="description" placeholder="أدخل وصف الموقع" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
            </div>

            <!-- Status Dropdown -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
                <select id="status" name="status" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
                    <option value="active">نشط</option>
                    <option value="inactive">غير نشط</option>
                    <option value="pending">قيد الانتظار</option>
                </select>
            </div>

            <!-- Authority Dropdown -->
            <div>
                <label for="authorityId" class="block text-sm font-medium text-gray-700">الجهة</label>
                <select id="authorityId" name="authorityId" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
                    <option value="">-- اختر الجهة --</option>
                    <?php if (!empty($authorities)): ?>
                        <?php foreach ($authorities as $auth): ?>
                            <option value="<?= htmlspecialchars($auth->id); ?>"><?= htmlspecialchars($auth->name); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">لا توجد جهات متوفرة</option>
                    <?php endif; ?>
                </select>
            </div>



            <!-- Map for Location Selection -->
            <div class="col-span-2">
                <label for="coordinates" class="block text-sm font-medium text-gray-700">حدد الموقع على الخريطة</label>
                <div id="map" class="w-full h-96 sm:h-64 md:h-80 lg:h-96 xl:h-[500px]"></div>
            </div>

            <div class="flex justify-end col-span-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
                    حفظ
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function initializeMap() {

        // Initialize the map with a default location (Riyadh)
        var map = L.map('map').setView([24.7136, 46.6753], 13); // Coordinates of Riyadh

        // Add the tile layer (you can use different tile providers)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        // Set an event listener to add a marker when the user clicks on the map
        map.on('click', function(e) {
            // Remove any existing marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Add a new marker where the user clicked
            marker = L.marker(e.latlng).addTo(map);

            // Update the coordinates input with the selected location
            document.getElementById('coordinates').value = e.latlng.lat.toFixed(4) + ',' + e.latlng.lng.toFixed(4);
        });

        // Ensure map resizes properly when the page loads
        map.invalidateSize();
    }

    // Call the initializeMap function when the page has loaded
    window.onload = function() {
        initializeMap();
    };
</script>



<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
