<?php
$active = 'contact';
$title = 'اتصل بنا - الرياض الخضراء';
ob_start();
?>

<section class="py-16">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">
      <i class="fas fa-envelope ml-2"></i> اتصل بنا
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed mb-8 text-center">
      إذا كان لديك أي استفسار أو تحتاج إلى مزيد من المعلومات، يرجى ملء النموذج أدناه وسنتواصل معك في أقرب وقت.
    </p>
    <form action="<?= route('contact.submit'); ?>" method="POST" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
        <input type="text" id="name" name="name" required placeholder="أدخل اسمك" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" required placeholder="example@example.com" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
      </div>
      <div>
        <label for="subject" class="block text-sm font-medium text-gray-700">الموضوع</label>
        <input type="text" id="subject" name="subject" required placeholder="أدخل موضوع الرسالة" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600">
      </div>
      <div>
        <label for="message" class="block text-sm font-medium text-gray-700">الرسالة</label>
        <textarea id="message" name="message" rows="5" required placeholder="أدخل رسالتك هنا" class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
          إرسال الرسالة
        </button>
      </div>
    </form>
  </div>
</section>
  
<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
