<?php
$active = 'edit_profile';
$title = 'تعديل الملف الشخصي - الرياض الخضراء';
ob_start();

$user = auth()->user();
$avatarPath = !empty($user->avatar) ? asset('uploads/avatars/' . $user->avatar) : asset('images/default-avatar.png');
?>

<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-xl mt-10">
  <h2 class="text-3xl font-bold text-green-700 mb-6 ">تعديل الملف الشخصي</h2>

  <?php
  if (isset($_SESSION['error'])) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
  }
  
  ?>

  <form action="<?= route('user.update_profile'); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- Avatar Upload -->
    <div class="flex flex-col  space-y-4 p-4">
      <label for="avatarInput" class="cursor-pointer">
        <img id="avatarPreview" src="<?= $avatarPath; ?>" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-gray-300 shadow-md object-cover">
      </label>
      <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*">
      <p class="text-xs text-gray-500">انقر على الصورة لتحديث الصورة الشخصية.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2  gap-6">

      <!-- Full Name -->
      <div>
        <label for="fullName" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
        <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($user->fullName); ?>" required class="mt-1 w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-green-600">
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email); ?>" required class="mt-1 w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-green-600">
      </div>

      <!-- Phone Number -->
      <div>
        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
        <input type="text" id="phoneNumber" name="phoneNumber" value="<?= htmlspecialchars($user->phoneNumber); ?>" class="mt-1 w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-green-600">
      </div>
    </div>


    <!-- Submit Button -->
    <div class="flex justify-end">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
        حفظ التغييرات
      </button>
    </div>
  </form>
</div>

<!-- Avatar Preview Script -->
<script>
  document.getElementById("avatarInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById("avatarPreview").src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
?>