<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/organization',  [App\Http\Controllers\OrganizationController::class, 'index'])->name('organization.index');
Route::get('/organization/create',  [App\Http\Controllers\OrganizationController::class, 'create'])->name('organization.create');
Route::post('/organization/store', [App\Http\Controllers\OrganizationController::class, 'store'])->name('organization.store');
Route::patch('/organization/{id}', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organization.update');
Route::get('/organization/{id}',  [App\Http\Controllers\OrganizationController::class, 'edit'])->name('organization.edit');
Route::delete('/organization/destroy/{id}', [App\Http\Controllers\OrganizationController::class, 'destroy'])->name('organization.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::patch('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
});

//イベント管理
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [App\Http\Controllers\EventController::class, 'create'])->name('events.create');
Route::post('/events/store', [App\Http\Controllers\EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
Route::patch('/events/{event}', [App\Http\Controllers\EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');

//空QRコード生成
Route::get('/events/{event}/generateqr', [App\Http\Controllers\EventGenerateQRController::class, 'index'])->name('eventsgenerateqr.index');
Route::get('/event/{event}/generateqr/create', [App\Http\Controllers\EventGenerateQRController::class, 'create'])->name('eventsgenerateqr.create');
Route::post('/events/{event}/generateqr/store', [App\Http\Controllers\EventGenerateQRController::class, 'store'])->name('eventsgenerateqr.store');
Route::get('/events/{event}/generateqr/{id}', [App\Http\Controllers\EventGenerateQRController::class, 'show'])->name('eventsgenerateqr.show');



//申込フォーム基本設定の設定ルーティング
Route::get('/events/{event}/basic', [App\Http\Controllers\EventBasicContoller::class, 'edit'])->name('eventbasic.edit');
Route::patch('/events/{event}/basic', [App\Http\Controllers\EventBasicContoller::class, 'update'])->name('eventbasic.update');

//フォーム設定のルーティング
Route::get('/events/{event}/formsetting', [App\Http\Controllers\EventFormController::class, 'edit'])->name('eventform.edit');
Route::patch('/events/{event}/formsetting', [App\Http\Controllers\EventFormController::class, 'update'])->name('eventform.update');

//受付区分のルーティング
Route::get('/events/{event}/section', [App\Http\Controllers\EventSectionController::class, 'edit'])->name('eventsection.edit');
Route::patch('/events/{event}/section', [App\Http\Controllers\EventSectionController::class, 'update'])->name('eventsection.update');

//マイページ基本設定のルーティング
Route::get('/events/{event}/mypagebasic', [App\Http\Controllers\EventMypageBasicController::class, 'edit'])->name('eventmypagebasic.edit');
Route::patch('/events/{event}/mypagebasic', [App\Http\Controllers\EventMypageBasicController::class, 'update'])->name('eventmypagebasic.update');

//申込完了画面設定のルーティング
Route::get('/events/{event}/finish', [App\Http\Controllers\EventFinishController::class, 'edit'])->name('eventfinish.edit');
Route::patch('/events/{event}/finish', [App\Http\Controllers\EventFinishController::class, 'update'])->name('eventfinish.update');

//申込完了メール設定のルーティング
Route::get('/events/{event}/finishmail', [App\Http\Controllers\EventFinishMailController::class, 'edit'])->name('eventfinishmail.edit');
Route::patch('/events/{event}/finishmail', [App\Http\Controllers\EventFinishMailController::class, 'update'])->name('eventfinishmail.update');

//受付時本人メール（入場）のルーティング
Route::get('/events/{event}/entrymail', [App\Http\Controllers\EventEntryMailController::class, 'edit'])->name('evententrymail.edit');
Route::patch('/events/{event}/entrymail', [App\Http\Controllers\EventEntryMailController::class, 'update'])->name('evententrymail.update');

//受付時本人メール（退場）のルーティング
Route::get('/events/{event}/exitmail', [App\Http\Controllers\EventExitMailController::class, 'edit'])->name('eventexitmail.edit');
Route::patch('/events/{event}/exitmail', [App\Http\Controllers\EventExitMailController::class, 'update'])->name('eventexitmail.update');

//ユーザー申込画面
Route::get('/events/{event}/form', [App\Http\Controllers\EventUserController::class, 'form'])->name('eventform.form');
Route::patch('/events/{event}/form', [App\Http\Controllers\EventUserController::class, 'store'])->name('eventform.store');
Route::get('/events/{event}/form/finish', [App\Http\Controllers\EventUserController::class, 'finish'])->name('eventform.finish');

//ユーザー申込画面
Route::get('/events/{event}/pdf', [App\Http\Controllers\EventPDFViewController::class, 'edit'])->name('eventpdf.edit');
Route::patch('/events/{event}/pdf', [App\Http\Controllers\EventPDFViewController::class, 'update'])->name('eventpdf.update');

//アンケート追加画面
Route::get('/events/{event}/survey', [App\Http\Controllers\EventSurveyController::class, 'edit'])->name('eventsurvey.edit');
Route::patch('/events/{event}/survey', [App\Http\Controllers\EventSurveyController::class, 'update'])->name('eventsurvey.update');


//イベントユーザーログイン画面
Route::get('/events/{event}/login', [App\Http\Controllers\EventUserController::class, 'showLoginForm'])->name('eventuser.login');
Route::post('/events/{event}/login', [App\Http\Controllers\EventUserController::class, 'login']);
Route::get('/events/{event}/mypage', [App\Http\Controllers\EventUserController::class, 'showMypage'])->name('eventuser.mypage');
Route::post('/events/{event}/logout', [App\Http\Controllers\EventUserController::class, 'logout'])->name('eventuser.logout');

//QR読み込み
Route::get('/events/{event}/qr/user/{qrid}/{exitentry}', [App\Http\Controllers\EventScanController::class, 'userqr'])->name('qr.user');
Route::get('/events/{event}/qr/nonuser/{qrid}/{exitentry}', [App\Http\Controllers\EventScanController::class, 'nonuserqr'])->name('qr.nonuser');

//QRスキャン画面
Route::get('/events/{event}/scan/{exitentry}', [App\Http\Controllers\EventScanController::class, 'scan'])->name('event.scan');

Route::get('/pdf', [App\Http\Controllers\PdfController::class, 'show'])->name('pdf.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//トータルのindexのルーティング
Route::get('/events/{event}/totals', [App\Http\Controllers\EventExitEntryTotalController::class, 'index'])->name('events.exit_entry_totals');


require __DIR__.'/auth.php';
