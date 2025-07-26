<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\PropertyApiController;
use App\Http\Controllers\Api\TenancyApiController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\LeadApiController;
use App\Http\Controllers\Api\FinancialApiController;
use App\Http\Controllers\Api\DiaryEventApiController;
use App\Http\Controllers\PropertyAssignController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('contacts/{contact}/assign-property', [PropertyAssignController::class, 'assign'])->name('contacts.assignProperty');
Route::get('properties/search-unassigned', [PropertyAssignController::class, 'search'])->name('properties.searchUnassigned');

Route::resource('properties', PropertyController::class);
Route::get('contacts/search', [App\Http\Controllers\ContactController::class, 'search'])->name('contacts.search');
Route::resource('contacts', ContactController::class);
Route::post('contacts/bulk', [ContactController::class, 'bulk'])->name('contacts.bulk');

// Property media routes
Route::post('properties/{property}/media', [App\Http\Controllers\PropertyMediaController::class, 'store'])->name('properties.media.store');
Route::delete('properties/{property}/media/{media}', [App\Http\Controllers\PropertyMediaController::class, 'destroy'])->name('properties.media.destroy');

Route::view('/diary', 'diary')->name('diary');
Route::view('/accounts', 'accounts')->name('accounts');
Route::view('/settings', 'settings')->name('settings');
Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
Route::resource('payments', App\Http\Controllers\PaymentController::class);

Route::prefix('api')->group(function () {
    Route::apiResource('contacts', ContactApiController::class)->names('api.contacts');
    Route::apiResource('properties', PropertyApiController::class)->names('api.properties');
    Route::apiResource('tenancies', TenancyApiController::class)->names('api.tenancies');
    Route::apiResource('tasks', TaskApiController::class)->names('api.tasks');
    Route::apiResource('leads', LeadApiController::class)->names('api.leads');
    Route::apiResource('financials', FinancialApiController::class)->names('api.financials');
    Route::apiResource('diary-events', DiaryEventApiController::class)->names('api.diary-events');
});

Route::post('contacts/{contact}/add-note', [ContactController::class, 'addNote'])->name('contacts.addNote');
Route::post('contacts/{contact}/add-communication', [ContactController::class, 'addCommunication'])->name('contacts.addCommunication');
Route::post('contacts/{contact}/add-viewing', [ContactController::class, 'addViewing'])->name('contacts.addViewing');
Route::delete('contacts/{contact}/note/{note}', [ContactController::class, 'deleteNote'])->name('contacts.deleteNote');
Route::delete('contacts/{contact}/communication/{communication}', [ContactController::class, 'deleteCommunication'])->name('contacts.deleteCommunication');
Route::delete('contacts/{contact}/viewing/{viewing}', [ContactController::class, 'deleteViewing'])->name('contacts.deleteViewing');
Route::get('contacts/{contact}/note/{note}/edit', [ContactController::class, 'editNote'])->name('contacts.editNote');
Route::put('contacts/{contact}/note/{note}', [ContactController::class, 'updateNote'])->name('contacts.updateNote');
Route::get('contacts/{contact}/communication/{communication}/edit', [ContactController::class, 'editCommunication'])->name('contacts.editCommunication');
Route::put('contacts/{contact}/communication/{communication}', [ContactController::class, 'updateCommunication'])->name('contacts.updateCommunication');
Route::get('contacts/{contact}/viewing/{viewing}/edit', [ContactController::class, 'editViewing'])->name('contacts.editViewing');
Route::put('contacts/{contact}/viewing/{viewing}', [ContactController::class, 'updateViewing'])->name('contacts.updateViewing');

Route::middleware('auth')->group(function () {
    Route::patch('api/contacts/{contact}/note/{note}', [ContactController::class, 'apiUpdateNote']);
    Route::delete('api/contacts/{contact}/note/{note}', [ContactController::class, 'apiDeleteNote']);
    Route::patch('api/contacts/{contact}/communication/{communication}', [ContactController::class, 'apiUpdateCommunication']);
    Route::delete('api/contacts/{contact}/communication/{communication}', [ContactController::class, 'apiDeleteCommunication']);
    Route::patch('api/contacts/{contact}/viewing/{viewing}', [ContactController::class, 'apiUpdateViewing']);
    Route::delete('api/contacts/{contact}/viewing/{viewing}', [ContactController::class, 'apiDeleteViewing']);
});

Route::post('properties/{property}/assign-landlord', [PropertyController::class, 'assignLandlord'])->name('properties.assignLandlord');

require __DIR__.'/auth.php';
