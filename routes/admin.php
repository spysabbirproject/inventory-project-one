<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Contact_messageController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Expense_categoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SellingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\Stock_managementController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function(){
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
                    ->middleware(['signed', 'throttle:6,1']);
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
                    ->middleware('throttle:6,1');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::middleware('verified')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::patch('/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
            Route::put('password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

        Route::middleware(['super_admin'])->group(function(){
            Route::get('default-setting', [SettingController::class, 'defaultSetting'])->name('default.setting');
            Route::post('default-setting-update-{id}', [SettingController::class, 'defaultSettingUpdate'])->name('default.setting.update');

            Route::get('mail-setting', [SettingController::class, 'mailSetting'])->name('mail.setting');
            Route::post('mail-setting-update-{id}', [SettingController::class, 'mailSettingUpdate'])->name('mail.setting.update');

            Route::get('all-administrator', [AdminController::class, 'allAdministrator'])->name('all.administrator');
            Route::get('administrator-status/{id}', [AdminController::class, 'administratorStatus'])->name('administrator.status');
            Route::get('administrator-edit/{id}', [AdminController::class, 'administratoreEdit'])->name('administrator.edit');
            Route::patch('administrator-update/{id}', [AdminController::class, 'administratoreUpdate'])->name('administrator.update');

            Route::get('stock-report', [ReportController::class, 'stockReport'])->name('stock.report');
            Route::post('stock-report-export', [ReportController::class, 'stockReportExport'])->name('stock.report.export');
            Route::get('expense-report', [ReportController::class, 'expenseReport'])->name('expense.report');
            Route::post('expense-report-export', [ReportController::class, 'expenseReportExport'])->name('expense.report.export');
            Route::get('purchase-report', [ReportController::class, 'purchaseReport'])->name('purchase.report');
            Route::post('purchase-report-export', [ReportController::class, 'purchaseReportExport'])->name('purchase.report.export');
            Route::get('selling-report', [ReportController::class, 'sellingReport'])->name('selling.report');
            Route::post('selling-report-export', [ReportController::class, 'sellingReportExport'])->name('selling.report.export');
        });

        Route::middleware(['admin'])->group(function () {
            Route::resource('staff', StaffController::class);
            Route::get('staff-trashed', [StaffController::class, 'trashed'])->name('staff.trashed');
            Route::get('staff-restore/{id}', [StaffController::class, 'restore'])->name('staff.restore');
            Route::get('staff-forcedelete/{id}', [StaffController::class, 'forceDelete'])->name('staff.forcedelete');
            Route::get('staff-status/{id}', [StaffController::class, 'status'])->name('staff.status');
            Route::get('staff-salary', [StaffController::class, 'staffSalary'])->name('staff.salary');
            Route::get('staff-salary-payment-form/{id}', [StaffController::class, 'staffSalaryPaymentForm'])->name('staff.salary.payment.form');
            Route::post('staff-salary-payment-store/{id}', [StaffController::class, 'staffSalaryPaymentStore'])->name('staff.salary.payment.store');
            Route::get('staff-salary-payment-details/{id}', [StaffController::class, 'staffSalaryPaymentDetails'])->name('staff.salary.payment.details');

            Route::get('all-contact-message', [Contact_messageController::class, 'allContactMessage'])->name('all.contact.message');
            Route::get('contact-message-view/{id}', [Contact_messageController::class, 'contactMessageView'])->name('contact.message.view');
            Route::get('contact-message-delete/{id}', [Contact_messageController::class, 'contactMessageDelete'])->name('contact.message.delete');

            Route::resource('expense-category', Expense_categoryController::class);
            Route::get('expense-category-trashed', [Expense_categoryController::class, 'trashed'])->name('expense-category.trashed');
            Route::get('expense-category-restore/{id}', [Expense_categoryController::class, 'restore'])->name('expense-category.restore');
            Route::get('expense-category-forcedelete/{id}', [Expense_categoryController::class, 'forceDelete'])->name('expense-category.forcedelete');
            Route::get('expense-category-status/{id}', [Expense_categoryController::class, 'status'])->name('expense-category.status');

            Route::resource('expense', ExpenseController::class);
            Route::get('expense-trashed', [ExpenseController::class, 'trashed'])->name('expense.trashed');
            Route::get('expense-restore/{id}', [ExpenseController::class, 'restore'])->name('expense.restore');
            Route::get('expense-forcedelete/{id}', [ExpenseController::class, 'forceDelete'])->name('expense.forcedelete');
            Route::get('expense-status/{id}', [ExpenseController::class, 'status'])->name('expense.status');
        });

        Route::middleware(['manager'])->group(function () {
            Route::resource('supplier', SupplierController::class);
            Route::get('supplier-trashed', [SupplierController::class, 'trashed'])->name('supplier.trashed');
            Route::get('supplier-restore/{id}', [SupplierController::class, 'restore'])->name('supplier.restore');
            Route::get('supplier-forcedelete/{id}', [SupplierController::class, 'forceDelete'])->name('supplier.forcedelete');
            Route::get('supplier-status/{id}', [SupplierController::class, 'status'])->name('supplier.status');

            Route::resource('customer', CustomerController::class);
            Route::get('customer-trashed', [CustomerController::class, 'trashed'])->name('customer.trashed');
            Route::get('customer-restore/{id}', [CustomerController::class, 'restore'])->name('customer.restore');
            Route::get('customer-forcedelete/{id}', [CustomerController::class, 'forceDelete'])->name('customer.forcedelete');
            Route::get('customer-status/{id}', [CustomerController::class, 'status'])->name('customer.status');

            Route::resource('category', CategoryController::class);
            Route::get('category-trashed', [CategoryController::class, 'trashed'])->name('category.trashed');
            Route::get('category-restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
            Route::get('category-forcedelete/{id}', [CategoryController::class, 'forceDelete'])->name('category.forcedelete');
            Route::get('category-status/{id}', [CategoryController::class, 'status'])->name('category.status');

            Route::resource('brand', BrandController::class);
            Route::get('brand-trashed', [BrandController::class, 'trashed'])->name('brand.trashed');
            Route::get('brand-restore/{id}', [BrandController::class, 'restore'])->name('brand.restore');
            Route::get('brand-forcedelete/{id}', [BrandController::class, 'forceDelete'])->name('brand.forcedelete');
            Route::get('brand-status/{id}', [BrandController::class, 'status'])->name('brand.status');

            Route::resource('unit', UnitController::class);
            Route::get('unit-trashed', [UnitController::class, 'trashed'])->name('unit.trashed');
            Route::get('unit-restore/{id}', [UnitController::class, 'restore'])->name('unit.restore');
            Route::get('unit-forcedelete/{id}', [UnitController::class, 'forceDelete'])->name('unit.forcedelete');
            Route::get('unit-status/{id}', [UnitController::class, 'status'])->name('unit.status');

            Route::resource('product', ProductController::class);
            Route::get('product-trashed', [ProductController::class, 'trashed'])->name('product.trashed');
            Route::get('product-restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
            Route::get('product-forcedelete/{id}', [ProductController::class, 'forceDelete'])->name('product.forcedelete');
            Route::get('product-status/{id}', [ProductController::class, 'status'])->name('product.status');

            Route::get('purchase-product', [PurchaseController::class, 'purchaseProduct'])->name('purchase.product');
            Route::get('purchase-cart-delete', [PurchaseController::class, 'purchaseCartDelete'])->name('purchase.cart.delete');
            Route::post('purchase-product-list', [PurchaseController::class, 'getProducts'])->name('purchase.product.list');
            Route::post('purchase-product-details', [PurchaseController::class, 'purchaseProductDetails'])->name('purchase.product.details');
            Route::post('add-purchase-cart', [PurchaseController::class, 'purchaseCartStore'])->name('add.purchase.cart');
            Route::post('purchase-cart-item-delete', [PurchaseController::class, 'purchaseCartItemDelete'])->name('purchase.cart.item.delete');
            Route::post('change-purchase-quantity', [PurchaseController::class, 'changePurchaseQuantity'])->name('change.purchase.quantity');
            Route::post('change-purchase-price', [PurchaseController::class, 'changePurchasePrice'])->name('change.purchase.price');
            Route::post('purchase-sub-total', [PurchaseController::class, 'getSubTotal'])->name('purchase.subtotal');
            Route::post('store-purchase-product', [PurchaseController::class, 'purchaseProductStore'])->name('store.purchase.product');

            Route::get('purchase-list', [PurchaseController::class, 'purchaseList'])->name('purchase.list');
            Route::get('supplier-payment/{purchase_invoice_no}', [PurchaseController::class, 'supplierPayment'])->name('supplier.payment');
            Route::post('supplier-payment-update/{purchase_invoice_no}', [PurchaseController::class, 'supplierPaymentUpdate'])->name('supplier.payment.update');
            Route::get('purchase-invoice/{purchase_invoice_no}', [PurchaseController::class, 'purchaseInvoice'])->name('purchase.invoice');

            Route::get('selling-product', [SellingController::class, 'sellingProduct'])->name('selling.product');
            Route::get('selling-cart-delete', [SellingController::class, 'sellingCartDelete'])->name('selling.cart.delete');
            Route::post('selling-product-list', [SellingController::class, 'getProducts'])->name('selling.product.list');
            Route::post('selling-product-details', [SellingController::class, 'sellingProductDetails'])->name('selling.product.details');
            Route::post('add-selling-cart', [SellingController::class, 'sellingCartStore'])->name('add.selling.cart');
            Route::post('selling-cart-item-delete', [SellingController::class, 'sellingCartItemDelete'])->name('selling.cart.item.delete');
            Route::post('change-selling-quantity', [SellingController::class, 'changeSellingQuantity'])->name('change.selling.quantity');
            Route::post('change-selling-price', [SellingController::class, 'changeSellingPrice'])->name('change.selling.price');
            Route::post('selling-subtotal', [SellingController::class, 'getSubTotal'])->name('selling.subtotal');
            Route::post('store-selling-product', [SellingController::class, 'sellingProductStore'])->name('store.selling.product');

            Route::get('selling-list', [SellingController::class, 'sellingList'])->name('selling.list');
            Route::get('customer-payment/{selling_invoice_no}', [SellingController::class, 'customerPayment'])->name('customer.payment');
            Route::post('customer-payment-update/{selling_invoice_no}', [SellingController::class, 'customerPaymentUpdate'])->name('customer.payment.update');
            Route::get('selling-invoice/{selling_invoice_no}', [SellingController::class, 'sellingInvoice'])->name('selling.invoice');

            Route::get('stock-products', [AdminController::class, 'stockProducts'])->name('stock.products');
        });
        });
    });
});
