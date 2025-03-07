<?php
$active = 'user.challenges';
$title = 'تحدياتي - لوحة المستخدم';
ob_start();

// $challenges array passed from the controller (ensure it returns an array)
$challenges = $challenges ?? [];
?>

<div class="max-w-7xl mx-auto">
  <h2 class="text-3xl font-bold text-green-700 mb-6 ">التحديات المتاحة</h2>
  
  <?php if (!empty($challenges)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($challenges as $challenge): ?>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
          <h3 class="text-xl font-bold text-green-700 mb-2"><?= htmlspecialchars($challenge->taskName); ?></h3>
          <p class="text-gray-700 mb-2"><?= htmlspecialchars($challenge->taskDescription); ?></p>
          <p class="text-gray-700 mb-2"><span class="font-bold">النقاط:</span> <?= htmlspecialchars($challenge->points); ?></p>
          <div class="flex justify-end">
            <a href="<?= route('user.challenges.show', ['id' => $challenge->id]); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
              عرض التفاصيل
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-gray-600 text-center">لا توجد تحديات متاحة حالياً.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
