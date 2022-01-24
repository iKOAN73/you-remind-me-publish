<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstantUserController;
use App\Http\Controllers\ReminderController;
use App\Models\InstantUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ReminderController::class, 'Reminder']);

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/test', function() {
//     return 'HELLO!!!!!';
// });

// Route::get('/InstantUser', [App\Http\Controllers\InstantUserController::class, 'index']);
Route::get('/InstantUser', [InstantUserController::class, 'index']);
Route::get('/UserList', [InstantUserController::class, 'list']);
Route::get('/NewUser', [InstantUserController::class, 'newUser']);

Route::get('/ResetSession', [InstantUserController::class, 'ForgetSession']);

Route::get('/AdminEditor', [ReminderController::class, 'AdminEditor']);
Route::get('/Reminder', [ReminderController::class, 'Reminder']);


Route::get('/GetTable', [ReminderController::class, 'LoadTable']);
Route::get('/GetReminder', [ReminderController::class, 'GetReminder']);
Route::get('/AddTask', [ReminderController::class, 'AddTask']);
Route::get('/GetEvaluateNotice', [ReminderController::class, 'GetEvaluateNotice']);
Route::get('/GetReactionsTable', [ReminderController::class, 'LoadReactionsTable']);
Route::get('/GetEvaluationsTable', [ReminderController::class, 'LoadEvaluationsTable']);
Route::get('/GetTaskContentsTable', [ReminderController::class, 'LoadTaskContentsTable']);
Route::get('/GetTasksTable', [ReminderController::class, 'LoadTasksTable']);
Route::post('/PostTable', [ReminderController::class, 'UpdateTable']);
Route::get('/ReactionsTable', [ReminderController::class, 'ReactionsTable']);
Route::get('/IsStranger', [InstantUserController::class, 'IsStranger']);
Route::get('/DeleteTask', [ReminderController::class, 'DeleteTask']);

Route::post('/editUserInfo', [InstantUserController::class, 'SubmitUserInfo']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
