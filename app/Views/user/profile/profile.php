<?php
// Set active route and title
$active = 'profile';
$title = 'الملف الشخصي - الرياض الخضراء';
ob_start();

// Get the authenticated user object.
$user = auth()->user();
$avatarPath = !empty($user->avatar) ? asset('uploads/avatars/' . $user->avatar) : asset('images/default-avatar.png');
?>

<div class="max-w-7xl mx-auto my-4 p-6 bg-white rounded-lg shadow-xl">
  <!-- Profile Header -->
  <div class="flex flex-col md:flex-row items-center justify-between border-b pb-6">
    <div class="flex items-center">
      <img src="<?= $avatarPath ?>" alt="صورة الملف" class="w-28 h-28 rounded-full shadow-lg">
      <div class="mr-4">
        <h2 class="text-3xl font-bold text-green-700"><?= htmlspecialchars($user->fullName); ?></h2>
        <p class="text-gray-600"><?= htmlspecialchars($user->email); ?></p>
        <p class="text-gray-600"><?= htmlspecialchars($user->phoneNumber); ?></p>
        <p class="text-gray-600"><?= htmlspecialchars($user->points); ?></p>

      </div>
    </div>
    <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
      <a href="<?= route('user.edit_profile'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">تعديل الملف</a>
      <a href="<?= route('user.update_password'); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">تحديث كلمة المرور</a>
      <a href="<?= route('delete_account'); ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">حذف الحساب</a>
      <a href="<?= route('logout'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">تسجيل الخروج</a>
    </div>
  </div>

  <!-- Profile Details Section -->
  <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Comments Card -->
    <div class="bg-green-50 p-6 rounded-lg shadow">
      <h3 class="text-2xl font-bold text-green-700 mb-4">تعليقاتي</h3>
      <?php $comments = $user->getComments(); ?>
      <?php if (!empty($comments)): ?>
        <ul class="space-y-3">
          <?php foreach ($comments as $comment): ?>
            <li class="p-3 border rounded">
              <p class="text-gray-700"><?= htmlspecialchars($comment->commentText); ?></p>
              <span class="text-xs text-gray-500"><?= htmlspecialchars($comment->commentDate); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-600">لا توجد تعليقات بعد.</p>
      <?php endif; ?>
    </div>
    <!-- Reports Card -->
    <div class="bg-green-50 p-6 rounded-lg shadow">
      <h3 class="text-2xl font-bold text-green-700 mb-4">بلاغاتي</h3>
      <?php $reports = $user->getReports(); ?>
      <?php if (!empty($reports)): ?>
        <ul class="space-y-3">
          <?php foreach ($reports as $report): ?>
            <li class="p-3 border rounded">
              <h4 class="font-bold text-green-600"><?= htmlspecialchars($report->title ?? 'بلاغ جديد'); ?></h4>
              <p class="text-gray-700"><?= htmlspecialchars($report->description); ?></p>
              <span class="text-xs text-gray-500"><?= htmlspecialchars($report->submit); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-600">لم تقم بإرسال بلاغات بعد.</p>
      <?php endif; ?>
    </div>
    <!-- Points Card -->
    <div class="bg-green-50 p-6 rounded-lg shadow">
      <h3 class="text-2xl font-bold text-green-700 mb-4">نقاطي</h3>
      <?php $points = $user->getPoints(); ?>
      <?php if (!empty($points)): ?>
        <ul class="space-y-3">
          <?php foreach ($points as $point): ?>
            <li class="p-3 border rounded flex justify-between items-center">
              <span class="text-gray-700">نقاط: <?= htmlspecialchars($point->pointsEarned); ?></span>
              <span class="text-xs text-gray-500"><?= htmlspecialchars($point->dateEarned); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-600">لم تجمع نقاطًا بعد.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
