<?php
$active = 'user.reports';
$title = 'تفاصيل البلاغ - لوحة المستخدم';
ob_start();

// $report is passed from the controller
$comments = $report->getComments();
$currentUser = auth()->user();

// Function to get Arabic translation of status
function getArabicStatus($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return 'قيد الانتظار';
    case 'reviewed':
      return 'تم المراجعة';
    case 'resolved':
      return 'تم الحل';
    default:
      return 'غير معروف';
  }
}

// Helper function for status badge classes
function getStatusBadgeClass($status)
{
  switch (strtolower($status)) {
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    case 'reviewed':
      return 'bg-indigo-100 text-indigo-800';
    case 'resolved':
      return 'bg-blue-100 text-blue-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}

// Get the report creator's name
$reportUser = \App\Models\User::find($report->userId);
$reportUserName = $reportUser ? $reportUser->fullName : 'غير متوفر';
?>

<div class="bg-white p-6 rounded-lg shadow-xl mb-8">
  <h2 class="text-3xl font-bold text-green-700 mb-4 text-center">تفاصيل البلاغ</h2>

  <!-- 🔥 Report Title -->
  <p class="text-xl font-bold text-gray-800 mb-3"><span class="text-green-700">عنوان البلاغ:</span> <?= htmlspecialchars($report->title); ?></p>

  <!-- 🔥 Display Report Image (if available) -->
  <?php if (!empty($report->image)): ?>
    <div class="flex justify-center mb-4">
      <img src="<?= asset(path: '/uploads/reports/' . htmlspecialchars($report->image)); ?>"
        alt="صورة البلاغ"
        class="rounded-lg shadow-md w-full max-w-lg">
    </div>
  <?php endif; ?>

  <div class="mb-4 space-y-2">
    <p class="text-gray-700"><span class="font-bold">الرقم:</span> <?= htmlspecialchars($report->id); ?></p>
    <p class="text-gray-700"><span class="font-bold">الوصف:</span> <?= htmlspecialchars($report->description); ?></p>

    <!-- 🔥 Show Status in Arabic -->
    <p class="text-gray-700 flex items-center">
      <span class="font-bold">الحالة:</span>
      <span class="ml-2 inline-block px-3 py-1 rounded-full text-xs font-semibold <?= getStatusBadgeClass($report->status); ?>">
        <?= getArabicStatus($report->status); ?>
      </span>
    </p>

    <p class="text-gray-700"><span class="font-bold">تاريخ الإرسال:</span> <?= htmlspecialchars($report->submit); ?></p>
    <p class="text-gray-700"><span class="font-bold">الناشر:</span> <?= htmlspecialchars($reportUserName); ?></p>
  </div>
</div>


<div class="bg-white p-6 rounded-lg shadow-xl mb-8">
  <h3 class="text-2xl font-bold text-green-700 mb-4">التعليقات</h3>

  <!-- Comments List -->
  <?php if (!empty($comments)): ?>
    <ul class="space-y-4 mb-6">
      <?php foreach ($comments as $comment):
        // Get the comment creator name
        $commentUser = \App\Models\User::find($comment->userId);
        $commentUserName = $commentUser ? $commentUser->fullName : 'غير متوفر';
      ?>
        <li class="border p-4 rounded">
          <div class="flex justify-between items-center mb-2">
            <span class="font-bold text-gray-800"><?= htmlspecialchars($commentUserName); ?></span>
            <span class="text-xs text-gray-500"><?= htmlspecialchars($comment->commentDate); ?></span>
          </div>
          <p class="text-gray-700"><?= htmlspecialchars($comment->commentText); ?></p>
          <?php if ($comment->userId === $currentUser->id): ?>
            <div class="mt-2 text-right">
              <a href="<?= route('user.reports.delete_comment', ['id' => $report->id, 'commentId' => $comment->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف هذا التعليق؟')" class="text-red-600 hover:underline text-sm">
                <i class="fas fa-trash-alt ml-1"></i> حذف التعليق
              </a>
            </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-gray-600">لا توجد تعليقات بعد.</p>
  <?php endif; ?>

  <!-- Add New Comment Form -->
  <div class="mt-6">
    <h4 class="text-xl font-bold text-green-700 mb-2">أضف تعليقاً جديداً</h4>
    <form action="<?= route('user.reports.add_comment', ['id' => $report->id]); ?>" method="POST" class="space-y-4">
      <textarea name="commentText" rows="3" required placeholder="أدخل تعليقك هنا..." class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
      <div class="flex justify-end">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
          إضافة التعليق
        </button>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
?>