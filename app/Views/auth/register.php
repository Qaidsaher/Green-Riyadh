<?php
$active = 'register';
$title  = 'إنشاء حساب - الرياض الخضراء';
ob_start();
?>
<div class=" min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md  rounded-lg shadow-xl overflow-hidden">
    <div class="p-8">
      <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-green-700">إنشاء حساب جديد</h2>
        <p class="mt-2 text-sm text-gray-600">املأ البيانات لإنشاء حسابك</p>
      </div>

      <!-- Display messages if they exist -->
      <?php if (isset($_SESSION['error'])): ?>
        <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success'])): ?>
        <div role="alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form action="<?= route('register'); ?>" method="POST" id="registerForm" class="space-y-6">
        <div>
          <label for="fullName" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
          <input type="text" id="fullName" name="fullName" required placeholder="أدخل اسمك الكامل" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-600">
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
          <input type="email" id="email" name="email" required placeholder="example@example.com" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-600">
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
          <input type="text" id="phone" name="phoneNumber" placeholder="أدخل رقم هاتفك" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-600">
        </div>
        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
          <input type="password" id="password" name="password" required placeholder="********" class="mt-1 block w-full p-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-600">
          <button type="button" id="togglePasswordReg" aria-label="Toggle Password Visibility" class="absolute inset-y-0 left-0 px-3 top-4 flex items-center text-gray-500">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="px-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-md transition duration-300">
            إنشاء حساب
          </button>
        </div>
      </form>

      <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
          لديك حساب؟ <a href="<?= route('login'); ?>" class="text-blue-600 hover:underline">تسجيل الدخول</a>
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  // Toggle password visibility for register form
  (function() {
    const togglePasswordReg = document.getElementById('togglePasswordReg');
    const passwordInputReg = document.getElementById('password');
    
    togglePasswordReg.addEventListener('click', function () {
      const isPassword = passwordInputReg.getAttribute('type') === 'password';
      passwordInputReg.setAttribute('type', isPassword ? 'text' : 'password');
      this.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
    });
  })();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/guest.php';
?>
