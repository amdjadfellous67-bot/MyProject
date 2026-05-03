<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PasswordResetRequestController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/password-reset-request', [PasswordResetRequestController::class, 'submit'])->name('password-reset-request.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Admin - only manages employees and departments
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        
        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
        Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        
        Route::get('/positions', [App\Http\Controllers\PositionController::class, 'index'])->name('positions.index');
        Route::post('/positions', [App\Http\Controllers\PositionController::class, 'store'])->name('positions.store');
        Route::get('/positions/create', [App\Http\Controllers\PositionController::class, 'create'])->name('positions.create');
        Route::get('/positions/{position}/edit', [App\Http\Controllers\PositionController::class, 'edit'])->name('positions.edit');
        Route::put('/positions/{position}', [App\Http\Controllers\PositionController::class, 'update'])->name('positions.update');
        Route::delete('/positions/{position}', [App\Http\Controllers\PositionController::class, 'destroy'])->name('positions.destroy');
        
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/create', [BackupController::class, 'create'])->name('backup.create');
        
        Route::get('/password-requests', [PasswordResetRequestController::class, 'index'])->name('password-requests.index');
        Route::post('/password-requests/{passwordRequest}/resolve', [PasswordResetRequestController::class, 'markResolved'])->name('password-requests.resolve');
        Route::post('/password-reset', [PasswordResetRequestController::class, 'resetPassword'])->name('password-reset.reset');
    });
    
    // HR Manager - manages leave, absences, evaluations, salary for their department
    Route::prefix('hr')->middleware(['role:hr_manager'])->group(function () {
        Route::get('/employees', [EmployeeController::class, 'hrIndex'])->name('hr.employees.index');
        Route::get('/leave', [LeaveController::class, 'hrIndex'])->name('hr.leave.index');
        Route::post('/leave/{leaveRequest}/approve', [LeaveController::class, 'hrApprove'])->name('hr.leave.approve');
        Route::post('/leave/{leaveRequest}/reject', [LeaveController::class, 'hrReject'])->name('hr.leave.reject');
        
        Route::get('/absences', [AbsenceController::class, 'hrIndex'])->name('hr.absences.index');
        Route::post('/absences', [AbsenceController::class, 'hrStore'])->name('hr.absences.store');
        Route::delete('/absences/{absence}', [AbsenceController::class, 'hrDestroy'])->name('hr.absences.destroy');
        
        Route::get('/evaluations', [\App\Http\Controllers\EvaluationController::class, 'hrIndex'])->name('hr.evaluations.index');
        Route::get('/evaluations/create', [\App\Http\Controllers\EvaluationController::class, 'hrCreate'])->name('hr.evaluations.create');
        Route::post('/evaluations', [\App\Http\Controllers\EvaluationController::class, 'hrStore'])->name('hr.evaluations.store');
        
        Route::get('/salary', [\App\Http\Controllers\SalaryController::class, 'hrIndex'])->name('hr.salary.index');
        Route::get('/salary/form', [\App\Http\Controllers\SalaryController::class, 'hrForm'])->name('hr.salary.form');
        Route::get('/salary/print', [\App\Http\Controllers\SalaryController::class, 'hrPrint'])->name('hr.salary.print');
        Route::get('/salary/{salary}', [\App\Http\Controllers\SalaryController::class, 'hrShow'])->name('hr.salary.show');
        Route::post('/salary/process', [\App\Http\Controllers\SalaryController::class, 'hrProcess'])->name('hr.salary.process');
    });
    
    // All employees (including HR) can view their own data
    Route::middleware(['role:employee,hr_manager,admin'])->group(function () {
        Route::get('/employee/leave', [LeaveController::class, 'employeeIndex'])->name('employee.leave.index');
        Route::get('/employee/leave/create', [LeaveController::class, 'create'])->name('employee.leave.create');
        Route::post('/employee/leave', [LeaveController::class, 'store'])->name('employee.leave.store');
        
        Route::get('/employee/salary', [SalaryController::class, 'employeeIndex'])->name('employee.salary.index');
        Route::get('/employee/salary/{salary}', [SalaryController::class, 'employeeShow'])->name('employee.salary.show');
        
        Route::get('/employee/evaluations', [\App\Http\Controllers\EvaluationController::class, 'employeeIndex'])->name('employee.evaluations.index');
    });
});
