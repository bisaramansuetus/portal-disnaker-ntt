<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobVacancyController as AdminJobController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\JobVacancyController as SiteJobController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\PostController as SitePostController;
use App\Http\Controllers\Site\ProgramController as SiteProgramController;
use App\Http\Controllers\Site\SitemapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\ComplaintController as SiteComplaintController;
use App\Http\Controllers\Site\PpidController;
use App\Http\Controllers\Admin\PpidDocumentController;
use App\Http\Controllers\Site\PpidRequestController;
use App\Http\Controllers\Admin\PpidRequestController as AdminPpidRequestController;

// ============ PUBLIC ============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-dinas', [PageController::class, 'profile'])->name('site.profile');
Route::get('/kontak', [ContactController::class, 'index'])->name('site.contact');

Route::get('/pengaduan', [SiteComplaintController::class, 'create'])->name('site.complaints.create');
Route::post('/pengaduan', [SiteComplaintController::class, 'store'])->name('site.complaints.store');
Route::get('/pengaduan/lacak', [SiteComplaintController::class, 'track'])->name('site.complaints.track');
Route::post('/pengaduan/lacak', [SiteComplaintController::class, 'trackResult'])->name('site.complaints.trackResult');
Route::post('/pengaduan/rating/{complaint}', [SiteComplaintController::class, 'submitRating'])->name('site.complaints.submitRating');

// e-PPID
Route::get('/ppid/permohonan', [PpidRequestController::class, 'create'])->name('site.ppid.request_permohonan')->defaults('type', 'permohonan');
Route::get('/ppid/keberatan', [PpidRequestController::class, 'create'])->name('site.ppid.request_keberatan')->defaults('type', 'keberatan');
Route::post('/ppid/permohonan', [PpidRequestController::class, 'store'])->name('site.ppid.store')->defaults('type', 'permohonan');
Route::post('/ppid/keberatan', [PpidRequestController::class, 'store'])->name('site.ppid.store_keberatan')->defaults('type', 'keberatan');
Route::get('/ppid/lacak', [PpidRequestController::class, 'track'])->name('site.ppid.track');
Route::post('/ppid/lacak', [PpidRequestController::class, 'trackResult'])->name('site.ppid.trackResult');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/berita', [SitePostController::class, 'index'])->name('site.posts.index');
Route::get('/berita/kategori/{slug}', [SitePostController::class, 'category'])->name('site.posts.category');
Route::get('/berita/{slug}', [SitePostController::class, 'show'])->name('site.posts.show');

Route::get('/pengumuman', [SitePostController::class, 'announcements'])->name('site.announcements.index');

Route::get('/lowongan', [SiteJobController::class, 'index'])->name('site.jobs.index');
Route::get('/lowongan/{slug}', [SiteJobController::class, 'show'])->name('site.jobs.show');

Route::get('/program', [SiteProgramController::class, 'index'])->name('site.programs.index');
Route::get('/transmigrasi', [SiteProgramController::class, 'transmigrasi'])->name('site.transmigrasi.index');
Route::get('/program/{slug}', [SiteProgramController::class, 'show'])->name('site.programs.show');

Route::get('/ppid/profil', [PpidController::class, 'profile'])->name('site.ppid.profile');
Route::get('/ppid/standar-layanan', [PpidController::class, 'standards'])->name('site.ppid.standards');
Route::get('/ppid/informasi-publik', [PpidController::class, 'documents'])->name('site.ppid.documents');
Route::get('/ppid/download/{document}', [PpidController::class, 'download'])->name('site.ppid.download');

##Route::get('/storage/{path}', [\App\Http\Controllers\StorageController::class, 'show'])
    ##->where('path', '.*')
   ## ->name('storage.serve');

// ============ ADMIN ============
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('posts', AdminPostController::class)->except('show');
        Route::resource('jobs', AdminJobController::class)->except('show');
        Route::resource('programs', AdminProgramController::class)->except('show');

        Route::resource('ppid', PpidDocumentController::class)->except('show');

                // PPID Admin (Gunakan nama alias AdminPpidRequestController)
        Route::get('ppid/requests', [AdminPpidRequestController::class, 'index'])->name('ppid.requests.index');
        Route::get('ppid/requests/{request_item}', [AdminPpidRequestController::class, 'show'])->name('ppid.requests.show');
        Route::put('ppid/requests/{request_item}', [AdminPpidRequestController::class, 'update'])->name('ppid.requests.update');

        // Pengaturan Situs
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // Rute Pengaduan Admin
        Route::resource('complaints', \App\Http\Controllers\Admin\ComplaintController::class)->only(['index', 'show']);
        Route::put('complaints/{complaint}/status', [\App\Http\Controllers\Admin\ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
        Route::post('complaints/{complaint}/response', [\App\Http\Controllers\Admin\ComplaintController::class, 'storeResponse'])->name('complaints.storeResponse');
    });
});