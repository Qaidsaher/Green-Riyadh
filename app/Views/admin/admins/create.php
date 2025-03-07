<?php
$active = 'admin.admins';
$title = 'إضافة مسؤول - لوحة الإدارة';
ob_start();
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">إضافة مسؤول جديد</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
 
  ?>
  <form action="<?= route('admin.admins.store'); ?>" method="POST" class="space-y-6">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
      <input type="text" id="name" name="name" required placeholder="أدخل الاسم" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
      <input type="email" id="email" name="email" required placeholder="example@example.com" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
      <input type="password" id="password" name="password" required placeholder="********" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
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
