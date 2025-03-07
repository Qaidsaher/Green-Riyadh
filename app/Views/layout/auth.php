<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($title) ? $title : 'لوحة المستخدم'; ?></title>
  <!-- Google Fonts for Arabic (Cairo) -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
    }

    html,
    body {
      overflow-x: hidden;
    }
  </style>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-green-50">
  <!-- Navbar -->
  <nav class="bg-green-600 text-white shadow">
    <div class="max-w-7xl mx-auto  py-4 flex justify-between items-center">
      <a href="<?= route('home'); ?>" class="text-3xl font-bold">
        <i class="fas fa-leaf mr-2"></i> الرياض الخضراء
      </a>
      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-2 items-center">
        <a href="<?= route('home'); ?>" class="px-3 py-2 rounded <?= ($active == 'home') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">الرئيسية</a>
        <a href="<?= route('user.reports'); ?>" class="px-3 py-2 rounded <?= ($active == 'user.reports') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">البلاغات</a>
        <a href="<?= route('user.reports.create'); ?>" class="px-3 py-2 rounded <?= ($active == 'user.reports.create') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">تقديم البلاغات</a>
        <a href="<?= route('user.reports.myreports'); ?>" class="px-3 py-2 rounded <?= ($active == 'user.reports.myreports') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">متابعة البلاغات</a>
        <a href="<?= route('user.requests'); ?>" class="px-3 py-2 rounded <?= ($active == 'user.requests') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">إدارة الطلبات</a>
        <a href="<?= route('user.challenges'); ?>" class="px-3 py-2 rounded <?= ($active == 'user.challenges') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">التحديات</a>
        <a href="<?= route('faq'); ?>" class="px-3 py-2 rounded <?= ($active == 'faq') ? 'bg-green-700' : 'hover:bg-green-700'; ?>">الأسئلة الشائعة</a>
      </div>
      <!-- User Menu Dropdown -->
      <div class="relative hidden md:block">
        <button id="userMenuButton" class="flex items-center focus:outline-none">
          <i class="fas fa-user-circle text-3xl text-blue-300"></i>
          <span class="mx-1"><?= auth()->user()->fullName ?? 'حسابي'; ?></span>
          <i class="fas fa-chevron-down ml-1"></i>
        </button>
        <div id="userMenuDropdown" class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded shadow-lg hidden z-50">
          <a href="<?= route('user.profile'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-user text-blue-500 ml-2"></i> ملفي
          </a>
          <a href="<?= route('user.edit_profile'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-edit text-purple-500 ml-2"></i> تعديل الملف
          </a>
          <a href="<?= route('user.requests'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-envelope-open-text text-orange-500 ml-2"></i> طلباتي
          </a>
          <a href="<?= route('user.challenges'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-tasks text-teal-500 ml-2"></i> التحديات
          </a>
          <a href="<?= route('user.delete_account'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-trash-alt text-red-500 ml-2"></i> حذف الحساب
          </a>
          <a href="<?= route('logout'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
            <i class="fas fa-sign-out-alt text-gray-500 ml-2"></i> تسجيل الخروج
          </a>
        </div>
      </div>
      <!-- Mobile Menu Toggle -->
      <div class="md:hidden">
        <button id="mobile-menu-button" class="focus:outline-none mx-4">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden">
      <a href="<?= route('home'); ?>" class="block px-4 py-2 hover:bg-green-700">الرئيسية</a>
      <a href="<?= route('dashboard'); ?>" class="block px-4 py-2 hover:bg-green-700">لوحة التحكم</a>
      <a href="<?= route('user.reports'); ?>" class="block px-4 py-2 hover:bg-green-700">بلاغاتي</a>
      <a href="<?= route('user.reports.create'); ?>" class="block px-4 py-2 hover:bg-green-700">تقديم البلاغات</a>
      <a href="<?= route('user.reports.myreports'); ?>" class="block px-4 py-2 hover:bg-green-700">متابعة البلاغات</a>
      <a href="<?= route('user.requests'); ?>" class="block px-4 py-2 hover:bg-green-700">إدارة الطلبات</a>
      <a href="<?= route('faq'); ?>" class="block px-4 py-2 hover:bg-green-700">الأسئلة الشائعة</a>
      <a href="<?= route('user.challenges'); ?>" class="block px-4 py-2 hover:bg-green-700">التحديات</a>
      <a href="<?= route('profile'); ?>" class="block px-4 py-2 hover:bg-green-700">ملفي</a>
      <a href="<?= route('user.edit_profile'); ?>" class="block px-4 py-2 hover:bg-green-700">تعديل الملف</a>
      <a href="<?= route('user.delete_account'); ?>" class="block px-4 py-2 hover:bg-green-700">حذف الحساب</a>
      <a href="<?= route('logout'); ?>" class="block px-4 py-2 hover:bg-green-700">تسجيل الخروج</a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8 min-h-screen">
    <?= $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-green-600 text-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center">
      <p>&copy; <?= date('Y'); ?> الرياض الخضراء. جميع الحقوق محفوظة.</p>
      <div class="flex space-x-4">
        <a href="#" class="hover:text-green-200"><i class="fab fa-facebook-f text-xl"></i></a>
        <a href="#" class="hover:text-green-200"><i class="fab fa-twitter text-xl"></i></a>
        <a href="#" class="hover:text-green-200"><i class="fab fa-instagram text-xl"></i></a>
      </div>
    </div>
  </footer>
  <!-- Success & Error Messages -->
  <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div id="alert-container" class="fixed top-5 left-5 z-50">
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
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // User menu dropdown toggle
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    userMenuButton && userMenuButton.addEventListener('click', (e) => {
      e.stopPropagation();
      userMenuDropdown.classList.toggle('hidden');
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userMenuDropdown.classList.contains('hidden')) {
        userMenuDropdown.classList.add('hidden');
      }
    });
  </script>
</body>

</html>