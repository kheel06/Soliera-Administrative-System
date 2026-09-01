<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$contract = \App\Models\LegalContract::where('title', 'like', '%Service Level Agreement%')->first();
if ($contract) {
    // Determine if file exists
    if (file_exists(storage_path('app/public/contracts/mock_sla.pdf'))) {
        $contract->file_path = 'contracts/mock_sla.pdf';
        $contract->save();
        echo "Updated contract {$contract->id} with mock PDF.\n";
    } else {
        echo "Mock PDF not found at " . storage_path('app/public/contracts/mock_sla.pdf') . "\n";
    }
} else {
    echo "Contract not found.\n";
}
