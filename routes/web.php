<?php

use App\Http\Controllers\VacacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Página de inicio - redirige a vacaciones
Route::get('/', function () {
    return redirect()->route('vacaciones.index');
});

// Dashboard - redirige a vacaciones (soluciona el error de registro/login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('vacaciones.index');
    })->name('dashboard');
    
    // Rutas de Home (PROTEGIDAS)
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/edit', [\App\Http\Controllers\HomeController::class, 'edit'])->name('home.edit');
    Route::post('/home/update', [\App\Http\Controllers\HomeController::class, 'update'])->name('home.update');
});

// Rutas públicas de vacaciones (sin autenticación)
Route::get('/vacaciones', [VacacionController::class, 'index'])->name('vacaciones.index');
Route::get('/vacaciones/{id}', [VacacionController::class, 'show'])->name('vacaciones.show');

// Rutas de verificación de email
Route::middleware('auth')->group(function () {
    // Aviso de verificación
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Procesar verificación
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('vacaciones.index')->with('success', '¡Email verificado exitosamente!');
    })->middleware(['signed'])->name('verification.verify');

    // Reenviar email de verificación
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Email de verificación reenviado.');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Rutas que requieren autenticación Y email verificado
Route::middleware(['auth', 'verified'])->group(function () {
    // Reservas
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.mis-reservas');
    Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

    // Comentarios
    Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::put('/comentarios/{id}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
});

// Rutas para usuarios Advanced o Admin
Route::middleware(['auth', 'verified', 'advanced'])->group(function () {
    // Aquí puedes añadir funcionalidades especiales para usuarios advanced
    // Por ejemplo: estadísticas, reportes, etc.
});

// Rutas solo para Admin
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // CRUD de vacaciones
    Route::get('/admin/vacaciones/crear', [VacacionController::class, 'create'])->name('vacaciones.create');
    Route::post('/admin/vacaciones', [VacacionController::class, 'store'])->name('vacaciones.store');
    Route::get('/admin/vacaciones/{id}/editar', [VacacionController::class, 'edit'])->name('vacaciones.edit');
    Route::put('/admin/vacaciones/{id}', [VacacionController::class, 'update'])->name('vacaciones.update');
    Route::delete('/admin/vacaciones/{id}', [VacacionController::class, 'destroy'])->name('vacaciones.destroy');

    // Listado de todas las reservas
    Route::get('/admin/reservas', [ReservaController::class, 'index'])->name('admin.reservas.index');
});

// Rutas de perfil (requiere autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluir rutas de autenticación de Laravel Breeze
require __DIR__.'/auth.php';