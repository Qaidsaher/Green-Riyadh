<?php
$active = 'user.reports';
$title = 'البلاغات - لوحة المستخدم';
ob_start();

// $reports array passed from the controller
$reports = $reports ?? [];
$currentUser = auth()->user();

// Define border color classes conditionally based on report status
function getBorderColor($status)
{
    switch ($status) {
        case 'active':
            return 'border-green-600';
        case 'pending':
            return 'border-yellow-500';
        case 'resolved':
            return 'border-blue-600';
        case 'reviewed':
            return 'border-indigo-600';
        default:
            return 'border-gray-400';
    }
}
?>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between my-4">
        <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">البلاغات</h2>
        <div class="text-center">
            <a href="<?= route('user.reports.create'); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded transition">
                إرسال بلاغ جديد
            </a>
        </div>
    </div>

    <?php if (!empty($reports)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($reports as $report): ?>
                <?php $borderColor = getBorderColor($report->status); ?>
                <div class="bg-white p-4 rounded-lg shadow border-2 <?= $borderColor; ?>">
                    
                    <!-- 🔥 Display the Report Title -->
                    <h3 class="text-lg font-bold text-green-700"><?= htmlspecialchars($report->title); ?></h3>  

                    <div class="mb-3">
                        <p class="text-gray-700 mt-2"><?= htmlspecialchars($report->description); ?></p>
                    </div>

                    <div class="text-sm text-gray-600">
                        <p><span class="font-bold">الحالة:</span> <?= htmlspecialchars($report->status); ?></p>
                        <p><span class="font-bold">تاريخ الإرسال:</span> <?= htmlspecialchars($report->submit); ?></p>
                    </div>

                    <div class="mt-4 flex justify-end space-x-4">
                        <!-- View Details Button -->
                        <a href="<?= route('user.reports.show', ['id' => $report->id]); ?>" class="flex items-center text-green-600 hover:underline">
                            <i class="fas fa-eye ml-1"></i> عرض التفاصيل
                        </a>
                        <!-- Delete Icon, only if current user is the owner -->
                        <?php if ($report->userId === $currentUser->id): ?>
                            <a href="<?= route('user.reports.delete_comment', ['id' => $report->id]); ?>" onclick="return confirm('هل أنت متأكد من حذف هذا البلاغ؟')" class="flex items-center text-red-600 hover:underline">
                                <i class="fas fa-trash-alt ml-1"></i> حذف
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center">لم تقم بإرسال بلاغات بعد.</p>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout/auth.php';
?>
