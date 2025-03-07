<?php
$active = 'admin.reports';
$title = 'إدارة البلاغات - لوحة الإدارة';
ob_start();

// Retrieve reports using your Report model
$reports = \App\Models\Report::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة البلاغات</h2>
  </div>
  
  <?php if (!empty($reports)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">المستخدم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الوصف</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الحالة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">تاريخ التقديم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($reports as $report): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($report->id); ?></td>
              <td class="px-6 py-4 text-right">
                <?php 
                  $user = \App\Models\User::find($report->userId);
                  echo $user ? htmlspecialchars($user->fullName) : 'غير متوفر';
                ?>
              </td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($report->description); ?></td>
              <td class="px-6 py-4 text-right">
                <form action="<?= route('admin.reports.update_status', ['id' => $report->id]); ?>" method="POST" class="inline-block">
                  <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded p-1 text-sm">
                    <option value="pending" <?= $report->status=='pending' ? 'selected' : ''; ?>>قيد الانتظار</option>
                    <option value="reviewed" <?= $report->status=='reviewed' ? 'selected' : ''; ?>>تمت المراجعة</option>
                    <option value="resolved" <?= $report->status=='resolved' ? 'selected' : ''; ?>>محلولة</option>
                  </select>
                </form>
              </td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($report->submit); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.reports.delete', ['id' => $report->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف البلاغ؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد بلاغات مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
