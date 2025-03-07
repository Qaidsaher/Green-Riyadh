<?php
$active = 'user.requests';
$title = 'طلباتي - لوحة المستخدم';
ob_start();

// $requests array passed from the controller
$requests = $requests ?? [];
$currentUser = auth()->user();

// Function to translate status into Arabic
function getArabicStatus($status)
{
    switch (strtolower($status)) {
        case 'pending':
            return 'قيد الانتظار';
        case 'approved':
            return 'مقبول';
        case 'denied':
            return 'مرفوض';
        default:
            return 'غير معروف';
    }
}

// Helper functions for styling based on status
function getStatusBorderClass($status)
{
    switch (strtolower($status)) {
        case 'pending':
            return 'border-yellow-500';
        case 'approved':
            return 'border-green-500';
        case 'denied':
            return 'border-red-500';
        default:
            return 'border-gray-200';
    }
}

function getStatusBadgeClass($status)
{
    switch (strtolower($status)) {
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'approved':
            return 'bg-green-100 text-green-800';
        case 'denied':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
?>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between my-4">
        <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">طلباتي للنقاط</h2>
        <div class="text-center">
            <a href="<?= route('user.requests.create'); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded transition">
                طلب نقاط جديدة
            </a>
        </div>
    </div>

    <?php if (!empty($requests)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($requests as $req):
                $borderClass = getStatusBorderClass($req->status);
                $badgeClass = getStatusBadgeClass($req->status);
            ?>
                <div class="bg-white p-6 rounded-lg shadow border-2 <?= $borderClass; ?>">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-green-700">طلب رقم <?= htmlspecialchars($req->id); ?></h3>
                    </div>
                    <div class="mb-2">
                        <p class="text-gray-700"><span class="font-bold">النقاط المطلوبة:</span> <?= htmlspecialchars($req->pointsRequested); ?></p>
                    </div>
                    <div class="mb-2">
                        <p class="text-gray-700">
                            <span class="font-bold">الحالة:</span>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass; ?>">
                                <?= getArabicStatus($req->status); ?>
                            </span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <p class="text-gray-700"><span class="font-bold">تاريخ الطلب:</span> <?= htmlspecialchars($req->requestDate); ?></p>
                    </div>
                    <?php if (!empty($req->message)): ?>
                        <div class="mb-2">
                            <p class="text-gray-700"><span class="font-bold">الملاحظات:</span> <?= htmlspecialchars($req->message); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="mt-4 flex justify-end space-x-4">
                        <?php if ($req->userId === $currentUser->id): ?>
                            <a href="<?= route('user.requests.delete', ['id' => $req->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف الطلب؟')" class="mx-1 flex items-center text-red-600 hover:underline">
                                <i class="fas fa-trash-alt ml-1"></i> حذف
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center">لم تقدم أي طلبات نقاط حتى الآن.</p>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
?>