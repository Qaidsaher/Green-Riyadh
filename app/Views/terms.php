<?php
$title = 'الشروط والأحكام - الرياض الخضراء';
ob_start();
?>

<section class="py-16 bg-white">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">
      <i class="fas fa-file-contract ml-2"></i> الشروط والأحكام
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed">
      مرحبًا بكم في موقع "الرياض الخضراء". باستخدام هذا الموقع، فإنك توافق على الالتزام بالشروط والأحكام التالية. يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">استخدام الموقع</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      يحق للمستخدم استخدام الموقع لأغراض شخصية وغير تجارية فقط. يمنع إعادة إنتاج أو توزيع المحتوى دون إذن كتابي.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">حقوق الملكية</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      جميع حقوق الطبع والنشر والعلامات التجارية وغيرها من حقوق الملكية الفكرية المتعلقة بالموقع محفوظة. لا يجوز استخدام أو نسخ المحتوى بأي شكل دون موافقة مسبقة.
    </p>
    <h2 class="text-2xl font-bold text-green-700 mt-8 mb-4">المسؤولية</h2>
    <p class="text-lg text-gray-700 leading-relaxed">
      لا يتحمل الموقع أي مسؤولية عن الأضرار الناجمة عن استخدام المعلومات المقدمة. يُرجى مراجعة المعلومات بانتظام للتأكد من دقتها.
    </p>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
