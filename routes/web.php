<?php

use App\Http\Controllers\ProfileController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
use App\Http\Controllers\Employee\UserController;
use App\Http\Controllers\Employee\UserHomeController;
use App\Http\Controllers\Employee\UserAjaxController;
use App\Http\Controllers\Employee\UserCentreCreationController;
use App\Http\Controllers\Employee\UserVendorController;
use App\Http\Controllers\Employee\UserPartnerController;
use App\Http\Controllers\Employee\UserProjectController;
use App\Http\Controllers\Employee\UserBatchController;
use App\Http\Controllers\Employee\UserAttendenceController;
use App\Http\Controllers\Employee\UserAssesmentController;
use App\Http\Controllers\Employee\UserCertificateController;
Route::name('user.')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/','login')->name('login');
        //Route::get('login','login')->name('login');
        Route::post('login-capcha','checkCapcha')->name('checkCapcha');
        Route::get('refresh-captcha', 'refreshCaptcha')->name('refreshCaptcha');
        Route::post('check-login','chkLogin')->name('chklogin');
        Route::get('register','register')->name('register');
        Route::post('user-store','store')->name('store');

    });

    //ajax
            
    Route::post('userAjaxAddressDropdown',[UserAjaxController::class,'ajaxAddressDropdown'])->name('ajaxAddressDropdown');
    Route::post('ajaxAddressByPincodeDropdown',[UserAjaxController::class,'ajaxAddressByPincodeDropdown'])->name('ajaxAddressByPincodeDropdown');
            

    Route::middleware(['UserAccess'])->group(function () {

        Route::controller(UserHomeController::class)->group(function(){
            Route::get('home','home')->name('home');
            Route::post('logout','logout')->name('logout');

            Route::get('profile','profile')->name('profile');
            Route::post('profile-save','profileSave')->name('profile.update');
            Route::post('password-save','passwordSave')->name('password.update');
        });

        //center creation 
        Route::middleware(['UserCentreCreationProcessCheck'])->group(function(){
            Route::controller(UserCentreCreationController::class)->group(function(){
                Route::get('pending-centre-creation','index')->name('centreCreations');
                Route::get('centre-creation-add','add')->name('addCentreCreation');
                Route::post('centre-creation-save','insert')->name('saveCentreCreation');
                Route::get('centre-creation-edit/{slug}','edit')->name('editCentreCreation');
                Route::post('update-centre-creation/{slug}','update')->name('updateCentreCreation');
                //Route::post('centre-creation-status/{slug}','statusChange')->name('changeCentreCreationStatus');
                Route::get('remove-centre-creation/{slug}','remove')->name('removeCentreCreation');
                Route::get('trashed-centre-creations','trashedData')->name('trashedCentreCreation');
                Route::get('restore-centre-creation/{slug}','restoreData')->name('restoreCentreCreation');
                Route::get('permanent-remove-centre-creations/{slug}','hardDltData')->name('hardDltCentreCreation');

                Route::get('centre-creation-status-view/{slug}','statusView')->name('centreCreationStatusView');
                Route::post('centre-creation-status-approve-/{slug}','statusApprove')->name('centreCreationStatusApprove');

                Route::get('approved-centre-creation','approvedList')->name('centreCreationApprovedList');

                Route::get('image-remove-centre-creation/{file_id}/{slug}','fileRemove')->name('fileRemoveCentreCreation');
            });
        });
        // vendor creation
        Route::middleware(['UserVendorProcessCheck'])->group(function(){
            Route::controller(UserVendorController::class)->group(function(){
                Route::get('pending-vendor','index')->name('vendors');
                Route::get('vendor-add','add')->name('addVendor');
                Route::post('vendor-save','insert')->name('saveVendor');
                Route::get('vendor-edit/{slug}','edit')->name('editVendor');
                Route::post('update-vendor/{slug}','update')->name('updateVendor');
                //Route::post('vendor-status/{slug}','statusChange')->name('changeVendorStatus');
                Route::get('remove-vendor/{slug}','remove')->name('removeVendor');
                Route::get('trashed-vendors','trashedData')->name('trashedVendor');
                Route::get('restore-vendor/{slug}','restoreData')->name('restoreVendor');
                Route::get('permanent-remove-vendors/{slug}','hardDltData')->name('hardDltVendor');

                Route::get('vendor-status-view/{slug}','statusView')->name('vendorStatusView');
                Route::post('vendor-status-approve-/{slug}','statusApprove')->name('vendorStatusApprove');

                Route::get('approved-vendor','approvedList')->name('vendorApprovedList');

                Route::get('image-remove-vendor/{file_id}/{slug}','fileRemove')->name('fileRemoveVendor');
            });
        });

        // partner creation
        Route::middleware(['UserPartnerProcessCheck'])->group(function(){
            Route::controller(UserPartnerController::class)->group(function(){
                Route::get('pending-partner','index')->name('partners');
                Route::get('partner-add','add')->name('addPartner');
                Route::post('partner-save','insert')->name('savePartner');
                Route::get('partner-edit/{slug}','edit')->name('editPartner');
                Route::post('update-partner/{slug}','update')->name('updatePartner');
                //Route::post('partner-status/{slug}','statusChange')->name('changePartnerStatus');
                Route::get('remove-partner/{slug}','remove')->name('removePartner');
                Route::get('trashed-partners','trashedData')->name('trashedPartner');
                Route::get('restore-partner/{slug}','restoreData')->name('restorePartner');
                Route::get('permanent-remove-partners/{slug}','hardDltData')->name('hardDltPartner');

                Route::get('partner-status-view/{slug}','statusView')->name('partnerStatusView');
                Route::post('partner-status-approve-/{slug}','statusApprove')->name('partnerStatusApprove');

                Route::get('approved-partner','approvedList')->name('partnerApprovedList');

                Route::get('image-remove-partner/{file_id}/{slug}','fileRemove')->name('fileRemovePartner');
            });
        });
        // Project creation
        Route::middleware(['UserProjectProcessCheck'])->group(function(){
            Route::controller(UserProjectController::class)->group(function(){
                Route::get('pending-project','index')->name('projects');
                Route::get('project-add','add')->name('addProject');
                Route::post('project-save','insert')->name('saveProject');
                Route::get('project-edit/{slug}','edit')->name('editProject');
                Route::post('update-project/{slug}','update')->name('updateProject');
                //Route::post('project-status/{slug}','statusChange')->name('changeProjectStatus');
                Route::get('remove-project/{slug}','remove')->name('removeProject');
                Route::get('trashed-project','trashedData')->name('trashedProject');
                Route::get('restore-project/{slug}','restoreData')->name('restoreProject');
                Route::get('permanent-remove-project/{slug}','hardDltData')->name('hardDltProject');

                Route::get('project-status-view/{slug}','statusView')->name('projectStatusView');
                Route::post('project-status-approve-/{slug}','statusApprove')->name('projectStatusApprove');

                Route::get('approved-project','approvedList')->name('projectApprovedList');

                Route::get('image-remove-project/{file_id}/{slug}','fileRemove')->name('fileRemoveProject');
            });
        });
        // batch creation
        Route::middleware(['UserBatchProcessCheck'])->group(function(){
            Route::controller(UserBatchController::class)->group(function(){
                Route::get('pending-batch','index')->name('batches');
                Route::get('batch-add','add')->name('addBatch');
                Route::post('batch-save','insert')->name('saveBatch');
                Route::get('batch-edit/{slug}','edit')->name('editBatch');
                Route::post('update-batch/{slug}','update')->name('updateBatch');
                //Route::post('batch-status/{slug}','statusChange')->name('changeBatchStatus');
                Route::get('remove-batch/{slug}','remove')->name('removeBatch');
                Route::get('trashed-batches','trashedData')->name('trashedBatch');
                Route::get('restore-batch/{slug}','restoreData')->name('restoreBatch');
                Route::get('permanent-remove-batch/{slug}','hardDltData')->name('hardDltBatch');

                Route::get('batch-status-view/{slug}','statusView')->name('batchStatusView');
                Route::post('batch-status-approve-/{slug}','statusApprove')->name('batchStatusApprove');

                Route::get('approved-batch','approvedList')->name('batchApprovedList');

                Route::get('image-remove-batch/{file_id}/{slug}','fileRemove')->name('fileRemoveBatch');
                Route::get('export-student-format-file/{slug?}','exportStudentFormat')->name('exportStudentFormat');
            });
        });
        // Attendence
        Route::middleware(['UserAttendenceProcessCheck'])->group(function(){
            Route::controller(UserAttendenceController::class)->group(function(){
                Route::get('attendence','index')->name('attendences');
                Route::get('attendence-add','add')->name('addAttendence');
                Route::post('attendence-save','insert')->name('saveAttendence');
                Route::get('attendence-edit/{slug}','edit')->name('editAttendence');
                Route::post('update-attendence/{slug}','update')->name('updateAttendence');
            });
        });
        // Assesment
        Route::middleware(['UserAssesmentProcessCheck'])->group(function(){
            Route::controller(UserAssesmentController::class)->group(function(){
                Route::get('assesment','index')->name('assesments');
                Route::get('assesment-add','add')->name('addAssesment');
                Route::post('assesment-save','insert')->name('saveAssesment');
                Route::get('assesment-edit/{slug}','edit')->name('editAssesment');
                Route::post('update-assesment/{slug}','update')->name('updateAssesment');
            });
        });
        //Certificate
        Route::middleware(['UserCertificateProcessCheck'])->group(function(){
            Route::controller(UserCertificateController::class)->group(function(){
                Route::get('certificate','index')->name('certificates');
                Route::get('certificate-add','add')->name('addCertificate');
                Route::post('certificate-save','insert')->name('saveCertificate');
                Route::get('certificate-edit/{slug}','edit')->name('editCertificate');
                Route::post('update-certificate/{slug}','update')->name('updateCertificate');
                Route::get('download-certificate/{batch}/{student}/{slug}','downloadCertificate')->name('downloadCertificate');
                Route::post('bulk-certificate', 'bulkCertificate')->name('bulkCertificate');
            });
        });

        //ajax
        Route::post('ajaxUserView',[UserAjaxController::class,'ajaxUserView'])->name('ajaxUserView');
        
    });
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth','UserAccess'])->group(function () {

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



