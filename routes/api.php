<?php

use App\Auth\CustomSanctumUser;
use App\Http\Controllers\Api\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', function (Request $request) {
    $param = $request->all();

    // Panggil stored procedure
    $user = DB::select('EXEC sp_Login :nik, :pw', [
        'nik' => $param['nik'],
        'pw'  => $param['pass']
    ]);

    if (count($user) !== 1) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $userData = $user[0];

    // Ambil ID dari tabel gm_user
    $userId = DB::table('gm_user')->where('nik', $param['nik'])->value('id');

    if (!$userId) {
        return response()->json(['message' => 'User ID not found'], 404);
    }

    // 1. Generate token plaintext
    $plainTextToken = Str::random(40);

    // 2. Hash token sesuai standar Sanctum
    $hashedToken = hash('sha256', $plainTextToken);
    $customuser = new CustomSanctumUser();
    $customuser->forceFill([
        'id' => $userId,
        'nik' => $user[0]->nik,
        'nama' => $user[0]->nama
    ]);
    // 3. Simpan token ke tabel Sanctum
    DB::table('personal_access_tokens')->insert([
        'tokenable_type' => 'App\Auth\CustomSanctumUser', // atau App\Models\User kalau pakai model default
        'tokenable_id' => $userId,
        'name' => 'api-token',
        'token' => $hashedToken,
        'abilities' => json_encode(['*']),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 4. Return token plaintext untuk client
    return response()->json([
        'token' => $plainTextToken,
        'user' => [
            'id' => $userId,
            'nik' => $userData->nik,
            'nama' => $userData->nama,
        ],
    ]);
});

Route::controller(Dashboard::class)->group(function () {
    Route::get('/list-menu-system/{id}', 'listMenuSystem');
});