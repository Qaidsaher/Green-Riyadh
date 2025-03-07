<?php
$active = 'update_password';
$title = 'تحديث كلمة المرور - الرياض الخضراء';
ob_start();
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl mt-10">
  <h2 class="text-3xl font-bold text-green-700 mb-6 ">تحديث كلمة المرور</h2>
  <?php
  if (isset($_SESSION['error'])) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
  }
  
  ?>
  <form action="<?= route('user.update_password'); ?>" method="POST" class="space-y-6" id="updatePasswordForm">

    <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
      <div class="relative">
        <label for="current_password" class="block text-sm font-medium text-gray-700">كلمة المرور الحالية</label>
        <input type="password" id="current_password" name="current_password" required placeholder="********" class="mt-1 w-full p-2 pl-10 border rounded-md focus:outline-none focus:ring focus:border-green-600">
        <button type="button" id="toggleCurrentPassword" class="absolute inset-y-0 left-4  top-5 flex items-center text-gray-500">
          <i class="fas fa-eye"></i>
        </button>
      </div>
      <div class="relative">
        <label for="new_password" class="block text-sm font-medium text-gray-700">كلمة المرور الجديدة</label>
        <input type="password" id="new_password" name="new_password" required placeholder="********" class="mt-1 w-full p-2 pl-10 border rounded-md focus:outline-none focus:ring focus:border-green-600">
        <button type="button" id="toggleNewPassword" class="absolute inset-y-0 left-4  top-5 flex items-center text-gray-500">
          <i class="fas fa-eye"></i>
        </button>
      </div>

    </div>

    <div class="flex justify-end">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
        تحديث كلمة المرور
      </button>
    </div>
  </form>
</div>

<script>
  // Toggle current password visibility
  const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
  const currentPasswordInput = document.getElementById('current_password');
  toggleCurrentPassword.addEventListener('click', function() {
    const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    currentPasswordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
  });

  // Toggle new password visibility
  const toggleNewPassword = document.getElementById('toggleNewPassword');
  const newPasswordInput = document.getElementById('new_password');
  toggleNewPassword.addEventListener('click', function() {
    const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    newPasswordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
