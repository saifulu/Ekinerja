<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'admin@ekinerja.com';
$new = 'password';

$user = User::where('email', $email)->first();
if (! $user) {
    echo "USER_NOT_FOUND\n";
    exit(2);
}

$user->password = $new;
$user->save();

echo "OK: updated password for {$email}\n";
echo "stored_hash: " . $user->password . "\n";
