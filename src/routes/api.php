<?php
use App\Models\User;
use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});

Route::post('/api-login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/test-post', [ProfileController::class, 'TestAPI']);
});

Route::get('/test-job', function () {
    dispatch(new TestJob());
    return response()->json(['message' => 'job dispatched']);
});