//require __DIR__.'/auth.php';

//admin
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminHomeController;

use App\Http\Controllers\Admin\AdminRoleCategoryController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAjaxController;
use App\Http\Controllers\Admin\AdminModuleController;
use App\Http\Controllers\Admin\AdminCentreCreationController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminPartnerController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminBatchController;
use App\Http\Controllers\Admin\AdminAttendenceController;
use App\Http\Controllers\Admin\AdminAssesmentController;
use App\Http\Controllers\Admin\AdminCertificateController;
Route::controller(AdminLoginController::class)->group(function(){
    Route::get('admin','login')->name('admin.login');
    Route::get('admin/login','login')->name('admin.login');
    Route::post('admin/login','chkLogin')->name('admin.chkLogin');
    Route::post('admin/capcha-login','checkCapcha')->name('admin.checkCapcha');
    Route::get('admin/refresh-captcha', 'refreshCaptcha')->name('admin.refreshCaptcha');
});


Route::middleware(['AdminAccess'])->group(function(){
    Route::name('admin.')->group(function(){
        Route::prefix('admin')->group(function(){

            Route::controller(AdminHomeController::class)->group(function(){
                Route::get('home','home')->name('home');
                Route::post('logout','logout')->name('logout');
                Route::get('profile','profile')->name('profile');
                Route::post('profile-save','profileSave')->name('profile.update');
                Route::post('password-save','passwordSave')->name('password.update');

                Route::get('setting','setting')->name('setting');
                Route::post('setting-save','settingSave')->name('setting.update');

                Route::get('process-assign-view','process_assign_view')->name('process_assign_view');
                Route::post('process-assign','process_assign')->name('process_assign');
                Route::get('process-permission-view/{slug}','process_permission_view')->name('process_permission_view');
                Route::post('process-permission/{slug}','process_permission')->name('process_permission');

                Route::get('process-flow','process_flow')->name('process_flow');
                Route::post('process-flow-save','process_flow_save')->name('process_flow_save');
                
            });


            //role

            Route::controller(AdminRoleController::class)->group(function(){
                Route::get('roles','index')->name('roles');
                Route::get('role-add','add')->name('addRole');
                Route::post('role-save','insert')->name('saveRole');
                Route::get('role-edit/{slug}','edit')->name('editRole');
                Route::post('update-role/{slug}','update')->name('updateRole');
                Route::post('role-status/{slug}','statusChange')->name('changeRoleStatus');
                Route::get('remove-role/{slug}','remove')->name('removeRole');
                Route::get('trashed-roles','trashedData')->name('trashedRole');
                Route::get('restore-role/{slug}','restoreData')->name('restoreRole');
                Route::get('permanent-remove-roles/{slug}','hardDltData')->name('hardDltRole');
            });

            //user

            Route::controller(AdminUserController::class)->group(function(){
                Route::get('users','index')->name('users');
                Route::get('user-add','add')->name('addUser');
                Route::post('user-save','insert')->name('saveUser');
                Route::get('user-edit/{slug}','edit')->name('editUser');
                Route::post('update-user/{slug}','update')->name('updateUser');
                Route::post('user-status/{slug}','statusChange')->name('changeUserStatus');
                Route::get('remove-user/{slug}','remove')->name('removeUser');
                Route::get('trashed-users','trashedData')->name('trashedUser');
                Route::get('restore-user/{slug}','restoreData')->name('restoreUser');
                Route::get('permanent-remove-users/{slug}','hardDltData')->name('hardDltUser');
            });

            // Batch Module 

                Route::controller(AdminModuleController::class)->group(function(){
                    Route::get('modules','index')->name('modules');
                    Route::get('module-add','add')->name('addModule');
                    Route::post('module-save','insert')->name('saveModule');
                    Route::get('module-edit/{slug}','edit')->name('editModule');
                    Route::post('update-module/{slug}','update')->name('updateModule');
                    Route::post('module-status/{slug}','statusChange')->name('changeModuleStatus');
                    Route::get('remove-module/{slug}','remove')->name('removeModule');
                    Route::get('trashed-modules','trashedData')->name('trashedModule');
                    Route::get('restore-module/{slug}','restoreData')->name('restoreModule');
                    Route::get('permanent-remove-modules/{slug}','hardDltData')->name('hardDltModule');
                });
            //center creation 
            Route::controller(AdminCentreCreationController::class)->group(function(){
                Route::get('pending-centre-creation','index')->name('centreCreations');
                Route::get('centre-creation-edit/{slug}','edit')->name('editCentreCreation');
                Route::post('update-centre-creation/{slug}','update')->name('updateCentreCreation');
                //Route::post('centre-creation-status/{slug}','statusChange')->name('changeCentreCreationStatus');
                Route::get('remove-centre-creation/{slug}','remove')->name('removeCentreCreation');
                Route::get('trashed-centre-creations','trashedData')->name('trashedCentreCreation');
                Route::get('restore-centre-creation/{slug}','restoreData')->name('restoreCentreCreation');
                Route::get('permanent-remove-centre-creations/{slug}','hardDltData')->name('hardDltCentreCreation');

                Route::get('centre-creation-status-view/{slug}','statusView')->name('centreCreationStatusView');
                Route::post('centre-creation-status-approve-/{slug}','statusApprove')->name('centreCreationStatusApprove');

                Route::get('approved-centre-creation','approvedList')->name('centreCreationApprovedList');

                Route::get('image-remove-centre-creation/{file_id}/{slug}','fileRemove')->name('fileRemoveCentreCreation');
            });
            // vendor
            Route::controller(AdminVendorController::class)->group(function(){
                Route::get('pending-vendor','index')->name('vendors');
                Route::get('vendor-edit/{slug}','edit')->name('editVendor');
                Route::post('update-vendor/{slug}','update')->name('updateVendor');
                //Route::post('vendor-status/{slug}','statusChange')->name('changeVendorStatus');
                Route::get('remove-vendor/{slug}','remove')->name('removeVendor');
                Route::get('trashed-vendors','trashedData')->name('trashedVendor');
                Route::get('restore-vendor/{slug}','restoreData')->name('restoreVendor');
                Route::get('permanent-remove-vendors/{slug}','hardDltData')->name('hardDltVendor');

                Route::get('vendor-status-view/{slug}','statusView')->name('vendorStatusView');
                Route::post('vendor-status-approve-/{slug}','statusApprove')->name('vendorStatusApprove');

                Route::get('approved-vendor','approvedList')->name('vendorApprovedList');

                Route::get('image-remove-vendor/{file_id}/{slug}','fileRemove')->name('fileRemoveVendor');
            });
            // Partner
            Route::controller(AdminPartnerController::class)->group(function(){
                Route::get('pending-partner','index')->name('partners');
                Route::get('partner-edit/{slug}','edit')->name('editPartner');
                Route::post('update-partner/{slug}','update')->name('updatePartner');
                //Route::post('partner-status/{slug}','statusChange')->name('changePartnerStatus');
                Route::get('remove-partner/{slug}','remove')->name('removePartner');
                Route::get('trashed-partners','trashedData')->name('trashedPartner');
                Route::get('restore-partner/{slug}','restoreData')->name('restorePartner');
                Route::get('permanent-remove-partners/{slug}','hardDltData')->name('hardDltPartner');
                Route::get('partner-status-view/{slug}','statusView')->name('partnerStatusView');
                Route::post('partner-status-approve-/{slug}','statusApprove')->name('partnerStatusApprove');
                Route::get('approved-partner','approvedList')->name('partnerApprovedList');
                Route::get('image-remove-partner/{file_id}/{slug}','fileRemove')->name('fileRemovePartner');
            });
            //project
            Route::controller(AdminProjectController::class)->group(function(){
                Route::get('pending-project','index')->name('projects');
                Route::get('project-edit/{slug}','edit')->name('editProject');
                Route::post('update-project/{slug}','update')->name('updateProject');
                //Route::post('project-status/{slug}','statusChange')->name('changeProjectStatus');
                Route::get('remove-project/{slug}','remove')->name('removeProject');
                Route::get('trashed-project','trashedData')->name('trashedProject');
                Route::get('restore-project/{slug}','restoreData')->name('restoreProject');
                Route::get('permanent-remove-project/{slug}','hardDltData')->name('hardDltProject');

                Route::get('project-status-view/{slug}','statusView')->name('projectStatusView');
                Route::post('project-status-approve-/{slug}','statusApprove')->name('projectStatusApprove');

                Route::get('approved-project','approvedList')->name('projectApprovedList');

                Route::get('image-remove-project/{file_id}/{slug}','fileRemove')->name('fileRemoveProject');
            });
            //batch
            Route::controller(AdminBatchController::class)->group(function(){
                Route::get('pending-batch','index')->name('batches');
                Route::get('batch-edit/{slug}','edit')->name('editBatch');
                Route::post('update-batch/{slug}','update')->name('updateBatch');
                //Route::post('batch-status/{slug}','statusChange')->name('changeBatchStatus');
                Route::get('remove-batch/{slug}','remove')->name('removeBatch');
                Route::get('trashed-batches','trashedData')->name('trashedBatch');
                Route::get('restore-batch/{slug}','restoreData')->name('restoreBatch');
                Route::get('permanent-remove-batch/{slug}','hardDltData')->name('hardDltBatch');

                Route::get('batch-status-view/{slug}','statusView')->name('batchStatusView');
                Route::post('batch-status-approve-/{slug}','statusApprove')->name('batchStatusApprove');

                Route::get('approved-batch','approvedList')->name('batchApprovedList');

                Route::get('image-remove-batch/{file_id}/{slug}','fileRemove')->name('fileRemoveBatch');
                Route::get('export-student-format-file/{slug?}','exportStudentFormat')->name('exportStudentFormat');
            });
            //attendence
            Route::controller(AdminAttendenceController::class)->group(function(){
                Route::get('attendence','index')->name('attendences');
                Route::get('attendence-edit/{slug}','edit')->name('editAttendence');
                Route::post('update-attendence/{slug}','update')->name('updateAttendence');
            });
            // assesment
            Route::controller(AdminAssesmentController::class)->group(function(){
                Route::get('assesment','index')->name('assesments');
                Route::get('assesment-edit/{slug}','edit')->name('editAssesment');
                Route::post('update-assesment/{slug}','update')->name('updateAssesment');
            });
            //certificate
            Route::controller(AdminCertificateController::class)->group(function(){
                Route::get('certificate','index')->name('certificates');
                Route::get('certificate-edit/{slug}','edit')->name('editCertificate');
                Route::post('update-certificate/{slug}','update')->name('updateCertificate');
                Route::get('download-certificate/{batch}/{student}/{slug}','downloadCertificate')->name('downloadCertificate');
                Route::post('bulk-certificate', 'bulkCertificate')->name('bulkCertificate');
            });
            // end 
            //ajax
            Route::post('ajaxAdminView',[AdminAjaxController::class,'ajaxAdminView'])->name('ajaxAdminView');
            Route::post('ajaxAddressDropdown',[AdminAjaxController::class,'ajaxAddressDropdown'])->name('ajaxAddressDropdown');
            Route::post('ajaxAddressByPincodeDropdown',[AdminAjaxController::class,'ajaxAddressByPincodeDropdown'])->name('ajaxAddressByPincodeDropdown');

        });
    });
    
});
