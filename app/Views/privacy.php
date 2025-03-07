<?php
$title = 'سياسة الخصوصية - الرياض الخضراء';
ob_start();
?>

<section class="py-16 bg-gray-50">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">
      <i class="fas fa-shield-alt ml-2"></i> سياسة الخصوصية
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed">
      نحن في "الرياض الخضراء" نحترم خصوصيتك ونلتزم بحماية معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية المعلومات التي تقدمها عند استخدام موقعنا.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">جمع المعلومات</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      نقوم بجمع المعلومات التي تقدمها بشكل مباشر، مثل الاسم والبريد الإلكتروني، بالإضافة إلى المعلومات التي يتم جمعها تلقائيًا من خلال استخدام الموقع.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">استخدام المعلومات</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      تُستخدم معلوماتك لتحسين تجربتك على الموقع ولتزويدك بالمحتوى والخدمات ذات الصلة. نحن لا نشارك معلوماتك الشخصية مع أطراف خارجية دون موافقتك.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">أمن المعلومات</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      نتخذ إجراءات أمنية معقولة لحماية معلوماتك من الوصول غير المصرح به أو التعديل أو الكشف أو التدمير.
    </p>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
