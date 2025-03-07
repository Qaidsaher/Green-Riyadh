<?php
$active = 'faqs';
$title = 'الأسئلة الشائعة - الرياض الخضراء';
ob_start();

// Retrieve FAQ data from the database using your FAQ model (if available)
// For demonstration, using static sample FAQs:
$faqs = App\Models\Faq::all();
?>

<section class="py-16 ">
  <div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto space-y-6">
    <h2 class="text-4xl font-bold text-green-700  mb-12">الأسئلة الشائعة</h2>

      <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $faq): ?>
          <div class="border rounded-lg overflow-hidden shadow">
            <button type="button" class="w-full px-6 py-4 text-left bg-green-50 hover:bg-green-100 focus:outline-none focus:bg-green-100 flex justify-between items-center faq-toggle" data-target="#faq<?= htmlspecialchars($faq->id); ?>">
              <span class="text-xl font-semibold text-green-700"><?= htmlspecialchars($faq->question); ?></span>
              <i class="fas fa-chevron-down text-green-700"></i>
            </button>
            <div id="faq<?= htmlspecialchars($faq->id); ?>" class="px-6 py-4 hidden border-t">
              <p class="text-gray-700 mb-4"><?= htmlspecialchars($faq->answer); ?></p>
              <?php if (!empty($faq->contactInfo)): ?>
                <div class="mt-4">
                  <p class="text-sm text-gray-600">
                    للتواصل مع الجهة المعنية:
                    <a href="mailto:<?= htmlspecialchars($faq->contactInfo); ?>" class="underline text-green-700 hover:text-green-900 transition">
                      <?= htmlspecialchars($faq->contactInfo); ?>
                    </a>
                  </p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-600">لا توجد أسئلة شائعة بعد.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Contact Form Section (if needed) -->
<section class="py-16 bg-green-50">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-green-700 mb-4">تواصل معنا</h2>
    <p class="text-lg text-gray-700 max-w-2xl mx-auto mb-8">
      إذا كانت لديك أي استفسارات أو ملاحظات، يمكنك التواصل معنا عبر النموذج أدناه.
    </p>
    <form action="<?= route('contact'); ?>" method="POST" class="max-w-xl mx-auto space-y-6">
      <div>
        <input type="text" name="name" placeholder="الاسم" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600" required>
      </div>
      <div>
        <input type="email" name="email" placeholder="البريد الإلكتروني" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600" required>
      </div>
      <div>
        <textarea name="message" rows="4" placeholder="رسالتك" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600" required></textarea>
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded transition duration-300">
        إرسال
      </button>
    </form>
  </div>
</section>

<script>
  // FAQ accordion functionality
  document.querySelectorAll('.faq-toggle').forEach(function(button) {
    button.addEventListener('click', function() {
      const target = document.querySelector(this.dataset.target);
      if (target.classList.contains('hidden')) {
        target.classList.remove('hidden');
        this.querySelector('i').classList.replace('fa-chevron-down', 'fa-chevron-up');
      } else {
        target.classList.add('hidden');
        this.querySelector('i').classList.replace('fa-chevron-up', 'fa-chevron-down');
      }
    });
  });
</script>

<?php
$content = ob_get_clean();
if (auth()->check()) {  // Assuming you store authentication status in the session
    include __DIR__ . '/layout/auth.php';  // Include auth.php if user is authenticated
} else {
    include __DIR__ . '/layout/guest.php';  // Otherwise, include guest.php
}