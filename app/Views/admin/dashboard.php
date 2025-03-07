<?php
$active = 'admin.home';
$title = 'الرئيسية - لوحة الإدارة';
ob_start();

// Retrieve data from models (replace with your actual queries)
$userCount       = count(\App\Models\User::all());
$reportCount     = count(\App\Models\Report::all());
$faqCount        = count(\App\Models\FAQ::all());
$requestCount    = count(array_filter(\App\Models\RequestPoint::all(), function ($r) {
  return $r->status === 'pending';
}));
$challengeCount  = count(\App\Models\ChallengeTask::all());
$locationCount   = count(\App\Models\Location::all());
$authorityCount  = count(\App\Models\Authority::all());
$adminCount      = count(\App\Models\Admin::all());

// For charts
$pendingReports   = count(array_filter(\App\Models\Report::all(), function ($r) {
  return $r->status === 'pending';
}));
$reviewedReports  = count(array_filter(\App\Models\Report::all(), function ($r) {
  return $r->status === 'reviewed';
}));
$resolvedReports  = count(array_filter(\App\Models\Report::all(), function ($r) {
  return $r->status === 'resolved';
}));

// Example dummy data for monthly reports (replace with dynamic data)
$months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
$monthlyReports = [5, 8, 12, 10, 15, 20, 18, 22, 19, 14, 9, 7];

// Retrieve recent reports and recent requests (last 5 of each)
$allReports = \App\Models\Report::all();
$recentReports = array_slice($allReports, -5); // Assuming ordered by submission time

$allRequests = \App\Models\RequestPoint::all();
$recentRequests = array_slice($allRequests, -5);

