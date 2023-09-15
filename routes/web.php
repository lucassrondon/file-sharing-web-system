<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\DocumentList;
use App\Http\Livewire\DocumentUpdate;
use App\Http\Livewire\DocumentUpload;
use App\Http\Livewire\DocumentDetails;

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

Route::get('/', function () {
    return view('landing-page');
});

/* Auth routes */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get(
        '/document-upload', 
        DocumentUpload::class
    )->name('document-upload');

    Route::get(
        '/your-uploads', 
        DocumentList::class
    )->name('your-uploads');
    
    Route::get(
        '/document-update/{document}', 
        DocumentUpdate::class
    )->name('document-update')
     ->middleware('owns.document');

    Route::get(
        '/document-details/{document}', 
        DocumentDetails::class
    )->name('document-details');
});


/* php artisan serve --host=0.0.0.0 --port=8000 */