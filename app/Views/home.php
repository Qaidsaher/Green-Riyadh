<?php
// تعيين الصفحة النشطة للنافبار وتعيين العنوان
$active = 'home';
$title = 'الرئيسية - الرياض الخضراء';

// بدء تخزين المحتوى
ob_start();
?>

<!-- Hero Section: full width background -->
<section class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-24">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center">
    <div class="md:w-1/2 text-center md:text-right">
      <h1 class="text-5xl font-bold mb-4">الرياض الخضراء</h1>
      <p class="text-xl mb-6">
        منصة مبتكرة تتيح للمواطنين إرسال البلاغات حول الأماكن التي تحتاج للزراعة، مع خريطة تفاعلية لإظهار المشاريع البيئية.
      </p>
      <?php if (!auth()->check()): ?>
        <a href="<?= route('register'); ?>" class="bg-white text-green-700 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-200 transition duration-300">
          سجل الآن
        </a>
      <?php endif; ?>
    </div>
    <div class="md:w-1/2 mt-8 md:mt-0">
      <!-- الصورة مخفية على الشاشات الصغيرة -->
      <img src="<?= asset('images/images (4).pg'); ?>" alt="خريطة تفاعلية" class="hidden md:block rounded shadow-lg max-h-[300px]">
    </div>
  </div>
</section>

<!-- About Section -->
<section class="w-full py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-green-700 mb-4">من نحن</h2>
    <p class="text-lg text-gray-700 max-w-3xl mx-auto">
      "الرياض الخضراء" هي منصة تهدف إلى تعزيز المساحات الخضراء من خلال تمكين المواطنين من إرسال بلاغاتهم للجهات المختصة، ومتابعة إحصائيات الزراعة في أحيائهم بطريقة تفاعلية.
    </p>
  </div>
</section>

