<?php
$active = 'admin.faqs';
$title = 'تعديل سؤال - لوحة الإدارة';
ob_start();

// Retrieve FAQ data by ID passed via GET parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$faq = \App\Models\FAQ::find($id);
if (!$faq) {
    echo "<p class='text-red-600 text-center'>السؤال غير موجود.</p>";
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل السؤال</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.faqs.update', ['id' => $faq->id]); ?>" method="POST" class="space-y-6">
    <div>
      <label for="question" class="block text-sm font-medium text-gray-700">السؤال</label>
      <textarea id="question" name="question" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"><?= htmlspecialchars($faq->question); ?></textarea>
    </div>
    <div>
      <label for="answer" class="block text-sm font-medium text-gray-700">الإجابة</label>
      <textarea id="answer" name="answer" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"><?= htmlspecialchars($faq->answer); ?></textarea>
    </div>
    <div>
      <label for="contactInfo" class="block text-sm font-medium text-gray-700">جهة الاتصال</label>
      <input type="email" id="contactInfo" name="contactInfo" value="<?= htmlspecialchars($faq->contactInfo); ?>" placeholder="contact@example.com" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>
    <div class="flex justify-end">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
        تحديث
      </button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
