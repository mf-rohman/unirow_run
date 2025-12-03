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

Route::get('/', function () {
    return view('landing'); // Kita akan buat file ini setelah ini
})->name('home');

// 2. Halaman Form Pendaftaran (Form yang kemarin)
Route::get('/register', RegistrationForm::class)->name('register');

Route::get('/verify-email/{id}', function (Request $request, $id) {
    if (! $request->hasValidSignature()) {
        // Tampilan Error yang cantik jika link expired
        abort(403, 'Link verifikasi sudah kadaluarsa atau tidak valid.');
    }

    $participant = Participant::findOrFail($id);
    
    // Update status jika belum
    if (!$participant->email_verified_at) {
        $participant->update(['email_verified_at' => now()]);
    }

    // Return ke View yang cantik
    return view('pages.verify-success', compact('participant'));

})->name('participant.verify');