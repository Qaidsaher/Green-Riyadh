<?php
$active = 'admin.comments';
$title = 'تعديل تعليق - لوحة الإدارة';
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$comment = \App\Models\Comment::find($id);
if (!$comment) {
    echo "<p class='text-red-600 text-center'>التعليق غير موجود.</p>";
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">تعديل التعليق</h2>
  <?php
  if (isset($_SESSION['error'])) {
      echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('admin.comments.update', ['id' => $comment->id]); ?>" method="POST" class="space-y-6">
    <div>
      <label for="commentText" class="block text-sm font-medium text-gray-700">التعليق</label>
      <textarea id="commentText" name="commentText" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"><?= htmlspecialchars($comment->commentText); ?></textarea>
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
