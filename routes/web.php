<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('app');
});

Route::get('/media', function () {
    return view('app');
});

Route::get('/photo', function () {
    return view('app');
});

Route::get('/events', function () {
    return view('app');
});

Route::get('/about', function () {
    return view('app');
});

Route::get('/manage', function () {
    return view('app');
});


Route::post('/collection', [MusicController::class, 'collection']);
Route::post('/last', [MusicController::class, 'last']);
Route::post('/release', [MusicController::class, 'release']);
Route::post('/release/remove', [MusicController::class, 'remove']);

Route::post('/auth', [AuthController::class, 'auth']);

Route::post('/events', [EventsController::class, 'events']);
Route::post('/events/add', [EventsController::class, 'add']);
Route::post('/events/remove', [EventsController::class, 'remove']);
Route::post('/events/ref', [EventsController::class, 'ref']);

Route::post('/photos', [PhotoController::class, 'photos']);
Route::post('/photos_upload', [PhotoController::class, 'upload']);
Route::post('/photos_remove', [PhotoController::class, 'remove']);

Route::post('/members', [MemberController::class, 'members']);
Route::post('/members/add', [MemberController::class, 'add']);
Route::post('/members/remove', [MemberController::class, 'remove']);

//router.post('/ref', controller.ref);



