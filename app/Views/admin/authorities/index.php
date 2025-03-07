<?php
$active = 'admin.authorities';
$title = 'إدارة الجهات - الرياض الخضراء';
ob_start();

// Retrieve all authority records using the Authority model
$authorities = \App\Models\Authority::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة الجهات</h2>
    <a href="<?= route('admin.authorities.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة جهة
    </a>
  </div>

  <?php if (!empty($authorities)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الاسم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">البريد الإلكتروني</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">رقم الهاتف</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($authorities as $auth): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($auth->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($auth->name); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($auth->contactEmail); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($auth->contactPhone); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.authorities.edit', ['id' => $auth->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.authorities.delete', ['id' => $auth->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف الجهة؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد جهات مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
