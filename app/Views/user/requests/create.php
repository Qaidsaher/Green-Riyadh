<?php
$active = 'user.requests';
$title = 'طلب نقاط جديدة - لوحة المستخدم';
ob_start();
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl mt-10">
  <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">طلب نقاط</h2>

  <?php
  if (isset($_SESSION['error'])) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
  }
  
  ?>

  <form action="<?= route('user.requests.store'); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <div>
      <label for="pointsRequested" class="block text-sm font-medium text-gray-700">النقاط المطلوبة</label>
      <input type="number" id="pointsRequested" name="pointsRequested" required placeholder="أدخل عدد النقاط المطلوبة" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
    </div>

    <!-- Styled Proof Upload -->
    <div>
      <label for="proof" class="block text-sm font-medium text-gray-700 mb-2">إثبات الطلب (صورة أو ملف)</label>
      <div class="flex items-center justify-center w-full">
        <label for="proof" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
          <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
            </svg>
            <p id="file-name" class="mb-2 text-sm text-gray-500"><span class="font-semibold">اضغط للرفع</span> أو اسحب الملف هنا</p>
            <p class="text-xs text-gray-500">PNG, JPG أو GIF (الحد الأقصى 2MB)</p>

          </div>
          <input id="proof" name="proof" type="file" class="hidden" accept="image/*,application/pdf" onchange="displayFileName()" required>
        </label>
      </div>
    </div>

    <div>
      <label for="message" class="block text-sm font-medium text-gray-700">ملاحظة (اختياري)</label>
      <textarea id="message" name="message" rows="4" placeholder="أضف ملاحظات إضافية" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
    </div>

    <div class="flex justify-end">
      <button type="submit" class="px-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded transition duration-300">
        إرسال الطلب
      </button>
    </div>
  </form>
</div>
<script>
  function displayFileName() {
    const fileInput = document.getElementById('proof');
    const fileNameDisplay = document.getElementById('file-name');

    if (fileInput.files.length > 0) {
      fileNameDisplay.textContent = "📂 " + fileInput.files[0].name; // Show file name
      fileNameDisplay.classList.add('text-green-600', 'font-bold'); // Highlight text
    } else {
      fileNameDisplay.textContent = "اضغط للرفع أو اسحب الملف هنا"; // Reset if no file is selected
      fileNameDisplay.classList.remove('text-green-600', 'font-bold');
    }
  }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
?>