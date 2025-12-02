<?php

use App\Livewire\RegistrationForm;
use App\Models\Participant;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', RegistrationForm::class);

Route::get('/verify-email/{id}', function (Request $request, $id) {
    if (! $request->hasValidSignature()) {
        abort(403, 'Link kadaluarsa atau tidak valid.');
    }

    $participant = Participant::findOrFail($id);
    
    // Update kolom email_verified_at
    if (!$participant->email_verified_at) {
        $participant->update(['email_verified_at' => now()]);
    }

    return "<h1>Email Berhasil Diverifikasi! ✅</h1><p>Terima kasih, data pendaftaran Anda sekarang sudah lengkap.</p>";
})->name('participant.verify');