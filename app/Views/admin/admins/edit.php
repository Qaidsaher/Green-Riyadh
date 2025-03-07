<?php
$active = 'admin.admins';
$title = 'تعديل مسؤول - لوحة الإدارة';
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$admin = \App\Models\Admin::find($id);
if (!$admin) {
    echo "<p class='text-red-600 text-center'>المسؤول غير موجود.</p>";
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل بيانات المسؤول</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.admins.update', ['id' => $admin->id]); ?>" method="POST" class="space-y-6">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($admin->name); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($admin->email); ?>" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
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
