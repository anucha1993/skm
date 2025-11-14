<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Permission;

$permissions = [
    'finance-view' => 'ข้อมูลการเงิน',
    'finance-manage' => 'ข้อมูลการเงิน',
];

foreach ($permissions as $name => $view) {
    $p = Permission::where('name', $name)->first();
    if ($p) {
        $p->update(['name_view' => $view]);
        echo "✓ Updated {$name}\n";
    }
}

echo "✓ Done\n";
