<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OccupancyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomNameController;
use App\Http\Controllers\ReservationFilteration;
use App\Http\Controllers\HolidayController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest','verified'])->get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth','verified'])->get('/', function () {
   $role = auth()->user()->role;
   if( $role == 1){
     return view('staff.dashboard');
   }else if($role == 0){
    return view('student.dashboard');
   }
});


Route::prefix('staff')->name('staff.')->middleware(['auth', 'verified', 'role:1'])->group(function () {

    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    Route::get('/monitor', function () {
        return view('staff.monitor');
    })->name('monitor');
    
    Route::get('/report', [OccupancyController::class, 'index'])->name('report');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    
    Route::patch('/account/update/{id}', [AccountController::class, 'store'])->name('update.account');
    Route::post('/account/add', [AccountController::class, 'add'])->name('add.account');
    Route::delete('/account/delete/{id}', [AccountController::class, 'delete'])->name('delete.account');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/occupancy', [OccupancyController::class, 'occupancy'])->name('occupancy');

    Route::get('/room', [RoomController::class, 'index'])->name('room');
   
    Route::get('/room/add', [RoomController::class, 'create'])->name('add.room');
    Route::post('/room/store', [RoomController::class, 'store'])->name('store.room');
    Route::get('/room/edit/{id}', [RoomController::class, 'edit'])->name('edit.room');
    Route::patch('/room/update/{id}', [RoomController::class, 'update'])->name('update.room');
    Route::get('/room/show/{id}', [RoomController::class, 'show'])->name('show.room');
    
    Route::delete('/room/show/{id}', [RoomController::class, 'destroy'])->name('delete.room');

    Route::get('/api/chart', [OccupancyController::class, 'chart'])->name('chart');

    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');

    Route::get('/search', [ReservationFilteration::class, 'search'])->name('reservation.search');
   

    Route::patch('/reservation/update/{id}', [ReservationController::class, 'update'])->name('update.reservation');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting');

    Route::patch('/update/setting', [SettingController::class, 'update'])->name('update.setting');

    Route::delete('/delete/banner', [SettingController::class, 'delete'])->name('setting.delete');

    Route::patch('/frame', [SettingController::class, 'img_store']);
    
    Route::patch('/roi', [SettingController::class, 'update_roi']);

    Route::patch('/roi/exit', [SettingController::class, 'update_roi_exit']);


    Route::get('/room_name/{id}',  [RoomNameController::class, 'index'])->name('edit.room_name');
    Route::post('/add/room_name/{id}',  [RoomNameController::class, 'store'])->name('add.room_name');
    Route::delete('/delete/room_name/{id}',  [RoomNameController::class, 'destroy'])->name('delete.room_name');

    Route::patch('/edit/all_room_name', [RoomNameController::class, 'update'])->name('edit.all_room_name');

    Route::get('/holiday', [HolidayController::class, 'index'])->name('holiday');

    Route::post('/add_holiday', [HolidayController::class, 'store']);

     Route::get('get_holiday' , [HolidayController::class, 'api_index']);

     Route::get('/table/get_holiday' ,[HolidayController::class, 'api_index_table']);

     Route::patch('/update_holiday', [HolidayController::class, 'update']);

     Route::delete('/delete_holiday/{holiday}', [HolidayController::class, 'destroy']);

     
});


Route::get('/api/occupancy/{date?}/{sort?}', [OccupancyController::class, 'occupancy_api'])->name('occupancy');


Route::prefix('student')->name('student.')->middleware(['auth', 'verified', 'role:0'])->group(function () {


    Route::get('/api/rooms', [RoomController::class, 'index_api'])->name('api_room');
    Route::get('/room_detail/{id}', [RoomController::class, 'student_show'])->name('room.detail');

    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');

    Route::post('/reservation/{id}', [ReservationController::class, 'store'])->name('reservation');
    
    Route::post('/reservation/day/{id}', [ReservationController::class, 'store_day'])->name('reservation.day');
    
    Route::post('/reservation/month/{month}', [ReservationController::class, 'store_month'])->name('reservation.month');


    Route::get('/api/reservation_slot/{id}/{date}', [ReservationController::class, 'api_slot'])->name('slot');
    

    Route::get('/api/reservation_slot/year/{id}/{year}', [ReservationController::class, 'api_slot_year'])->name('slot.year');

   
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/history', [ReservationController::class, 'student_index'])->name('history');

    Route::get('/api/history', [ReservationController::class, 'api_student_index']);

    Route::get('/history/search',  [ReservationController::class, 'search']);

     Route::get('/api/reservation_slot/date/{id}/{month}', [RoomController::class, 'api_dateSlot']);

     Route::get('/print/{ticket_no}', [ReservationController::class, 'print'])->name('print');
   
    
});
   
    Route::get('/upcoming_current_booking', [ReservationController::class, 'upcoming_current_booking']);


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
