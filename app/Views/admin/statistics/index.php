<?php
$active = 'admin.statistics';
$title = 'إدارة الإحصائيات - لوحة الإدارة';
ob_start();

// Retrieve all statistics records
$stats = \App\Models\Statistic::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة الإحصائيات</h2>
    <a href="<?= route('admin.statistics.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة إحصائيات
    </a>
  </div>
  
  <?php if (!empty($stats)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">معرف الموقع</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">عدد الأشجار</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">عدد البلاغات</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">النقاط</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($stats as $stat): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($stat->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($stat->locationId); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($stat->treesPlanted); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($stat->reportsSubmitted); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($stat->pointsEarned); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.statistics.edit', ['id' => $stat->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.statistics.delete', ['id' => $stat->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف هذه الإحصائيات؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد إحصائيات مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
