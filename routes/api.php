<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaneController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CategoreController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AppointmentController;

Route::group(['middleware' => 'auth:sanctum'], function () {


    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Company api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    Route::controller(CompaneController::class)
        ->prefix('company')
        ->group(function () {
            Route::post('/create',                 [AuthController::class, 'companyregister']);
            Route::get('/productToken',                                  'productToken');
            Route::get('/productID',                                        'productID');
            Route::get('',                                                      'index');
            Route::get('/forUser',                                          'indexUser');
            Route::get('show/{compane}',                                         'show');
            Route::post('/update/{compane}',                                   'update');
            Route::delete('/delete/{compane}',                                'destroy');
            Route::post('/search/{name}',                                      'search');
            Route::get('/teams',                                                'teams');
            Route::get('/feedbacks',                                        'feedbacks');
            Route::post('/active/{company}',                                   'active');
            Route::put('/changepassword',                              'changepassword');
            Route::get('survey'                                               ,'survey');
            Route::get('appointment'                                     ,'appointment');
            Route::get('/companyByToken',                              'companyByToken');
            Route::get('/location',                                          'location');
        });
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Company api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Team api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(TeamController::class)
        ->prefix('team')
        ->group(function () {
            Route::post('/create',                    [AuthController::class, 'teamregister']);
            Route::get('',                                                      'index');
            Route::get('companyid',                                         'companyid');
            Route::get('show/{team}',                                            'show');
            Route::put('/update/{team}',                                       'update');
            Route::delete('/delete/{team}',                                   'destroy');
            Route::post('/search/{name}',                                      'search');
            Route::post('/active/{team}',                                      'active');
            Route::get('/appointments',                                 'appointments');
            Route::put('/changepassword',                             'changepassword');
            Route::get('/teamByToken',                                   'teamByToken');
        });
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Team api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Category api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(CategoreController::class)
        ->prefix('category')
        ->group(function () {
            Route::get('',                                                          'index');
            Route::get('/show/{category_id}',                                        'show');
            Route::get('/product/{id}',                                          'products');
            Route::post('/create',                                                  'store');
            Route::put('update/{category}',                                        'update');
            Route::delete('delete/{category}',                                    'destroy');
        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Category api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Feature api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(FeatureController::class)
        ->prefix('feature')
        ->group(function () {
            Route::get('',                                                        'index');
            Route::get('/show/{feature}',                                          'show');
            Route::post('/create',                                                'store');
            Route::put('update/{feature}',                                       'update');
            Route::delete('delete/{feature}',                                   'destroy');
            Route::post('/search/{name}',                                        'search');
        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Feature api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Type api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(TypeController::class)
        ->prefix('type')
        ->group(function () {
            Route::get('',                                                       'index');
            Route::get('/show/{type}',                                            'show');
            Route::post('/create',                                               'store');
            Route::put('update/{type}',                                         'update');
            Route::delete('delete/{type}',                                     'destroy');
        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Type api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Device api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(DeviceController::class)
        ->prefix('device')
        ->group(function () {
            Route::get('',                                                      'index');
            Route::get('/show/{device}',                                         'show');
            Route::post('/create',                                              'store');
            Route::post('update/{device}',                                     'update');
            Route::delete('delete/{device}',                                  'destroy');
        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Device api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Feedback api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(FeedbackController::class)
        ->prefix('feedback')
        ->group(function () {
            Route::get('',                                                      'index');
            Route::post('/create',                                              'store');
            Route::post('/rating/{feedback}',                                  'update');
            Route::delete('delete/{feedback}',                                'destroy');
            Route::get('/showcompany',                                        'company');
            Route::get('/show/{feedback}',                                   'showbyid');
            Route::get('/companyUser',                           'CompanyUserFeedbacks');
        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Feedback api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start User api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(UserController::class)
        ->prefix('user')
        ->group(function () {
            Route::get('',                                                     'index');
            Route::get('orders',                                              'orders');
            Route::get('/show/{user}',                                          'show');
            Route::delete('delete/{user}',                                   'destroy');
            Route::put('/changepassword',                             'changepassword');
            Route::put('/update',                                        'editprofile');
            Route::get('/showByToken',                                     'userToken');
            Route::get('survey'                                              ,'survey');

        }); //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end User api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Product api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(ProductController::class)
        ->prefix('product')
        ->group(function () {
            Route::get('',                                                       'index');
            Route::get('/show/{id}',                                              'show');
            Route::post('/create',                                               'store');
            Route::post('/featureUpdate/{product}',               'productFeatureUpdate');
            Route::post('/update/{product}',                                    'update');
            Route::delete('/delete/{product}',                                 'destroy');
            Route::get('shuffle'                                              ,'shuffle');
        });
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Product api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Order api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(OrderController::class)
        ->prefix('order')
        ->group(function () {
            Route::get('',                                                       'index');
            Route::get('/show/{order}',                                           'show');
            Route::post('/create',                                               'store');
            Route::put('/update/{order}',                                       'update');
            Route::delete('/delete/{order}',                                   'destroy');
            Route::get('/available',                                         'available');
            Route::get('/calculateBatteryNumber',                                         'calculateBatteryNumber');


        });
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Order api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Appointment api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    Route::controller(AppointmentController::class)
        ->prefix('appointment')
        ->group(function () {
            Route::get('',                                                       'index');
            Route::get('/show/{appointment}',                                     'show');
            Route::post('/create',                                               'store');
            Route::put('/update/{appointment}',                                 'update');
            Route::delete('/delete/{appointment}',                             'destroy');
            Route::get('/company',                                  'CompanyAppointment');
            Route::get('/team',                                       'TeamAppointment');
            Route::get('teamById'                                                    ,'team');
            Route::post('/installation/{appointment}',         'InstallationAppointment');
            Route::post('/finishTime/{appointment}',                  'UpdateFinishTime');
            Route::post('/OrderStatus/{appointment}',                      'OrderStatus');
            Route::post('/UpdateDetection/{appointment}',            'UpdateAppointment');
            Route::post('/maintenance',                                          'store');
            Route::get('filter',                                                'filter');
        });
    //   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Appointment api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    //End Sanctum Middleware
});

//   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$start Auth&Role api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/register',                                            'register');
        Route::post('/login',                                                  'login');
        Route::post('/grant',                                                  'grant');
        Route::get('/indexpermission',                                         'index');
    });
//   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$end Auth&Role api$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
