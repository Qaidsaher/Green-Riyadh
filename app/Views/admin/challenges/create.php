<?php
$active = 'admin.challenges';
$title = 'إضافة مهمة - لوحة الإدارة';
ob_start();
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">إضافة مهمة جديدة</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.challenges.store'); ?>" method="POST" class="space-y-6">
    <div>
      <label for="challengeId" class="block text-sm font-medium text-gray-700">رقم التحدي</label>
      <input type="number" id="challengeId" name="challengeId" required placeholder="أدخل رقم التحدي" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="taskName" class="block text-sm font-medium text-gray-700">اسم المهمة</label>
      <input type="text" id="taskName" name="taskName" required placeholder="أدخل اسم المهمة" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="taskDescription" class="block text-sm font-medium text-gray-700">وصف المهمة</label>
      <textarea id="taskDescription" name="taskDescription" required placeholder="أدخل وصف المهمة" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
    </div>
    <div>
      <label for="points" class="block text-sm font-medium text-gray-700">النقاط</label>
      <input type="number" id="points" name="points" required placeholder="أدخل عدد النقاط" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div>
      <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
      <select id="status" name="status" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
        <option value="active">نشط</option>
        <option value="completed">مكتمل</option>
      </select>
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
