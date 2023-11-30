<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InternalContactController;
use App\Http\Controllers\MOHPositionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Controller::class, 'index'])->name('/');

Route::get('/Users', [UserController::class, 'index'])->name('listusers');
Route::get('/Users/Create', [UserController::class, 'newUser'])->name('newuser');
Route::put('/createuser', [UserController::class, 'createUser'])->name('createuser');
Route::get('/Users/Details/{id}', [UserController::class, 'details'])->name('userdetails');
Route::get('/Users/Edit/{id}', [UserController::class, 'edit'])->name('edituser');
Route::put('/updateuser', [UserController::class, 'updateUser'])->name('updateuser');
Route::put('/addrole/{id}', [UserController::class, 'addRole'])->name('addrole');
Route::get('/deleterole/{id}/{userid}', [UserController::class, 'deleteRole'])->name('deleterole');
Route::put('/addpgroup/{id}', [UserController::class, 'addPGroup'])->name('addpgroup');
Route::get('/deletepgroup/{id}/{userid}', [UserController::class, 'deletePGroup'])->name('deletepgroup');


Route::get('/Departments', [DepartmentController::class, 'index'])->name('listdepartments');
Route::get('/Departments/Create', [DepartmentController::class, 'newDepartment'])->name('newdept');
Route::put('/createdept', [DepartmentController::class, 'createdept'])->name('createdept');
Route::get('/Departments/Details/{id}', [DepartmentController::class, 'details'])->name('departmentdetails');
Route::get('/Departments/Edit/{id}', [DepartmentController::class, 'edit'])->name('editdepartment');
Route::put('/updatedept', [DepartmentController::class, 'update'])->name('updatedept');

Route::get('/MOHRoles', [MOHPositionsController::class, 'index'])->name('listmohroles');

Route::get('/InternalContacts', [InternalContactController::class, 'index'])->name('listinternalcontacts');
Route::get('/InternalContacts/Create', [InternalContactController::class, 'newinternalcontact'])->name('newinternalcontact');
Route::put('/createic}', [InternalContactController::class, 'createInternalContact'])->name('createic');
