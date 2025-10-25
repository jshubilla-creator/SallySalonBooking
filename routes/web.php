<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ServiceController as CustomerServiceController;
use App\Http\Controllers\Customer\SpecialistController as CustomerSpecialistController;
use App\Http\Controllers\Customer\AppointmentController as CustomerAppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect authenticated users to their appropriate dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('manager')) {
        return redirect()->route('manager.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Customer Routes - Allow authenticated users to access customer features
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [CustomerServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [CustomerServiceController::class, 'show'])->name('services.show');
    Route::get('/specialists', [CustomerSpecialistController::class, 'index'])->name('specialists.index');
    Route::get('/specialists/{specialist}', [CustomerSpecialistController::class, 'show'])->name('specialists.show');
    Route::get('/appointments/create', [CustomerAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [CustomerAppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/{appointment}/cancel', [CustomerAppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/specialists', [CustomerAppointmentController::class, 'getSpecialists'])->name('appointments.specialists');

    Route::get('/appointments/booked-slots', [CustomerAppointmentController::class, 'getBookedTimeSlots'])->name('appointments.booked-slots');

    // Feedback
    Route::get('/feedback', [App\Http\Controllers\Customer\FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create/{appointment}', [App\Http\Controllers\Customer\FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [App\Http\Controllers\Customer\FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{feedback}/edit', [App\Http\Controllers\Customer\FeedbackController::class, 'edit'])->name('feedback.edit');
    Route::put('/feedback/{feedback}', [App\Http\Controllers\Customer\FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{feedback}', [App\Http\Controllers\Customer\FeedbackController::class, 'destroy'])->name('feedback.destroy');

    Route::get('/contact', function () {
        return view('customer.contact');
    })->name('contact');
});

// Manager Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
    // Payments
    Route::post('/payments/{id}/update-price', [App\Http\Controllers\Manager\PaymentController::class, 'updatePrice'])
    ->name('payments.updatePrice');
    Route::get('/payments', [App\Http\Controllers\Manager\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{id}/add', [App\Http\Controllers\Manager\PaymentController::class, 'addPayment'])
    ->name('payments.add');
    Route::post('/payments/{id}/record', [App\Http\Controllers\Manager\PaymentController::class, 'recordPayment'])
        ->name('payments.record');
        Route::put('/payments/{id}/update', [App\Http\Controllers\Manager\PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{id}/delete', [App\Http\Controllers\Manager\PaymentController::class, 'destroy'])->name('payments.delete');


    // Appointments
    Route::resource('appointments', App\Http\Controllers\Manager\AppointmentController::class);
    Route::post('/appointments/{appointment}/approve', [App\Http\Controllers\Manager\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/cancel', [App\Http\Controllers\Manager\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/complete', [App\Http\Controllers\Manager\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::get('/specialists', [AppointmentController::class, 'getSpecialistsForService']);
    // Services
    Route::resource('services', App\Http\Controllers\Manager\ServiceController::class);

    // Specialists
    Route::resource('specialists', App\Http\Controllers\Manager\SpecialistController::class);
    
    // Inventory
    Route::resource('inventory', App\Http\Controllers\Manager\InventoryController::class);

    // Users
    Route::get('/users', [App\Http\Controllers\Manager\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Manager\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [App\Http\Controllers\Manager\UserController::class, 'update'])->name('users.update');

    // Feedback
    Route::get('/feedback', [App\Http\Controllers\Manager\FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{feedback}', [App\Http\Controllers\Manager\FeedbackController::class, 'show'])->name('feedback.show');
    Route::delete('/feedback/{feedback}', [App\Http\Controllers\Manager\FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Settings
    Route::get('/settings', [App\Http\Controllers\Manager\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Manager\SettingsController::class, 'update'])->name('settings.update');

    // SMS Notifications
    Route::get('/sms', [App\Http\Controllers\Manager\SmsController::class, 'index'])->name('sms.index');
    Route::post('/sms/send', [App\Http\Controllers\Manager\SmsController::class, 'send'])->name('sms.send');
    Route::post('/sms/send-reminders', [App\Http\Controllers\Manager\SmsController::class, 'sendReminders'])->name('sms.send-reminders');
    Route::post('/email/send', [App\Http\Controllers\Manager\ManagerEmailController::class, 'send'])->name('email.send');

});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/notifications', [App\Http\Controllers\Admin\SettingsController::class, 'updateNotifications'])->name('settings.notifications');

    // Staff Management - Specialist routes first to avoid conflicts
    Route::get('/staff/create-specialist', [App\Http\Controllers\Admin\StaffController::class, 'createSpecialist'])->name('staff.create-specialist');
    Route::post('/staff/specialist', [App\Http\Controllers\Admin\StaffController::class, 'storeSpecialist'])->name('staff.store-specialist');
    Route::get('/staff/{specialist}/edit-specialist', [App\Http\Controllers\Admin\StaffController::class, 'editSpecialist'])->name('staff.edit-specialist');
    Route::put('/staff/{specialist}/specialist', [App\Http\Controllers\Admin\StaffController::class, 'updateSpecialist'])->name('staff.update-specialist');
    Route::delete('/staff/{specialist}/specialist', [App\Http\Controllers\Admin\StaffController::class, 'destroySpecialist'])->name('staff.destroy-specialist');

    // Staff Management - Resource routes
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-specific profile routes
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Customer\ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Manager\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Manager\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Manager\ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\Manager\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
