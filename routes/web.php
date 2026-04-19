<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectTeacherController;



// Public Routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('auth.showRegistrationForm');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.showLoginForm');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google_callback');


// Protected Routes
Route::group(['middleware' => ['login']], function () {
    // Dashboard Route
    Route::get('/', [AuthController::class, 'home'])->name('auth.home');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');


    // User Related Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/ajax_show/{id}', [UserController::class, 'ajaxShow'])->name('users.ajaxShow');
    Route::delete('/users/ajax_destroy/{id}', [UserController::class, 'ajaxDestroy'])->name('users.ajaxDestroy');


    // SubjectTeacher Related Routes
    Route::get('subject-teachers', [SubjectTeacherController::class, 'index'])->name('subject_teachers.index');
    Route::get('subject-teachers/create', [SubjectTeacherController::class, 'create'])->name('subject_teachers.create');
    Route::post('subject-teachers', [SubjectTeacherController::class, 'store'])->name('subject_teachers.store');
    Route::get('subject-teachers/{id}', [SubjectTeacherController::class, 'show'])->name('subject_teachers.show');
    Route::get('subject-teachers/{id}/edit', [SubjectTeacherController::class, 'edit'])->name('subject_teachers.edit');
    Route::put('subject-teachers/{id}', [SubjectTeacherController::class, 'update'])->name('subject_teachers.update');
    Route::delete('subject-teachers/{id}', [SubjectTeacherController::class, 'destroy'])->name('subject_teachers.destroy');

    Route::get('class/{id}/groups', [SubjectTeacherController::class, 'getGroupsByClass'])->name('class.groups');
    Route::get('class/{id}/sections', [SubjectTeacherController::class, 'getSectionsByClass'])->name('class.sections');
    Route::get('/class/{id}/subjects', [SubjectTeacherController::class, 'getSubjectsByClass'])->name('class.subjects');
    Route::get('class/{class_id}/group/{group_id}/sections', [SubjectTeacherController::class, 'getGroupSections'])->name('class.group.sections');
    Route::get('section/{id}/subjects', [SubjectTeacherController::class, 'getSubjects'])->name('section.subjects');



    Route::get('marking', [StudentController::class, 'marking'])->name('marking');

    // Logout Route
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
