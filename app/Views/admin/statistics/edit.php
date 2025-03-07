<?php
$active = 'admin.statistics';
$title = 'تعديل إحصائيات - لوحة الإدارة';
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stat = \App\Models\Statistic::find($id);
if (!$stat) {
    echo "<p class='text-red-600 text-center'>الإحصائيات غير موجودة.</p>";
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل الإحصائيات</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.statistics.update', ['id' => $stat->id]); ?>" method="POST" class="space-y-6">
    <div>
      <label for="locationId" class="block text-sm font-medium text-gray-700">معرف الموقع</label>
      <input type="number" id="locationId" name="locationId" value="<?= htmlspecialchars($stat->locationId); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="treesPlanted" class="block text-sm font-medium text-gray-700">عدد الأشجار المزروعة</label>
      <input type="number" id="treesPlanted" name="treesPlanted" value="<?= htmlspecialchars($stat->treesPlanted); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="reportsSubmitted" class="block text-sm font-medium text-gray-700">عدد البلاغات المقدمة</label>
      <input type="number" id="reportsSubmitted" name="reportsSubmitted" value="<?= htmlspecialchars($stat->reportsSubmitted); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="pointsEarned" class="block text-sm font-medium text-gray-700">النقاط المكتسبة</label>
      <input type="number" id="pointsEarned" name="pointsEarned" value="<?= htmlspecialchars($stat->pointsEarned); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div class="flex justify-end">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
        تحديث
      </button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