// Dummy detailed recent activity logs as an array of associative arrays:
$recentActivities = [
  ['time' => '2023-03-15 10:30', 'type' => 'بلاغ', 'detail' => 'تمت مراجعة بلاغ رقم 12.'],
  ['time' => '2023-03-15 09:45', 'type' => 'مستخدم', 'detail' => 'تم إضافة مستخدم جديد (ID: 5).'],
  ['time' => '2023-03-14 16:20', 'type' => 'FAQ', 'detail' => 'تم تحديث الأسئلة الشائعة.'],
  ['time' => '2023-03-14 15:05', 'type' => 'طلب نقاط', 'detail' => 'تم قبول طلب نقاط للمستخدم (ID: 3).'],
  ['time' => '2023-03-13 11:15', 'type' => 'مهمة', 'detail' => 'تم إضافة مهمة جديدة في التحدي (ID: 7).']
];
?>
<!-- Chart Initialization Script -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar Chart: Overall Statistics
    const dashboardBarChartEl = document.getElementById('dashboardBarChart');
    if (dashboardBarChartEl) {
      const ctxBar = dashboardBarChartEl.getContext('2d');
      new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: ['المستخدمين', 'البلاغات', 'الأسئلة', 'طلبات النقاط', 'المهام', 'المواقع', 'الجهات', 'المسؤولين'],
          datasets: [{
            label: 'الإحصائيات',
            data: [<?= $userCount; ?>, <?= $reportCount; ?>, <?= $faqCount; ?>, <?= $requestCount; ?>, <?= $challengeCount; ?>, <?= $locationCount; ?>, <?= $authorityCount; ?>, <?= $adminCount; ?>],
            backgroundColor: [
              'rgba(16, 185, 129, 0.8)',
              'rgba(5, 150, 105, 0.8)',
              'rgba(16, 185, 129, 0.8)',
              'rgba(5, 150, 105, 0.8)',
              'rgba(16, 185, 129, 0.8)',
              'rgba(5, 150, 105, 0.8)',
              'rgba(16, 185, 129, 0.8)',
              'rgba(5, 150, 105, 0.8)'
            ],
            borderColor: [
              'rgba(16, 185, 129, 1)',
              'rgba(5, 150, 105, 1)',
              'rgba(16, 185, 129, 1)',
              'rgba(5, 150, 105, 1)',
              'rgba(16, 185, 129, 1)',
              'rgba(5, 150, 105, 1)',
              'rgba(16, 185, 129, 1)',
              'rgba(5, 150, 105, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

    // Doughnut Chart: Report Status Breakdown
    const reportStatusChartEl = document.getElementById('reportStatusChart');
    if (reportStatusChartEl) {
      const ctxDoughnut = reportStatusChartEl.getContext('2d');
      new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
          labels: ['قيد الانتظار', 'تمت المراجعة', 'محلولة'],
          datasets: [{
            data: [<?= $pendingReports; ?>, <?= $reviewedReports; ?>, <?= $resolvedReports; ?>],
            backgroundColor: [
              'rgba(255, 193, 7, 0.8)',
              'rgba(23, 162, 184, 0.8)',
              'rgba(40, 167, 69, 0.8)'
            ],
            borderColor: [
              'rgba(255, 193, 7, 1)',
              'rgba(23, 162, 184, 1)',
              'rgba(40, 167, 69, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    // Line Chart: Monthly Reports
    const monthlyReportsChartEl = document.getElementById('monthlyReportsChart');
    if (monthlyReportsChartEl) {
      const ctxLine = monthlyReportsChartEl.getContext('2d');
      new Chart(ctxLine, {
        type: 'line',
        data: {
          labels: <?= json_encode($months); ?>,
          datasets: [{
            label: 'بلاغات شهرية',
            data: <?= json_encode($monthlyReports); ?>,
            backgroundColor: 'rgba(16, 185, 129, 0.4)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  });
</script>
<!-- KPI Cards Section -->
<div class="grid grid-cols-1  md:grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
  <!-- Users Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-users text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $userCount; ?></h3>
        <p class="text-gray-600">المستخدمين</p>
      </div>
    </div>
  </div>
  <!-- Reports Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-file-alt text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $reportCount; ?></h3>
        <p class="text-gray-600">البلاغات</p>
      </div>
    </div>
  </div>
  <!-- FAQs Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-question-circle text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $faqCount; ?></h3>
        <p class="text-gray-600">الأسئلة الشائعة</p>
      </div>
    </div>
  </div>
  <!-- Request Points Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-hand-holding-usd text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $requestCount; ?></h3>
        <p class="text-gray-600">طلبات النقاط</p>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
  <!-- Challenges Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-tasks text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $challengeCount; ?></h3>
        <p class="text-gray-600">المهام</p>
      </div>
    </div>
  </div>
  <!-- Locations Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-map-marker-alt text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $locationCount; ?></h3>
        <p class="text-gray-600">المواقع</p>
      </div>
    </div>
  </div>
  <!-- Authorities Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-building text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $authorityCount; ?></h3>
        <p class="text-gray-600">الجهات</p>
      </div>
    </div>
  </div>
  <!-- Admins Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-user-shield text-green-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-green-700"><?= $adminCount; ?></h3>
        <p class="text-gray-600">المسؤولين</p>
      </div>
    </div>
  </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
  <!-- Bar Chart: Overall Statistics -->
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-2xl font-bold text-green-700 mb-4">إحصائيات عامة</h3>
    <div class="relative ">
      <canvas id="dashboardBarChart" style="width:100%; height:100%;"></canvas>
    </div>
  </div>
  <!-- Doughnut Chart: Report Status Breakdown -->
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-2xl font-bold text-green-700 mb-4">حالة البلاغات</h3>
    <div class="relative h-[300px]">
      <canvas id="reportStatusChart" style="width:100%; height:100%;"></canvas>
    </div>
  </div>
</div>

<!-- Line Chart: Monthly Reports -->
<div class="bg-white p-6 rounded-lg shadow mb-10">
  <h3 class="text-2xl font-bold text-green-700 mb-4 text-center">بلاغات شهرية</h3>
  <div class="relative h-[300px]">
    <canvas id="monthlyReportsChart" style="width:100%; height:100%;"></canvas>
  </div>
</div>





<!-- Recent Reports Table -->
<div class="mt-10 bg-white p-6 rounded-lg shadow mb-10">
  <h3 class="text-2xl font-bold text-green-700 mb-4">آخر البلاغات</h3>
  <?php if (!empty($recentReports)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">المستخدم</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">الوصف</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">الحالة</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">التاريخ</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($recentReports as $report): ?>
            <tr>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($report->id); ?></td>
              <td class="px-4 py-2 text-right">
                <?php
                $user = \App\Models\User::find($report->userId);
                echo $user ? htmlspecialchars($user->fullName) : 'غير متوفر';
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($report->description); ?></td>
              <td class="px-4 py-2 text-right text-nowrap">
                <?php
                $status = htmlspecialchars($report->status);
                if ($status == 'pending') {
                  echo '<span class="bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">قيد الانتظار</span>';
                } else if ($status == 'reviewed') {
                  echo '<span class="bg-blue-300 text-blue-800 px-2 py-1 rounded-full text-xs font-bold">تمت المراجعة</span>';
                } else if ($status == 'resolved') {
                  echo '<span class="bg-green-300 text-green-800 px-2 py-1 rounded-full text-xs font-bold">محلولة</span>';
                } else {
                  echo $status;
                }
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($report->submit); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-4 text-left">
      <a href="<?= route('admin.reports'); ?>" class="text-blue-600 hover:underline">عرض المزيد من البلاغات</a>
    </div>
  <?php else: ?>
    <p class="text-gray-600 text-center">لا توجد بلاغات حديثة.</p>
  <?php endif; ?>
</div>

<!-- Recent Requests Table -->
<div class="mt-10 bg-white p-6 rounded-lg shadow mb-10">
  <h3 class="text-2xl font-bold text-green-700 mb-4">آخر طلبات النقاط</h3>
  <?php if (!empty($recentRequests)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">المستخدم</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">النقاط المطلوبة</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">الحالة</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-green-700">التاريخ</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($recentRequests as $req): ?>
            <tr>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($req->id); ?></td>
              <td class="px-4 py-2 text-right">
                <?php
                $user = \App\Models\User::find($req->userId);
                echo $user ? htmlspecialchars($user->fullName) : 'غير متوفر';
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($req->pointsRequested); ?></td>
              <td class="px-2 py-2 text-right text-nowrap">
                <?php
                $status = htmlspecialchars($req->status);
                // Example badge logic for request status (adjust as needed)
                if ($status == 'pending') {
                  echo '<span class="bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">قيد الانتظار</span>';
                } else if ($status == 'approved') {
                  echo '<span class="bg-green-300 text-green-800 px-2 py-1 rounded-full text-xs font-bold">معتمد</span>';
                } else if ($status == 'denied') {
                  echo '<span class="bg-red-300 text-red-800 px-2 py-1 rounded-full text-xs font-bold">مرفوض</span>';
                } else {
                  echo $status;
                }
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($req->requestDate); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-4 text-left">
      <a href="<?= route('admin.requests'); ?>" class="text-blue-600 hover:underline">عرض المزيد من الطلبات</a>
    </div>
  <?php else: ?>
    <p class="text-gray-600 text-center">لا توجد طلبات نقاط حديثة.</p>
  <?php endif; ?>
</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin.php';
?>