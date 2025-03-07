<?php
$active = 'admin.challenges';
$title = 'إدارة المهام - لوحة الإدارة';
ob_start();

// Retrieve all challenge tasks using your ChallengeTask model
$tasks = \App\Models\ChallengeTask::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة المهام</h2>
    <a href="<?= route('admin.challenges.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة مهمة
    </a>
  </div>
  
  <?php if (!empty($tasks)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">اسم المهمة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الوصف</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">النقاط</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الحالة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($tasks as $task): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($task->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($task->taskName); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($task->taskDescription); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($task->points); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($task->status); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.challenges.edit', ['id' => $task->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.challenges.delete', ['id' => $task->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف المهمة؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد مهام مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
