<?php
$active = 'user.reports.create';
$title = 'إرسال بلاغ - لوحة المستخدم';
ob_start();
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl mt-4">
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-right">إرسال بلاغ جديد</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    
    ?>
    <form action="<?= route('user.reports.store'); ?>" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateForm()">
        <!-- Grid Layout for Form Fields -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">عنوان البلاغ</label>
                <input type="text" id="title" name="title" required placeholder="أدخل عنوان البلاغ" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
            </div>
            <!-- Location Input (Coordinates) -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">الموقع</label>
                <input type="text" id="location" name="location" placeholder="اختر موقع من الخريطة" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600" readonly disabled required>
            </div>
            <!-- Map -->
            <div class="col-span-2">
                <label for="ma" class="block text-sm font-medium text-gray-700 mb-2">اختر موقع من الخريطة</label>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>


            <!-- Description Input -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">وصف البلاغ</label>
                <textarea id="description" name="description" required placeholder="أدخل وصف البلاغ" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600" ></textarea>
            </div>

            <!-- Image Upload -->
            <div class="col-span-2">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">تحميل صورة البلاغ</label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p id="file-name" class="mb-2 text-sm text-gray-500"><span class="font-semibold">اضغط للرفع</span> أو اسحب الملف هنا</p>
                            <p class="text-xs text-gray-500">PNG, JPG أو GIF (الحد الأقصى 2MB)</p>
                        </div>
                        <input id="dropzone-file" name="image" type="file" accept="image/*" class="hidden" onchange="displayFileName()" />
                    </label>
                </div>
            </div>

        </div>



        <div class="flex justify-end">
            <button type="submit" class="px-8 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded transition duration-300">
                إرسال البلاغ
            </button>
        </div>
    </form>
</div>

<!-- Include Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    function validateForm() {
        let location = document.getElementById('location').value;
        if (!location) {
            alert('يرجى اختيار الموقع من الخريطة.');
            return false;
        }
        return true;
    }

    function displayFileName() {
        const fileInput = document.getElementById('dropzone-file');
        const fileNameDisplay = document.getElementById('file-name');

        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = "📂 " + fileInput.files[0].name; // Show file name
            fileNameDisplay.classList.add('text-green-600', 'font-bold'); // Highlight text
        } else {
            fileNameDisplay.textContent = "اضغط للرفع أو اسحب الملف هنا"; // Reset if no file is selected
            fileNameDisplay.classList.remove('text-green-600', 'font-bold');
        }
    }
    // Initialize map
    var map = L.map('map').setView([24.7136, 46.6753], 13); // Riyadh coordinates

    // Add tile layer (you can choose other tiles if you prefer)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Predefined places with name and coordinates
    var places = [{
            name: "الدرعية",
            lat: 24.7188,
            lng: 46.5695
        },
        {
            name: "الرياض 360",
            lat: 24.7275,
            lng: 46.6896
        },
        {
            name: "مركز الملك عبد الله المالي",
            lat: 24.7880,
            lng: 46.6995
        },
        {
            name: "الحي الدبلوماسي",
            lat: 24.6800,
            lng: 46.7165
        },
        {
            name: "جامعة الملك سعود",
            lat: 24.7730,
            lng: 46.7090
        }
    ];

    // Add markers for each predefined place
    places.forEach(function(place) {
        var marker = L.marker([place.lat, place.lng]).addTo(map);
        marker.bindPopup(place.name);

        // When a user clicks on a marker, update the location input with the coordinates
        marker.on('click', function() {
            document.getElementById('location').value = place.name + " (" + place.lat + ", " + place.lng + ")";
        });
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
