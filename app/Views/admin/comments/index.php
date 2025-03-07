<?php
$active = 'admin.comments';
$title = 'إدارة التعليقات - لوحة الإدارة';
ob_start();

// Retrieve all comments using your Comment model
$comments = \App\Models\Comment::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة التعليقات</h2>
  </div>

  <?php if (!empty($comments)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">المستخدم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">التعليق</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">تاريخ التعليق</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($comments as $comment): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($comment->id); ?></td>
              <td class="px-6 py-4 text-right">
                <?php 
                  $user = \App\Models\User::find($comment->userId);
                  echo $user ? htmlspecialchars($user->fullName) : 'غير متوفر';
                ?>
              </td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($comment->commentText); ?></td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($comment->commentDate); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.comments.edit', ['id' => $comment->id]); ?>" class="text-blue-600 hover:underline mr-2">
                  <i class="fas fa-edit ml-1"></i> تعديل
                </a>
                <a href="<?= route('admin.comments.delete', ['id' => $comment->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف التعليق؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد تعليقات مسجلة.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
