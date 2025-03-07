<?php
$active = 'user.challenges';
$title = 'تفاصيل التحدي - لوحة المستخدم';
ob_start();

// $challenge is passed from the controller
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-md">
  <h2 class="text-3xl font-bold text-green-700 mb-4 "><?= htmlspecialchars($challenge->taskName); ?></h2>
  <p class="text-gray-700 mb-4"><?= htmlspecialchars($challenge->taskDescription); ?></p>
  <p class="text-gray-700 mb-4"><span class="font-bold">النقاط:</span> <?= htmlspecialchars($challenge->points); ?></p>
  <!-- Add any additional challenge details or a button to submit the challenge -->
  <div class="text-left">
    <a href="<?= route('user.challenges'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
      العودة للتحديات
    </a>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
