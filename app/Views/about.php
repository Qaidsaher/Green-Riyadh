<?php
$active='about';
$title = 'من نحن - الرياض الخضراء';
ob_start();
?>

<section class="py-16">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">
      <i class="fas fa-info-circle ml-2"></i> من نحن
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed">
      مرحبًا بكم في موقع "الرياض الخضراء"، المنصة الرائدة التي تهدف إلى تعزيز المساحات الخضراء في العاصمة. نسعى لجعل الرياض أكثر خضرة واستدامة من خلال تمكين المواطنين من إرسال بلاغاتهم للمناطق التي تحتاج إلى زراعة، وتقديم حلول مبتكرة لرفع مستوى البيئة في المدينة.
    </p>
    <p class="mt-4 text-lg text-gray-700 leading-relaxed">
      يعمل فريقنا على توفير منصة تفاعلية حيث يمكن للجميع مشاركة أفكارهم ومقترحاتهم حول كيفية تحسين البيئة المحلية، مما يعزز التعاون بين المواطنين والجهات المختصة.
    </p>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
