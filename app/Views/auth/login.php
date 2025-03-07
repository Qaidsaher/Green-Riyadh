<?php
$active = 'login';
$title  = 'تسجيل الدخول - الرياض الخضراء';
ob_start();
?>
<div class="min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md rounded-lg shadow-xl overflow-hidden">
    <div class="p-8">
      <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-green-700">تسجيل الدخول</h2>
        <p class="mt-2 text-sm text-gray-600">سجل دخولك كـ Admin أو User</p>
      </div>

      <?php if (isset($_SESSION['error'])): ?>
        <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['error'];
          unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div role="alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['success'];
          unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form action="<?= route('login'); ?>" method="POST" id="loginForm" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
          <input type="email" name="email" id="email" required placeholder="example@example.com" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600" autocomplete="off">
        </div>
        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
          <input type="password" name="password" id="password" required placeholder="********" class="mt-1 block w-full p-2 pl-10 border border-gray-300 rounded focus:outline-none focus:ring focus:border-green-600" autocomplete="off">
          <button type="button" id="togglePassword" aria-label="Toggle Password Visibility" class="absolute inset-y-0 left-0 pl-3 top-5 flex items-center text-gray-500">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <fieldset>
          <legend class="block text-sm font-medium text-gray-700">تسجيل الدخول كـ</legend>
          <div class="flex space-x-4 mt-2">
            <button type="button" id="btnUser"
              class="py-1 px-4 rounded border border-green-600 text-green-600 transition-all duration-300 mx-2"
              onclick="selectRole('user')">
              مستخدم
            </button>
            <button type="button" id="btnAdmin"
              class="py-1 px-4 rounded border border-yellow-600 text-yellow-600 transition-all duration-300 mx-2"
              onclick="selectRole('admin')">
              مسؤول
            </button>
          </div>
          <input type="hidden" name="user_type" id="user_type" value="user">
        </fieldset>

        <div class="flex justify-end">
          <button type="submit" class="px-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded transition duration-300">
            تسجيل الدخول
          </button>
        </div>
      </form>
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
          ليس لديك حساب؟ <a href="<?= route('register'); ?>" class="text-blue-600 hover:underline">إنشاء حساب</a>
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  function selectRole(role) {
    document.getElementById("user_type").value = role;

    if (role === "user") {
      document.getElementById("btnUser").classList.add("bg-green-600", "text-white");
      document.getElementById("btnUser").classList.remove("border", "border-green-600", "text-green-600");

      document.getElementById("btnAdmin").classList.add("border", "border-yellow-600", "text-yellow-600");
      document.getElementById("btnAdmin").classList.remove("bg-yellow-600", "text-white");
    } else {
      document.getElementById("btnAdmin").classList.add("bg-yellow-600", "text-white");
      document.getElementById("btnAdmin").classList.remove("border", "border-yellow-600", "text-yellow-600");

      document.getElementById("btnUser").classList.add("border", "border-green-600", "text-green-600");
      document.getElementById("btnUser").classList.remove("bg-green-600", "text-white");
    }
  }

  // Toggle password visibility
  (function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
      const isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
      this.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
    });
  })();

  // On page load, ensure the user button is selected
  document.addEventListener('DOMContentLoaded', function() {
    selectRole('user');
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/guest.php';
?>
