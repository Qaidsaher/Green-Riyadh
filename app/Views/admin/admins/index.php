<?php
$active = 'admin.admins';
$title = 'إدارة المسؤولين - لوحة الإدارة';
ob_start();

$admins = \App\Models\Admin::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة المسؤولين</h2>
    <a href="<?= route('admin.admins.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة مسؤول
    </a>
  </div>
  
  <?php if (!empty($admins)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الاسم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">البريد الإلكتروني</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($admins as $admin): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($admin->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($admin->name); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($admin->email); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.admins.edit', ['id' => $admin->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.admins.delete', ['id' => $admin->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف المسؤول؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا يوجد مسؤولون مسجلون بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
