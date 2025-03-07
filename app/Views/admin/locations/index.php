<?php
$active = 'admin.locations';
$title = 'إدارة المواقع - لوحة الإدارة';
ob_start();

// Retrieve all locations using your Location model
$locations = \App\Models\Location::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة المواقع</h2>
    <a href="<?= route('admin.locations.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة موقع
    </a>
  </div>
  
  <?php if (!empty($locations)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الاسم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإحداثيات</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الوصف</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الحالة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الجهة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($locations as $loc): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($loc->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($loc->name); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($loc->coordinates); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($loc->description); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($loc->status); ?></td>
              <td class="px-6 py-4 text-right">
                <?php 
                  // For authority, you might call a relationship, e.g., $loc->getAuthority()->name
                  $authority = \App\Models\Authority::find($loc->authorityId);
                  echo $authority ? htmlspecialchars($authority->name) : 'غير متوفر';
                ?>
              </td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.locations.edit', ['id' => $loc->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.locations.delete', ['id' => $loc->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف الموقع؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد مواقع مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
