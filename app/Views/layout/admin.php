<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= isset($title) ? $title : 'لوحة الإدارة - الرياض الخضراء'; ?>
  </title>
  <!-- Google Fonts for Arabic (Cairo) -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="<?= asset('css/output.css') ?>" rel="stylesheet">
  <!-- Tailwind CSS & Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Leaflet CSS & JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <style>
    body {
      font-family: 'Cairo', sans-serif;
    }
  </style>
</head>

<body class="bg-green-50">
  <div class="flex h-screen overflow-hidden">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 bg-green-700 text-white">
        <div class="flex items-center justify-center h-16 border-b border-green-800">
          <a href="<?= route('admin.home'); ?>" class="text-2xl font-bold flex items-center">
            <i class="fas fa-leaf ml-3"></i> الرياض الخضراء
          </a>
        </div>
        <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
          <a href="<?= route('admin.home'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.home') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-home ml-3"></i><span>الرئيسية</span>
          </a>
          <a href="<?= route('admin.users'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.users') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-users ml-3"></i><span>المستخدمين</span>
          </a>
          <a href="<?= route('admin.reports'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.reports') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-file-alt ml-3"></i><span>البلاغات</span>
          </a>
          <a href="<?= route('admin.requests'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.requests') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-hand-holding-usd ml-3"></i><span>طلبات النقاط</span>
          </a>
          <a href="<?= route('admin.challenges'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.challenges') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-tasks ml-3"></i><span>المهام</span>
          </a>
          <a href="<?= route('admin.locations'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.locations') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-map-marker-alt ml-3"></i><span>المواقع</span>
          </a>
          <a href="<?= route('admin.authorities'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.authorities') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-building ml-3"></i><span>الجهات</span>
          </a>
          <a href="<?= route('admin.admins'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.admins') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-user-shield ml-3"></i><span>المسؤولين</span>
          </a>
          <a href="<?= route('admin.faqs'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.faqs') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-question-circle ml-3"></i><span>الأسئلة الشائعة</span>
          </a>
          <a href="<?= route('admin.comments'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.comments') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-comments ml-3"></i><span>التعليقات</span>
          </a>
          <a href="<?= route('admin.statistics'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.statistics') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-chart-line ml-3"></i><span>الإحصائيات</span>
          </a>
          <a href="<?= route('logout'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'logout') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-sign-out-alt ml-3"></i><span>تسجيل الخروج</span>
          </a>
        </nav>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 overflow-auto">
      <!-- Mobile Topbar -->
      <header class="md:hidden flex items-center justify-between bg-green-700 px-4 py-4">
        <a href="<?= route('admin.home'); ?>" class="text-xl font-bold text-white flex items-center">
          <i class="fas fa-leaf ml-2"></i> الرياض الخضراء
        </a>
        <button id="mobileSidebarToggle" class="text-white focus:outline-none">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </header>
      <!-- Mobile Sidebar Panel -->
      <div id="mobileSidebar"
        class="fixed inset-y-0 right-0 w-64 bg-green-700 text-white transform translate-x-full transition duration-300 ease-in-out md:hidden">
        <div class="flex items-center justify-center h-16 border-b border-green-800">
          <a href="<?= route('admin.home'); ?>" class="text-2xl font-bold flex items-center">
            <i class="fas fa-leaf ml-2"></i> الرياض الخضراء
          </a>
        </div>
        <nav class="px-2 py-4 space-y-2">
          <a href="<?= route('admin.home'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.home') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-home ml-3"></i><span>الرئيسية</span>
          </a>
          <a href="<?= route('admin.users'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.users') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-users ml-3"></i><span>المستخدمين</span>
          </a>
          <a href="<?= route('admin.reports'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.reports') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-file-alt ml-3"></i><span>البلاغات</span>
          </a>
          <a href="<?= route('admin.requests'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.requests') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-hand-holding-usd ml-3"></i><span>طلبات النقاط</span>
          </a>
          <a href="<?= route('admin.challenges'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.challenges') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-tasks ml-3"></i><span>المهام</span>
          </a>
          <a href="<?= route('admin.locations'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.locations') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-map-marker-alt ml-3"></i><span>المواقع</span>
          </a>
          <a href="<?= route('admin.authorities'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.authorities') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-building ml-3"></i><span>الجهات</span>
          </a>
          <a href="<?= route('admin.admins'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.admins') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-user-shield ml-3"></i><span>المسؤولين</span>
          </a>
          <a href="<?= route('admin.faqs'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.faqs') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-question-circle ml-3"></i><span>الأسئلة الشائعة</span>
          </a>
          <a href="<?= route('admin.comments'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.comments') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-comments ml-3"></i><span>التعليقات</span>
          </a>
          <a href="<?= route('admin.statistics'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.statistics') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-chart-line ml-3"></i><span>الإحصائيات</span>
          </a>
          <a href="<?= route('logout'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'logout') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">
            <i class="fas fa-sign-out-alt ml-3"></i><span>تسجيل الخروج</span>
          </a>
        </nav>
      </div>
      <!-- Main Form Content -->

      <main>
        <div
          class="bg-green-600 text-white px-6 py-4 border-b border-green-800 hidden md:flex justify-between items-center">
          <h1 class="text-2xl font-bold">
            <?= isset($title) ? $title : 'لوحة الإدارة'; ?>
          </h1>
        </div>
        <div class="p-6">
          <?= $content; ?>

        </div>
      </main>
    </div>
  </div>
  </div>
  <!-- Footer -->
  <footer class="bg-green-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center">
      <p class="flex text-center px-8">&copy;
        <?= date('Y'); ?> لوحة الإدارة - الرياض الخضراء. جميع الحقوق محفوظة.
      </p>
      <div class="space-x-4">
        <a href="#" class="hover:text-green-200"><i class="fab fa-facebook-f text-xl mx-2"></i></a>
        <a href="#" class="hover:text-green-200"><i class="fab fa-twitter text-xl mx-2"></i></a>
        <a href="#" class="hover:text-green-200"><i class="fab fa-instagram text-xl"></i></a>
      </div>
    </div>
  </footer>
  <!-- Map Initialization Script -->
  <!-- Success & Error Messages -->
  <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div id="alert-container"style="left:0px" class="fixed top-5  z-50 m-5  p-4">
      <?php if (isset($_SESSION['success'])): ?>
        <div id="success-alert" class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-lg transition-opacity duration-500 ease-in-out">
          <i class="fas fa-check-circle text-xl mx-2"></i>
          <span class="mx-4"><?= $_SESSION['success']; ?></span>
          <button onclick="closeAlert('success-alert')" class="mx-2 text-lg text-green-800 hover:text-green-900">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div id="error-alert" class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-lg transition-opacity duration-500 ease-in-out">
          <i class="fas fa-exclamation-circle text-xl mx-2"></i>
          <span class="mx-4"><?= $_SESSION['error']; ?></span>
          <button onclick="closeAlert('error-alert')" class="mx-2 text-lg text-red-800 hover:text-red-900">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <script>
    // Function to close alert manually
    function closeAlert(id) {
      document.getElementById(id).classList.add("opacity-0");
      setTimeout(() => document.getElementById(id).remove(), 500);
    }

    // Auto-hide alert messages after 5 seconds
    setTimeout(() => {
      document.querySelectorAll("#alert-container div").forEach((alert) => {
        alert.classList.add("opacity-0");
        setTimeout(() => alert.remove(), 500);
      });
    }, 5000);
  </script>
  <script>
    // Mobile sidebar toggle functionality
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    mobileSidebarToggle && mobileSidebarToggle.addEventListener('click', () => {
      mobileSidebar.classList.toggle('translate-x-full');
    });
  </script>
</body>

</html>