<?php

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\OrderController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/pdf/{id}', function ($id) {

    // Retrieve the transaksi record by its ID
    $transaksi = Transaksi::with('DetailTransaksi', 'Outlet')->findOrFail($id);

    return view('Pemilik.transaksi.pdf-layout', [
        'transaksi' => $transaksi,
        'detailTransaksis' => $transaksi->DetailTransaksi,
    ]);
});


Route::get('/', [DashboardController::class, 'HomeDashboard'])->name('home');


// LOGIN MANUAL
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// LOGIN WITH GOOGLE
Route::get('auth/google', [AuthController::class, 'redirectGoogle'])->name('login.google');
Route::get('auth/google/call-back', [AuthController::class, 'callbackGoogle']);

// REGISTER USER
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register-form');
Route::post('register', [AuthController::class, 'Register'])->name('register');
Route::get('/api/check-email-user', [AuthController::class, 'checkEmailUser'])->name('check-email-user');
Route::post('/api/check-email-user', [AuthController::class, 'checkEmailUser'])->name('check.email-user');
Route::get('/api/check-email-outlet', [AuthController::class, 'checkEmailOutlet'])->name('check-email-outlet');
Route::post('/api/check-email-outlet', [AuthController::class, 'checkEmailOutlet'])->name('check.email-outlet');

// EDIT USER
Route::get('edit-profile/{uid}', [AuthController::class, 'showEditForm'])->name('edit-user-profile');
Route::post('/profile/update/{uid}', [UserController::class, 'UpdateProfile'])->name('update-profile');
Route::post('/verify-date-of-birth', [AuthController::class, 'verifyDateOfBirth']);