<!-- Features Section -->
<section class="w-full py-16 bg-green-50">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-4xl font-bold text-green-700 text-center mb-12">مميزات الموقع</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <i class="fas fa-map-marked-alt text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">خريطة تفاعلية</h3>
        <p class="text-gray-700">
          حدد الأماكن التي تحتاج للزراعة وتابع إحصائيات الأحياء بكل سهولة.
        </p>
      </div>
      <!-- Feature 2 -->
      <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <i class="fas fa-bullhorn text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">بلاغات المواطنين</h3>
        <p class="text-gray-700">
          أرسل بلاغاتك مباشرةً للجهات المختصة مع إمكانية متابعة حالة البلاغ.
        </p>
      </div>
      <!-- Feature 3 -->
      <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <i class="fas fa-comments text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">نقاش وتواصل</h3>
        <p class="text-gray-700">
          شارك في النقاش مع المجتمع حول المبادرات البيئية والتحديثات على المشاريع.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="w-full py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-green-700 mb-8">كيف يعمل الموقع</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Step 1 -->
      <div class="bg-green-100 p-6 rounded-lg shadow-lg">
        <i class="fas fa-user-check text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">تسجيل الدخول أو إنشاء حساب</h3>
        <p class="text-gray-700">
          قم بتسجيل الدخول أو إنشاء حساب جديد للوصول إلى كافة ميزات الموقع.
        </p>
      </div>
      <!-- Step 2 -->
      <div class="bg-green-100 p-6 rounded-lg shadow-lg">
        <i class="fas fa-map-marker-alt text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">إرسال بلاغ</h3>
        <p class="text-gray-700">
          اختر الموقع على الخريطة وأرسل بلاغك للجهات المختصة.
        </p>
      </div>
      <!-- Step 3 -->
      <div class="bg-green-100 p-6 rounded-lg shadow-lg">
        <i class="fas fa-chart-line text-green-600 text-5xl mb-4"></i>
        <h3 class="text-2xl font-bold mb-2">متابعة البلاغات وكسب النقاط</h3>
        <p class="text-gray-700">
          تابع حالة بلاغاتك واحصل على نقاط للمشاركة في المبادرات البيئية.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="w-full py-16 bg-green-50">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-4xl font-bold text-green-700 text-center mb-8">الأسئلة الشائعة</h2>
    <div class="max-w-3xl mx-auto">
      <!-- FAQ 1 -->
      <div class="mb-4 border-b pb-4">
        <h3 class="text-2xl font-bold text-green-600">كيف يمكنني إرسال بلاغ؟</h3>
        <p class="text-gray-700 mt-2">
          قم بإنشاء حساب جديد أو تسجيل الدخول، ثم انتقل إلى قسم البلاغات وحدد الموقع على الخريطة.
        </p>
      </div>
      <!-- FAQ 2 -->
      <div class="mb-4 border-b pb-4">
        <h3 class="text-2xl font-bold text-green-600">ما هي النقاط وكيف أحصل عليها؟</h3>
        <p class="text-gray-700 mt-2">
          تحصل على نقاط عند إرسال بلاغات صحيحة، ويمكن استخدام النقاط للمشاركة في مبادرات إضافية.
        </p>
      </div>
      <!-- FAQ 3 -->
      <div class="mb-4 border-b pb-4">
        <h3 class="text-2xl font-bold text-green-600">كيف أتابع بلاغاتي؟</h3>
        <p class="text-gray-700 mt-2">
          بعد إرسال البلاغ، يمكنك متابعة حالته من خلال حسابك في قسم "متابعة البلاغات".
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Contact Us Section -->
<section class="w-full py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-green-700 mb-4">تواصل معنا</h2>
    <p class="text-lg text-gray-700 max-w-2xl mx-auto mb-8">
      إذا كانت لديك أي استفسارات أو ملاحظات، يمكنك التواصل معنا عبر النموذج أدناه.
    </p>
    <form action="#" method="POST" class="max-w-xl mx-auto">
      <div class="mb-4">
        <input type="text" name="name" placeholder="الاسم" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600">
      </div>
      <div class="mb-4">
        <input type="email" name="email" placeholder="البريد الإلكتروني" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600">
      </div>
      <div class="mb-4">
        <textarea name="message" rows="4" placeholder="رسالتك" class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-green-600"></textarea>
      </div>
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full transition duration-300">
        إرسال
      </button>
    </form>
  </div>
</section>

<!-- Partners Section -->
<section class="w-full py-16 bg-green-50">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-bold text-green-700 mb-8">شركاؤنا</h2>
    <div class="flex flex-wrap justify-center items-center gap-8">
      <!-- Replace these with your actual partner logos -->
      <div class="w-32 h-32 rounded-full border-2 border-green-700 overflow-hidden">
        <img src="<?= asset('images/partners/logo1.jpeg'); ?>" alt="شريك 1" class="w-full h-full object-cover">
      </div>
      <div class="w-32 h-32 rounded-full border-2 border-green-700 overflow-hidden">
        <img src="<?= asset('images/partners/logo2.jpeg'); ?>" alt="شريك 2" class="w-full h-full object-cover">
      </div>
      <div class="w-32 h-32 rounded-full border-2 border-green-700 overflow-hidden">
        <img src="<?= asset('images/partners/logo3.jpeg'); ?>" alt="شريك 3" class="w-full h-full object-cover">
      </div>
      <div class="w-32 h-32 rounded-full border-2 border-green-700 overflow-hidden">
        <img src="<?= asset('images/partners/logo4.jpeg'); ?>" alt="شريك 4" class="w-full h-full object-cover">
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="w-full py-16 bg-green-700 text-white text-center">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-4xl font-bold mb-4">انضم الآن لتحقيق الرياض الخضراء</h2>
    <p class="text-xl mb-8">
      ساهم في إرسال البلاغات ومتابعة المشاريع البيئية، وكن جزءاً من التغيير.
    </p>
    <?php if (!auth()->check()): ?>
      <a href="<?= route('register'); ?>" class="bg-white text-green-700 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-200 transition duration-300">
        سجل الآن
      </a>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
?>
