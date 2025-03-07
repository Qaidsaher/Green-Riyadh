<?php
$active = 'admin.authorities';
$title = 'تعديل جهة - إدارة الجهات';
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$authority = \App\Models\Authority::find($id);
if (!$authority) {
    echo "<p class='text-red-600 text-center'>الجهة غير موجودة.</p>";
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل بيانات الجهة</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.authorities.update', ['id' => $authority->id]); ?>" method="POST" class="space-y-6">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">اسم الجهة</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($authority->name); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="contactEmail" class="block text-sm font-medium text-gray-700">البريد الإلكتروني لجهة الاتصال</label>
      <input type="email" id="contactEmail" name="contactEmail" value="<?= htmlspecialchars($authority->contactEmail); ?>" placeholder="contact@example.com" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="contactPhone" class="block text-sm font-medium text-gray-700">رقم هاتف جهة الاتصال</label>
      <input type="text" id="contactPhone" name="contactPhone" value="<?= htmlspecialchars($authority->contactPhone); ?>" placeholder="أدخل رقم الهاتف" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
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