// VERIFIKASI EMAIL
Route::get('/email/verify', function () {
    return view('verifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('title', 'Home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// RESET PASSWORD 
Route::middleware(['guest'])->group(function () {
    Route::get('/forgot-password', [AuthController::class, 'showLupaPasswordForm'])->name('lupa-form');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/error', function () {
    return view('error-page');
})->name('error-page');


// BAGIAN USER  ----------------------------------------------------------------------------------------------------------------

// PRODUK OUTLET ROUTE !!!! ----
Route::get('/order/{uid}', [OrderController::class, 'MenuOutlet'])->name('order-produk');

// CHECK OUT ROUTE !!!! ----
// Manajemen Query 
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
Route::post('/ordering', [OrderController::class, 'StoreOrder'])->name('ordering');
Route::post('/orders/{id}/update', [OrderController::class, 'UpdateStatusOrder'])->name('orders-update');
Route::post('/search-produk', [DashboardController::class, 'SearchProduk'])->name('search-produk');
Route::post('/register-outlet', [PengajuanController::class, 'MasterStorePengajuan'])->name('pemilik-store-pengajuan-outlet');

// Manajemen Tampilan 
Route::get('/checkout/{sessionId}', [OrderController::class, 'showCheckout'])->name('checkout-show');
Route::get('/waiting-order/{resi}', [OrderController::class, 'WaitingOrder'])->name('order-waiting');
Route::get('/daftar-outlet', [DashboardController::class, 'DaftarOutlet'])->name('daftar-outelt');
Route::get('/daftar-produk', [DashboardController::class, 'DaftarProduk'])->name('daftar-produk');
Route::get('/register-outlet', [PengajuanController::class, 'RegisterOutlet'])->name('pemilik-regiter-outlet');


Route::middleware(['auth'])->group(function () {

    // BAGIAN ADMIN ---------------------------------------------------------------------------------------------------------
    Route::middleware(['auth', 'role:Admin'])->group(function () {

        // Dashboard Admin
        Route::get('/dashboard/admin', [DashboardController::class, 'AdminDashboard'])->name('admin-dashboard');
        Route::get('/get-penghasilan-outlet', [DashboardController::class, 'GrafikPenghasilanOutlet']);


        // USER ROUTE !!!! ----
        // Manajemen Query User
        Route::post('/admin/user', [UserController::class, 'AdminStoreUser'])->name('admin-store-user');
        Route::put('/admin/{uid}', [UserController::class, 'AdminUpdateUser'])->name('admin-update-user');

        // Manajemen Tampilan User
        Route::get('/admin/user', [UserController::class, 'AdminIndexUser'])->name('admin-user');
        Route::get('/admin/add-user', [UserController::class, 'AdminAddUser'])->name('admin-add-user');
        Route::get('/admin/{uid}/edit-user', [UserController::class, 'AdminEditUser'])->name('admin-edit-user');

        // OUTLET ROUTE !!!! ----
        // Manajemen Query Outlet
        Route::post('/admin/outlet', [OutletController::class, 'AdminStoreOutlet'])->name('admin-store-outlet');
        Route::delete('/admin/{uid}/outlet', [OutletController::class, 'AdminDestroyOutlet'])->name('admin-destroy-outlet');
        Route::patch('/admin/{uid}/status-outlet', [OutletController::class, 'AdminStatusOutletUpdate'])->name('admin-status-outlet-update');

        // Manajemen Tampilan Outlet
        Route::get('/admin/all-outlet', [OutletController::class, 'AdminIndexOutlet'])->name('admin-all-outlet');
        Route::get('/admin/add-outlet', [OutletController::class, 'AdminAddOutlet'])->name('admin-add-outlet');
        Route::get('/admin/{uid}/edit-outlet', [OutletController::class, 'AdminEditOutlet'])->name('admin-edit-outlet');


        // PRODUK OUTLET ROUTE !!!! ----
        // Manajemen Query Produk Outlet Tertentu
        Route::post('/admin/{uid}/produk', [ProdukController::class, 'AdminStoreProduk'])->name('admin-store-produk-outlet');
        Route::put('/admin/{uid}/update/{id}', [ProdukController::class, 'AdminUpdateProdukOutlet'])->name('admin-update-produk-outlet');
        Route::delete('/admin/{uid}/destroy-produk/{sku}', [ProdukController::class, 'DestroyProdukOutlet'])->name('admin-destroy-produk-outlet');
        Route::patch('/admin/{uid}/status-produk/{sku}', [ProdukController::class, 'AdminStatusProdukOutletUpdate'])->name('admin-status-produk-outlet');

        // Manajemen Tampilan Produk Outlet
        Route::get('/admin/{uid}/produk', [ProdukController::class, 'AdminProdukOutlet'])->name('admin-all-produk-outlet');
        Route::get('/admin/{uid}/edit-produk/{sku}', [ProdukController::class, 'AdminEditProdukOutlet'])->name('admin-edit-produk-outlet');
        Route::get('/admin/{uid}/add-produk', [ProdukController::class, 'AdminAddProdukOutlet'])->name('admin-add-produk-outlet');

        // Manajemen Tampilan Semua Produk Outlet
        Route::get('/admin/produks', [ProdukController::class, 'AdminProduk'])->name('admin-all-produk');


        // PENGAJUAN ROUTE !!!! ----
        // Manajemen Query Pengajuan
        Route::post('/admin/pengajuan/{id}/approve', [PengajuanController::class, 'AdminApprovePengajuan'])->name('admin-approve-pengajuan');
        Route::put('/admin/pengajuan/{id}/reject', [PengajuanController::class, 'AdminRejectPengajuan'])->name('admin-reject-pengajuan');
        Route::delete('/admin/pengajuan/{id}/destroy', [PengajuanController::class, 'AdminDestroyPengajuan'])->name('admin-destroy-pengajuan');

        // Manajemen Tampilan Pengajuan
        Route::get('/admin/pengajuan', [PengajuanController::class, 'AdminPengajuan'])->name('admin-pengajuan-outlet');
        Route::get('/admin/{id}/detail-pengajuan', [PengajuanController::class, 'AdminDetailPengajuan'])->name('admin-detail-pengajuan');

        // TRANSAKSI ROUTE !!!! ----
        // Manajemen Query Transaksi

        // Manajement Tampilan Transaksi 
        Route::get('/admin/riwayat-transaksi', [TransaksiController::class, 'AdminIndexTransaksi'])->name('admin-transaksi');
        Route::get('/admin/{resi}/edit-transaksi', [TransaksiController::class, 'AdminEditTransaksi'])->name('admin-edit-transaksi');


        // KATEGORI ROUTE !!!! ----
        Route::get('/admin/all-kategori', [KategoriController::class, 'AdminKategori'])->name('admin-all-kategori');
        Route::post('/admin/kategori', [KategoriController::class, 'AdminStore'])->name('admin-store-kategori');
        Route::post('/admin/{uid}/kategori', [KategoriController::class, 'AdminProdukAddKategori'])->name('admin-produk-store-kategori');

        // UNIT ROUTE !!!! ----
        Route::get('/admin/all-unit', [UnitController::class, 'AdminUnit'])->name('admin-all-unit');
        Route::post('/admin/unit', [UnitController::class, 'AdminStore'])->name('admin-store-unit');
        Route::post('/admin/{uid}/unit', [UnitController::class, 'AdminProdukAddUnit'])->name('admin-produk-store-unit');

    });



    // BAGIAN PEMILIK ---------------------------------------------------------------------------------------------------------
    Route::middleware(['auth', 'role:Master'])->group(function () {

        // DASHBOARD ROUTE !!!! ----
        Route::get('/dashboard/master', [DashboardController::class, 'MasterDashboard'])->name('pemilik-dashboard');
        Route::get('/get-statistics', [DashboardController::class, 'GrafikOutlet']);

        // OUTLET ROUTE !!!! ----
        //Manajemen Query
        

        //Manajemen Tampilan
        Route::get('/master/edit-outlet/{uid}', [OutletController::class, 'MasterEditOutlet'])->name('pemilik-edit-outlet');


        // LAPORAN ROUTE !!!! ----
        Route::get('/master/laporan', [LaporanController::class, 'MasterLaporan'])->name('pemilik-laporan');
        Route::get('/get-statistics-produk', [LaporanController::class, 'ProdukTerjual']);
        Route::get('/master/laporan/pendapatan', [LaporanController::class, 'KalenderPendapatan']);
        Route::get('/master/laporan/pendapatan/details', [LaporanController::class, 'getTransactionDetails']);

        // KARYAWAN ROUTE !!!! ----
        // Manajemen Query
        Route::post('/master/karyawan', [UserController::class, 'MasterStoreUser'])->name('pemilik-store-karyawan');
        Route::put('/master/{uid}', [UserController::class, 'MasterUpdateUser'])->name('pemilik-update-karyawan');

        // Manajemen Tampilan
        Route::get('/master/karyawan', [UserController::class, 'MasterIndexUser'])->name('pemilik-karyawan');
        Route::get('/master/add-karyawan', [UserController::class, 'MasterAddUser'])->name('pemilik-add-karyawan');
        Route::get('/master/{uid}/edit-karyawan', [UserController::class, 'MasterEditUser'])->name('pemilik-edit-karyawan');

        // PRODUK ROUTE !!!! ----
        // Manajemen Query 
        Route::post('/master/produk', [ProdukController::class, 'MasterStoreProduk'])->name('pemilik-store-produk');
        Route::put('/master/update/{id}', [ProdukController::class, 'MasterUpdateProdukOutlet'])->name('pemilik-update-produk');

        // Manajemen Tampilan
        Route::get('/master/produk', [ProdukController::class, 'MasterProdukOutlet'])->name('pemilik-produk');
        Route::get('/master/add-produk', [ProdukController::class, 'MasterAddProduk'])->name('pemilik-add-produk');
        Route::get('/master/edit-produk/{sku}', [ProdukController::class, 'MasterEditProdukOutlet'])->name('pemilik-edit-produk');
        Route::get('/master/find-produk', [TransaksiController::class, 'FilterTransaksiProduk'])->name('pemilik-filter-produk');

        // TRANSASKSI ROUTE !!!! ----
        // Manajemen Query 

        // Manajemen Tampilan 
        Route::get('/master/riwayat-transaksi', [TransaksiController::class, 'MasterIndexTransaksi'])->name('pemilik-transaksi');
        Route::get('/master/{resi}/edit-transaksi', [TransaksiController::class, 'MasterEditTransaksi'])->name('pemilik-edit-transaksi');

        // KATEGORI ROUTE !!!! ----
        Route::get('/master/kategori', [KategoriController::class, 'MasterKategori'])->name('pemilik-kategori');
        Route::post('/master/kategori', [KategoriController::class, 'MasterStore'])->name('pemilik-store-kategori');


        // UNIT ROUTE !!!! ----
        Route::get('/master/unit', [UnitController::class, 'MasterUnit'])->name('pemilik-unit');
        Route::post('/master/unit', [UnitController::class, 'MasterStore'])->name('pemilik-store-unit');
    });




    // BAGIAN KARYAWAN DAN PEMILIK ----------------------------------------------------------------------------------------------------------------
    Route::middleware(['auth', 'role:Master,Karyawan'])->group(function () {

        // DASHBOARD ROUTE !!!! ----
        Route::get('/dashboard/kasir', [DashboardController::class, 'KasirDashboard'])->name('kasir-dashboard');

        // STOK ROUTE !!!! ----
        Route::get('/dashboard/stok-produk', [ProdukController::class, 'StokProdukOutlet'])->name('stok-produk');
        Route::patch('/produk/{id}/update', [ProdukController::class, 'updateStatus'])->name('stok-produk-update');

        // ORDER ROUTE !!!! ----
        Route::get('/api/check-orders', [OrderController::class, 'checkOrders']);
        Route::get('/api/orders/count', [OrderController::class, 'getOrderCount']);
        Route::get('/api/orders/process', [OrderController::class, 'getOrderProcessCount']);
        Route::get('/api/orders/finish', [OrderController::class, 'getOrderFinishCount']);


        Route::get('/dashboard/list-order', [OrderController::class, 'ListWaitingOrders'])->name('list-order');
        Route::get('/dashboard/process-order', [OrderController::class, 'ListProcessOrders'])->name('process-order');
        Route::get('/dashboard/final-order', [OrderController::class, 'ListFinalOrder'])->name('final-order');


        // TRANSAKSI ROUTE !!!! ---- 
        Route::post('/transaksi', [TransaksiController::class, 'StoreTransaksi'])->name('kasir-store-transaksi');
    });




    // BAGIAN PEMILIK DAN ADMIN ---------------------------------------------------------------------------------------------------------
    Route::middleware(['auth', 'role:Master,Admin'])->group(function () {

        // USER ROUTE !!!! ----
        Route::patch('/user/{uid}/status-update', [UserController::class, 'UserStatusUpdate'])->name('status-update');
        Route::delete('/user/{uid}', [UserController::class, 'DestroyUser'])->name('destroy-user');

        // TRANSAKSI ROUTE !!!! ----
        Route::get('/detail-transaksi/{resi}', [TransaksiController::class, 'DetailTransaksi'])->name('detail-transaksi');
        Route::put('/transaksi/{id}', [TransaksiController::class, 'UpdateTransaksi'])->name('update-transaksi');
        Route::post('/update-status-transaksi/{id}', [TransaksiController::class, 'UpdateStatusTransaksi'])->name('batal-transaksi');
        Route::get('/transaksi/export-pdf/{id}', [TransaksiController::class, 'ExportToPDF'])->name('export-transaksi');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'DestroyTransaksi'])->name('destroy-transaksi');

        // OUTLET ROUTE !!!! ----
        Route::put('/update-outlet/{uid}', [OutletController::class, 'UpdateOutlet'])->name('update-outlet');

        // KATEGORI ROUTE !!!! ----
        Route::put('/kategori/{id}', [KategoriController::class, 'UpdateKategori'])->name('update-kategori');
        Route::delete('/kategori/{id}', [KategoriController::class, 'DestroyKategori'])->name('destroy-kategori');

        // UNIT ROUTE !!!! ---- 
        Route::put('/unit/{id}', [UnitController::class, 'UpdateUnit'])->name('update-unit');
        Route::delete('/unit/{id}', [UnitController::class, 'DestroyUnit'])->name('destroy-unit');

        // PRODUK ROUTE !!!! ----
        Route::patch('/produks/{id}/status-update', [ProdukController::class, 'StatusProdukUpdate'])->name('update-status-produk-outlet');
        Route::delete('/produks/{id}/delete', [ProdukController::class, 'DestroyProduk'])->name('destroy-produk');

    });

});



