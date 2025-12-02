<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExternalCompanyController;
use App\Http\Controllers\ExternalPersonController;
use App\Http\Controllers\InternalContactController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MOHPositionsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Livewire\CreateLeave;
use App\Livewire\CreateEmployeeContract;
use App\Livewire\CreatePurchaseContract;
use App\Livewire\CreatePurchaseContractModal;
use App\Livewire\CreatePurchaseModal;
use App\Livewire\EditEmployeeContract;
use App\Livewire\EditPurchaseContract;
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

Route::get('/Login', [Controller::class, 'login'])->name('login');
Route::get('/Logout', [Controller::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [Controller::class, 'index'])->name('/');
    Route::get('/Users', [UserController::class, 'index'])->name('listusers');
    Route::get('/Users/Create', [UserController::class, 'newUser'])->name('newuser');
    Route::put('/createuser', [UserController::class, 'createUser'])->name('createuser');
    Route::get('/Users/Details/{id}', [UserController::class, 'details'])->name('userdetails');
    Route::get('/Users/Edit/{id}', [UserController::class, 'edit'])->name('edituser');
    Route::get('/Users/Delete/{id}', [UserController::class, 'deleteUser'])->name('deleteuser');
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
    Route::get('/getroles', [MOHPositionsController::class, 'getRoles'])->name('getroles');

    Route::get('/InternalContacts', [InternalContactController::class, 'index'])->name('listinternalcontacts');
    Route::get('/getinternalcontacts', [InternalContactController::class, 'getInternalContacts'])->name('getinternalcontacts');
    Route::get('/InternalContacts/Create', [InternalContactController::class, 'newinternalcontact'])->name('newinternalcontact');
    Route::post('/setinternalcontacts', [CreatePurchaseContractModal::class, 'setIC'])->name('setinternalcontacts');
    Route::put('/createic}', [InternalContactController::class, 'createInternalContact'])->name('createic');

    Route::get('/ExternalCompanies', [ExternalCompanyController::class, 'index'])->name('externalcompanies');
    Route::get('/getexternalcompanies', [ExternalCompanyController::class, 'getExternalCompanies'])->name('getexternalcompanies');

    Route::get('/ExternalPersons', [ExternalPersonController::class, 'index'])->name('externalpersons');
    Route::get('/getexternalpersons', [ExternalPersonController::class, 'getExternalPersons'])->name('getexternalpersons');

    Route::get('/Purchases', [PurchaseController::class, 'index'])->name('purchases');
    Route::get('/getpurchases', [PurchaseController::class, 'getPurchases'])->name('getpurchases');

    Route::get('/Leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/Leave/Create', CreateLeave::class)->name('leave.create');
    Route::get('/getleaves', [LeaveController::class, 'getLeaves'])->name('getleaves');
    Route::get('/getupcomingleaves', [LeaveController::class, 'getUpcomingLeaves'])->name('getupcomingleaves');
    Route::get('/getongoingleaves', [LeaveController::class, 'getOngoingLeaves'])->name('getongoingleaves');

    Route::get('/PurchaseContracts', [ContractController::class, 'purchaseContracts'])->name('purchasecontracts');
    Route::get('/PurchaseContracts/Create', CreatePurchaseContract::class)->name('purchasecontracts.create');
    Route::get('/PurchaseContracts/Edit/{id}', EditPurchaseContract::class)->name('purchasecontracts.edit');
    Route::get('/getpurchasecontracts', [ContractController::class, 'getPurchaseContracts'])->name('getpurchasecontracts');
    Route::get('/getactivepurchasecontracts', [ContractController::class, 'getActivePurchaseContracts'])->name('getactivepurchasecontracts');
    Route::get('/getinactivepurchasecontracts', [ContractController::class, 'getInactivePurchaseContracts'])->name('getinactivepurchasecontracts');

    Route::get('/EmployeeContracts', [ContractController::class, 'employeeContracts'])->name('employeecontracts');
    Route::get('/EmployeeContracts/Create', CreateEmployeeContract::class)->name('employeecontracts.create');
    Route::get('/EmployeeContracts/Edit/{id}', EditEmployeeContract::class)->name('employeecontracts.edit');
    Route::get('/getemployeecontracts', [ContractController::class, 'getEmployeeContracts'])->name('getemployeecontracts');
    Route::get('/getactiveemployeecontracts', [ContractController::class, 'getActiveEmployeeContracts'])->name('getactiveemployeecontracts');
    Route::get('/getinactiveemployeecontracts', [ContractController::class, 'getInactiveEmployeeContracts'])->name('getinactiveemployeecontracts');

    Route::get('/downloadactiveemployeecontracts', [ContractController::class, 'downloadActiveEmployeeContracts'])->name('downloadactiveemployeecontracts');

    Route::get('/Notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::get('/getnotifications', [NotificationsController::class, 'getNotifications'])->name('getnotifications');
});
