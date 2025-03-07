<?php
$active = 'admin.statistics';
$title = 'إضافة إحصائيات - لوحة الإدارة';
ob_start();
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">إضافة إحصائيات جديدة</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
 
  ?>
  <form action="<?= route('admin.statistics.store'); ?>" method="POST" class="space-y-6">
    <div>
      <label for="locationId" class="block text-sm font-medium text-gray-700">معرف الموقع</label>
      <input type="number" id="locationId" name="locationId" required placeholder="أدخل معرف الموقع" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="treesPlanted" class="block text-sm font-medium text-gray-700">عدد الأشجار المزروعة</label>
      <input type="number" id="treesPlanted" name="treesPlanted" required placeholder="أدخل عدد الأشجار" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="reportsSubmitted" class="block text-sm font-medium text-gray-700">عدد البلاغات المقدمة</label>
      <input type="number" id="reportsSubmitted" name="reportsSubmitted" required placeholder="أدخل عدد البلاغات" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="pointsEarned" class="block text-sm font-medium text-gray-700">النقاط المكتسبة</label>
      <input type="number" id="pointsEarned" name="pointsEarned" required placeholder="أدخل عدد النقاط" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div class="flex justify-end">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
        حفظ
      </button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
