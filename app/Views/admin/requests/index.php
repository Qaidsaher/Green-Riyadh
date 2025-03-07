<?php
$active = 'admin.requests';
$title = 'إدارة طلبات النقاط - لوحة الإدارة';
ob_start();

// Retrieve all point requests from your RequestPoint model
$requests = \App\Models\RequestPoint::all();
?>

<div class="bg-white p-6 rounded-lg shadow-xl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-green-700">إدارة طلبات النقاط</h2>
  </div>

  <?php if (!empty($requests)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-50">
          <tr>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الرقم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">المستخدم</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">النقاط المطلوبة</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">حالة الطلب</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">تاريخ الطلب</th>
            <th class="px-6 py-3 text-right text-sm font-bold text-green-700">الإجراءات</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($requests as $req): ?>
            <tr>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($req->id); ?></td>
              <td class="px-6 py-4 text-right">
                <?php
                $user = \App\Models\User::find($req->userId);
                echo $user ? htmlspecialchars($user->fullName) : 'غير متوفر';
                ?>
              </td>
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($req->pointsRequested); ?></td>

              <td class="px-6 py-4 text-right">
                <?php if ($req->status == 'approved'): ?>
                  <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                    مقبول
                  </span>
                <?php else: ?>
                  <form action="<?= route('admin.requests.update_status', ['id' => $req->id]); ?>" method="POST" class="inline-block">
                    <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded p-1 text-sm">
                      <option value="pending" <?= $req->status == 'pending' ? 'selected' : ''; ?>>قيد الانتظار</option>
                      <option value="approved" <?= $req->status == 'approved' ? 'selected' : ''; ?>>مقبول</option>
                      <option value="denied" <?= $req->status == 'denied' ? 'selected' : ''; ?>>مرفوض</option>
                    </select>
                  </form>
                <?php endif; ?>
              </td>

             
              <td class="px-6 py-4 text-right"><?= htmlspecialchars($req->requestDate); ?></td>
              <td class="px-6 py-4 text-right">
                <a href="<?= route('admin.requests.delete', ['id' => $req->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف الطلب؟')" class="text-red-600 hover:underline">
                  <i class="fas fa-trash-alt ml-1"></i> حذف
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-600">لا توجد طلبات نقاط مسجلة بعد.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/admin.php';
