<?php
$active = 'admin.faqs';
$title = 'إدارة الأسئلة الشائعة - لوحة الإدارة';
ob_start();

// Retrieve FAQs from the database using your FAQ model
$faqs = \App\Models\FAQ::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة الأسئلة الشائعة</h2>
    <a href="<?= route('admin.faqs.create'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
      <i class="fas fa-plus ml-2"></i> إضافة سؤال
    </a>
  </div>

  <?php if (!empty($faqs)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">السؤال</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجابة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">جهة الاتصال</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($faqs as $faq): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($faq->id); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($faq->question); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($faq->answer); ?></td>
              <td class="px-6 py-4 text-right">
                <?php if (!empty($faq->contactInfo)): ?>
                  <a href="mailto:<?= htmlspecialchars($faq->contactInfo); ?>" class="text-green-600 hover:underline">
                    <?= htmlspecialchars($faq->contactInfo); ?>
                  </a>
                <?php else: ?>
                  غير متوفر
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.faqs.edit', ['id' => $faq->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.faqs.delete', ['id' => $faq->id]); ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد أسئلة شائعة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
