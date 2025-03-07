<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'صفحة الزائر'; ?></title>
  <!-- Google Fonts for Arabic (Cairo) -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <style> body { font-family: 'Cairo', sans-serif; } </style>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-green-50">
  <!-- Navbar -->
  <header>
    <nav class="bg-gradient-to-r from-green-600 to-green-700 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->

          <div class="flex-shrink-0">
            <a href="<?= route(name: 'home'); ?>" class="text-3xl font-bold text-white">
              <i class="fas fa-leaf mr-2"></i> الرياض الخضراء
            </a>
          </div>
          <!-- Desktop Menu -->
          <div class="hidden md:flex space-x-6">
            <a href="<?= route('home'); ?>" class="text-white px-3 py-2 rounded-md mx-1 <?= ($active=='home') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">الرئيسية</a>
            <a href="<?= route('about'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='about') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">من نحن</a>
            <a href="<?= route('contact'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='contact') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">اتصل بنا</a>
          
            <?php if(auth()->check()): ?>
              <a href="<?= route(name: 'user.reports'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='profile') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">البلاغات</a>

              <a href="<?= route(name: 'user.profile'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='profile') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">ملفي</a>
              <a href="<?= route('dashboard'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='dashboard') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">لوحة التحكم</a>
              <a href="<?= route('logout'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='logout') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">تسجيل الخروج</a>
            <?php else: ?>
              <a href="<?= route('login'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='login') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">تسجيل الدخول</a>
              <a href="<?= route('register'); ?>" class="text-white px-3 py-2 rounded-md <?= ($active=='register') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">إنشاء حساب</a>
            <?php endif; ?>
          </div>
          <!-- Mobile Menu Button -->
          <div class="md:hidden">
            <button id="mobile-menu-button" class="text-white focus:outline-none">
              <i class="fas fa-bars text-2xl"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Mobile Menu -->
      <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <a href="<?= route('home'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='home') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">الرئيسية</a>
          <a href="<?= route('about'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='about') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">من نحن</a>
          <a href="<?= route('contact'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='contact') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">اتصل بنا</a>
          <?php if(auth()->check()): ?>
            <a href="<?= route('profile'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='profile') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">ملفي</a>
            <a href="<?= route('dashboard'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='dashboard') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">لوحة التحكم</a>
            <a href="<?= route('logout'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='logout') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">تسجيل الخروج</a>
          <?php else: ?>
            <a href="<?= route('login'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='login') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">تسجيل الدخول</a>
            <a href="<?= route('register'); ?>" class="block text-white px-3 py-2 rounded-md <?= ($active=='register') ? 'bg-green-800' : 'hover:bg-green-800'; ?>">إنشاء حساب</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="min-h-screen">
    <?= $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-green-600">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
      <!-- Quick Links -->
      <div>
        <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
        <ul>
          <li><a href="<?= route('home'); ?>" class="hover:underline">الرئيسية</a></li>
          <li><a href="<?= route('about'); ?>" class="hover:underline">من نحن</a></li>
          <li><a href="<?= route('contact'); ?>" class="hover:underline">اتصل بنا</a></li>
          <li><a href="<?= route('faq'); ?>" class="hover:underline">الأسئلة الشائعة</a></li>
        </ul>
      </div>
      <!-- Info Links -->
      <div>
        <h3 class="text-xl font-bold mb-4">معلومات</h3>
        <ul>
          <li><a href="<?= route('privacy'); ?>" class="hover:underline">سياسة الخصوصية</a></li>
          <li><a href="<?= route('terms'); ?>" class="hover:underline">الشروط والأحكام</a></li>
        </ul>
      </div>
      <!-- Social & Contact -->
      <div>
        <h3 class="text-xl font-bold mb-4">تواصل معنا</h3>
        <div class="flex space-x-4">
          <a href="#" class="hover:text-green-200"><i class="fab fa-facebook-f text-2xl"></i></a>
          <a href="#" class="hover:text-green-200"><i class="fab fa-twitter text-2xl"></i></a>
          <a href="#" class="hover:text-green-200"><i class="fab fa-instagram text-2xl"></i></a>
          <a href="#" class="hover:text-green-200"><i class="fab fa-whatsapp text-2xl"></i></a>
        </div>
      </div>
    </div>
    <div class="bg-green-700 py-4">
      <p class="text-center  text-white text-sm">&copy; <?= date('Y'); ?> الرياض الخضراء. جميع الحقوق محفوظة.</p>
    </div>
  </footer>

  <script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
