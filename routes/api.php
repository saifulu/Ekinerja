// ... existing code ...

// Unit Ruangan routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('unit-ruangan', App\Http\Controllers\Api\UnitRuanganController::class);
});

// ... existing code ...