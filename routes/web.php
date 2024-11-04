<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ExpeditionController;
use App\Http\Controllers\Master\AuthController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\DiagnosaController;
use App\Http\Controllers\Master\ValidasiController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\Master\PembelianController;
use App\Http\Controllers\Master\TransaksiController;
use App\Http\Controllers\Master\PendaftaranController;
use App\Http\Controllers\Master\MasterJenisBantuanController;
use App\Http\Controllers\Master\Profil\ProfilPerusahaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'form_login']);

Route::post('/proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('/dashboard', [DashboardController::class, 'dashboard_page'])->name('dashboard');
Route::get('/new/list_perusahaan', [ProfilPerusahaanController::class, 'list'])->name('list-perusahaan-new');

Route::get('/new/detail_perusahaan/{id}', [ProfilPerusahaanController::class, 'detail'])->name('detail-perusahaan-new');
Route::get('/new/profil_perusahaan', [ProfilPerusahaanController::class, 'index'])->name('profil_perusahaan-new');
Route::get('/new/jenis_angkutan', [ProfilPerusahaanController::class, 'angkutan'])->name('jenis-angkutan-new');

Route::get('/new/list_quotation', [QuotationController::class, 'index'])->name('list-quotation-new');

Route::get('/new/freight_quotation', [QuotationController::class, 'quotation'])->name('freight-quotation-new');
Route::get('/new/approval_freight_admin', [QuotationController::class, 'approvalFreight'])->name('approvalFreight-new');
Route::get('/new/tambah_approval_freight', [QuotationController::class, 'tambahApprovalFreight'])->name('tambahApprovalFreight-new');

Route::get('/new/freight_expense', [QuotationController::class, 'expense'])->name('freight-expense-new');

Route::get('/new/freight_comparison', [QuotationController::class, 'comparison'])->name('freight-comparison-new');

Route::get('/new/expedition', [ExpeditionController::class, 'expedition'])->name('expedition-new');
Route::get('/new/approval_expedition_admin', [ExpeditionController::class, 'approvalExpedition'])->name('approvalExpedition-new');
Route::get('/new/approval_expedition_user', [ExpeditionController::class, 'approvalExpeditionUser'])->name('approvalExpeditionUser-new');
Route::get('/new/detail_approval_expedition_admin', [ExpeditionController::class, 'detailApprovalExpedition'])->name('detailApprovalExpedition-new');
Route::get('/new/detail_approval_expedition_user', [ExpeditionController::class, 'detailApprovalExpeditionUser'])->name('detailApprovalExpeditionUser-new');
Route::get('/new/tambah_approval_expedition', [ExpeditionController::class, 'tambahApprovalExpedition'])->name('tambahApprovalExpedition-new');




Route::get('/new/rawMaterial', [RawMaterialController::class, 'rawMaterial'])->name('rawMaterial-new');
Route::get('/new/approval_raw_material_admin', [RawMaterialController::class, 'approvalRawMaterial'])->name('approvalRawMaterial-new');
Route::get('/new/approval_raw_material_user', [RawMaterialController::class, 'approvalRawMaterialUser'])->name('approvalRawMaterialUser-new');
Route::get('/new/detail_approval_raw_material_admin', [RawMaterialController::class, 'detailApprovalRawMaterial'])->name('detailApprovalRawMaterial-new');
Route::get('/new/detail_approval_raw_material_user', [RawMaterialController::class, 'detailApprovalRawMaterialUser'])->name('detailApprovalRawMaterialUser-new');
Route::get('/new/tambah_approval_raw_material_admin', [RawMaterialController::class, 'tambahApprovalRawMaterial'])->name('tambahApprovalRawMaterial-new');

Route::get('/new/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase-order-new');
Route::get('/new/display-order', [PurchaseOrderController::class, 'display'])->name('display-order-new');
Route::get('/new/detail_purchase-order', [PurchaseOrderController::class, 'showDetail'])->name('detail-purchase-order-new');


Route::get('/new/packaging', [PackagingController::class, 'packaging'])->name('packaging-new');
Route::get('/new/approval_packaging_admin', [PackagingController::class, 'approvalPackaging'])->name('approvalPackaging-new');
Route::get('/new/approval_packaging_user', [PackagingController::class, 'approvalPackagingUser'])->name('approvalPackagingUser-new');
Route::get('/new/detail_approval_packaging_admin', [PackagingController::class, 'detailApprovalPackaging'])->name('detailApprovalPackaging-new');
Route::get('/new/detail_approval_packaging_user', [PackagingController::class, 'detailApprovalPackagingUser'])->name('detailAdetailApprovalPakcagingUserpprovalRawMaterial-new');
Route::get('/new/tambah_approval_packaging', [PackagingController::class, 'tambahApprovalPackaging'])->name('tambahApprovalPackaging-new');


Route::get('/new/detail_quotation', [QuotationController::class, 'detailQuotation'])->name('detailQuotation-new');
Route::get('/new/confirm_quotation', [QuotationController::class, 'confirmQuotation'])->name('confirmQuotation-new');
Route::get('/new/detail_confirm_quotation', [QuotationController::class, 'detailConfirmQuotation'])->name('detailConfirmQuotation-new');

Route::middleware('islogin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change_password', [AuthController::class, 'ganti_password']);
});

Route::post('/new/save-purchase-order', [PurchaseOrderController::class, 'savePurchaseOrder']);
