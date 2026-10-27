<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DignitaryController;
use App\Http\Controllers\Admin\SchemeController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\WhatsNewController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\Admin\ImportantLinkController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialPostController;

// Public Front-end Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Industry Technical Issues & Troubleshooting Portal
Route::get('/industry-tech-issues', [\App\Http\Controllers\IndustryTechIssueController::class, 'index'])->name('industry-tech-issues.index');
Route::post('/industry-tech-issues', [\App\Http\Controllers\IndustryTechIssueController::class, 'store'])->name('industry-tech-issues.store');
Route::get('/industry-tech-issues/{slug}', [\App\Http\Controllers\IndustryTechIssueController::class, 'show'])->name('industry-tech-issues.show');
Route::post('/industry-tech-issues/{id}/reply', [\App\Http\Controllers\IndustryTechIssueController::class, 'reply'])->name('industry-tech-issues.reply');
Route::post('/industry-tech-issues/{id}/vote', [\App\Http\Controllers\IndustryTechIssueController::class, 'vote'])->name('industry-tech-issues.vote');

// Specific Page Overrides & Redirects (Must be before generic /page/{slug})
Route::get('/whats-new', [HomeController::class, 'whatsNew'])->name('whats-new.index');
Route::get('/page/whats-new', fn() => redirect()->route('whats-new.index'));
Route::get('/page/industry-tech-issues', fn() => redirect()->route('industry-tech-issues.index'));
Route::get('/page/testing-service', fn() => redirect()->route('page.show', 'testing-services'));
Route::get('/tefc', fn() => redirect()->route('page.show', 'tefcs'));
Route::get('/tefcs', fn() => redirect()->route('page.show', 'tefcs'));
Route::get('/page/tefc', fn() => redirect()->route('page.show', 'tefcs'));
Route::get('/textile-export-facilitation-center', fn() => redirect()->route('page.show', 'tefcs'));
Route::get('/rti', fn() => redirect()->route('page.show', 'rti'));
Route::get('/right-to-information', fn() => redirect()->route('page.show', 'rti'));

// Convenience Aliases for Standard Government Footer & Header Routes
Route::get('/policies', fn() => redirect()->route('page.show', 'website-policies'))->name('footer.policies');
Route::get('/website-policies', fn() => redirect()->route('page.show', 'website-policies'));
Route::get('/help', fn() => redirect()->route('page.show', 'faq'))->name('footer.help');
Route::get('/faq', fn() => redirect()->route('page.show', 'faq'));
Route::get('/sitemap', fn() => redirect()->route('page.show', 'sitemap'))->name('footer.sitemap');
Route::get('/connect', fn() => redirect()->route('page.show', 'contact-us'))->name('footer.connect');
Route::get('/contact-us', fn() => redirect()->route('page.show', 'contact-us'))->name('footer.contact');
Route::get('/archives', fn() => redirect()->route('page.show', 'reports-budget'))->name('footer.archives');
Route::get('/feedback', fn() => redirect()->to(url('/#feedbackModal')));

// SEO Engine - Sitemap & Robots
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('seo.robots');

// Real-time Bhashini & Multi-language Analytics API
Route::post('/api/analytics/track-bhashini', [\App\Http\Controllers\AnalyticsApiController::class, 'trackBhashini'])->name('api.analytics.bhashini');

// Generic Dynamic Page Route
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page.show');
Route::post('/inquiry', [HomeController::class, 'submitInquiry'])->name('inquiry.submit');
Route::get('/search', [HomeController::class, 'search'])->name('site.search');
Route::get('/locale/{lang}', [HomeController::class, 'toggleLocale'])->name('locale.switch');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Admin CMS Protected Routes
Route::middleware(['admin.auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Content Management Modules
    Route::resource('banners', BannerController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('dignitaries', DignitaryController::class);
    Route::resource('schemes', SchemeController::class);
    Route::resource('tenders', TenderController::class);
    Route::resource('whats-new', WhatsNewController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('personas', PersonaController::class);
    Route::resource('important-links', ImportantLinkController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::post('social-posts/quick-store', [SocialPostController::class, 'quickStore'])->name('social-posts.quick-store');
    Route::get('social-posts/fetch-metadata', [SocialPostController::class, 'fetchMetadata'])->name('social-posts.fetch-metadata');
    Route::resource('social-posts', SocialPostController::class);
    Route::post('menus/reorder', [\App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('menus.reorder');
    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
    Route::get('pages/{page}/visual-editor', [PageController::class, 'visualEditor'])->name('pages.visual-editor');
    Route::post('pages/{page}/visual-editor', [PageController::class, 'saveVisualEditor'])->name('pages.visual-editor.save');
    Route::post('pages/upload-image', [PageController::class, 'uploadImage'])->name('pages.upload-image');
    Route::post('pages/upload-pdf', [PageController::class, 'uploadPdf'])->name('pages.upload-pdf');
    Route::post('pages/upload-video', [PageController::class, 'uploadVideo'])->name('pages.upload-video');
    Route::resource('pages', PageController::class);

    // Media Library & File Manager
    Route::get('media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');
    Route::get('media/list-api', [\App\Http\Controllers\Admin\MediaController::class, 'listApi'])->name('media.list-api');
    Route::post('media/sync', [\App\Http\Controllers\Admin\MediaController::class, 'syncExisting'])->name('media.sync');
    Route::delete('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');

    // Contact Us Management & Headquarters Directory
    Route::get('contact-us', [\App\Http\Controllers\Admin\ContactUsAdminController::class, 'index'])->name('contact-us.index');
    Route::post('contact-us', [\App\Http\Controllers\Admin\ContactUsAdminController::class, 'update'])->name('contact-us.update');

    // Footer Management (Useful Links, Portals, Badges, Legal Text)
    Route::get('footer', [\App\Http\Controllers\Admin\FooterController::class, 'index'])->name('footer.index');
    Route::post('footer', [\App\Http\Controllers\Admin\FooterController::class, 'update'])->name('footer.update');

    // Inquiries / Feedback
    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::post('inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Industry Tech Issues & Solutions Management
    Route::get('industry-tech-issues', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'index'])->name('industry-tech-issues.index');
    Route::get('industry-tech-issues/create', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'create'])->name('industry-tech-issues.create');
    Route::post('industry-tech-issues', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'store'])->name('industry-tech-issues.store');
    Route::get('industry-tech-issues/{id}', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'show'])->name('industry-tech-issues.show');
    Route::get('industry-tech-issues/{id}/edit', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'edit'])->name('industry-tech-issues.edit');
    Route::put('industry-tech-issues/{id}', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'update'])->name('industry-tech-issues.update');
    Route::post('industry-tech-issues/{id}/solution', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'updateSolution'])->name('industry-tech-issues.solution');
    Route::post('industry-tech-issues/{id}/status', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'updateStatus'])->name('industry-tech-issues.status');
    Route::delete('industry-tech-issues/{issue}/replies/{reply}', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'deleteReply'])->name('industry-tech-issues.reply.destroy');
    Route::delete('industry-tech-issues/{id}', [\App\Http\Controllers\Admin\IndustryTechIssueAdminController::class, 'destroy'])->name('industry-tech-issues.destroy');

    // Audit / Activity Logs
    Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::post('logs/clear', [ActivityLogController::class, 'clear'])->name('logs.clear');

    // Site Analytics & Bhashini Multi-Language Insights
    Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');

    // Site Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // User Management (Super Admin only)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
