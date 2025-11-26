<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Buat user test
$user = User::updateOrCreate(
    ['email' => 'test@test.com'],
    [
        'username' => 'test',
        'email' => 'test@test.com',
        'password' => Hash::make('test123'),
        'level' => 'admin',
        'can_verify' => true
    ]
);

echo "User test berhasil dibuat!\n";
echo "Email: test@test.com\n";
echo "Password: test123\n";
echo "Level: admin\n";