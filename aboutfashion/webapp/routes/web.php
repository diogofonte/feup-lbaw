<?php

// Static Pages
Route::get('/', 'PageController@homePage')->name('home');
Route::get('/about', 'PageController@aboutPage')->name('aboutUs');
Route::get('/contacts', 'PageController@contactsPage')->name('contacts');
Route::get('/help', 'PageController@helpPage')->name('help');



//Admin Pages
Route::get('/admin-panel/admins/{id}','AdminController@show')->name('showAdmin');
Route::get('/admin-panel/', 'AdminPanelController@homePageAdmin')->name('homeAdminPanel');

Route::get('/admin-panel/users','AdminPanelController@usersPageAdmin')->name('usersAdminPanel');
Route::get('/admin-panel/users/{id}/purchase-history','AdminPanelController@userPurchaseHistoryPageAdmin')->name('userPurchaseHistoryAdminPanel');

Route::get('/admin-panel/products','AdminPanelController@productsPageAdmin')->name('productsAdminPanel');
Route::get('/admin-panel/promotions','AdminPanelController@promotionsPageAdmin')->name('promotionsAdminPanel');
Route::patch('/admin-panel/products/{id}/promotions/remove', 'ProductController@removeProductPromotion')->name('removeProductPromotion');
Route::patch('/admin-panel/products/{id}/promotions/add','ProductController@addProductPromotion')->name('addProductPromotion');
Route::get('/admin-panel/categories','AdminPanelController@categoriesPageAdmin')->name('categoriesAdminPanel');
Route::patch('/admin-panel/products/{id}/stocks/add','ProductController@addNewProductStock')->name('addNewProductStock');
Route::patch('/admin-panel/products/{id}/stocks/modify','ProductController@modifyProductStock')->name('modifyProductStock');

Route::get('/admin-panel/orders','AdminPanelController@ordersPageAdmin')->name('ordersAdminPanel');

Route::get('/admin-panel/reviews','AdminPanelController@reviewsPageAdmin')->name('reviewsAdminPanel');

Route::get('/admin-panel/reports','AdminPanelController@reportsPageAdmin')->name('reportsAdminPanel');



//User 
Route::post('/login', 'Auth\LoginController@userLogin')->name('userLogin');
Route::get('/wishlist', 'UserController@showWishlist')->name('wishlist');
Route::get('/notifications', 'UserController@showNotifications')->name('notifications');
Route::get('/checkout', 'OrderController@showCheckout')->name('checkout');
Route::post('/checkout', 'OrderController@checkout')->name('checkoutAction');
Route::get('/users/{id}', 'UserController@show')->name('userView');
Route::patch('/users/{id}', 'UserController@update')->name('userUpdate');
Route::delete('/users/{id}', 'UserController@delete')->name('userDelete');
Route::get('/users/{id}/edit', 'UserController@edit')->name('userUpdateForm');
Route::post('register', 'Auth\RegisterController@register')->name('userRegister');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/picture/{id}', 'UserController@editPicture')->name('editPicture');
Route::delete('/picture/delete/{id}', 'UserController@deletePicture')->name('deletePicture');

//Reviews
Route::get('/review/{id}/edit', 'ReviewController@edit')->name('reviewEditForm');
Route::delete('/review/{id}', 'ReviewController@destroy')->name('reviewDelete');
Route::patch('/review/{id}', 'ReviewController@update')->name('reviewUpdate');
Route::get('/review/create', 'ReviewController@create')->name('reviewCreateForm');
Route::put('/review/create', 'ReviewController@store')->name('reviewCreate');


//Forgot Password
Route::get('/forgot-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forgot.password.view');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forgot.password.action');
Route::get('/reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('password.reset');
Route::post('/reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.action');


Route::get('/admin-panel/forgot-password', 'Auth\ForgotPasswordController@showForgetPasswordAdminForm')->name('forgot.password.admin.view');
Route::post('/admin-panel/forgot-password', 'Auth\ForgotPasswordController@submitForgetPasswordAdminForm')->name('forgot.password.admin.action');
Route::get('/admin-panel/reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordAdminForm')->name('password.admin.reset');
Route::post('/admin-panel/reset-password', 'Auth\ForgotPasswordController@submitResetPasswordAdminForm')->name('reset.password.admin.action');

//Orders
Route::get('/order/{id}', 'OrderController@show')->name('orderDetails');
Route::get('/admin-panel/orders/{id}/editStatus','OrderController@editStatus')->name('editOrderStatus')->middleware('auth:admin');
Route::patch('/admin-panel/orders/{id}/status','OrderController@updateStatus')->name('updateOrderStatus')->middleware('auth:admin');
Route::get('/admin-panel/orders/{id}/edit','OrderController@edit')->name('editOrder')->middleware('auth:admin');
Route::patch('/admin-panel/orders/{id}','OrderController@update')->name('updateOrder')->middleware('auth:admin');
Route::get('/orders/{id}/cancel','OrderController@cancel');


//Cards
Route::get('/cards/{id}/edit', 'CardController@edit')->name('cardEditForm');
Route::delete('/cards/{id}', 'CardController@delete')->name('cardDelete');
Route::patch('/cards/{id}', 'CardController@update')->name('cardUpdate');
Route::get('/cards/create', 'CardController@create')->name('cardCreateForm');
Route::put('/cards/create', 'CardController@store')->name('cardCreate');

//Addresses
Route::get('/address/{id}/edit', 'AddressController@edit')->name('addressEditForm');
Route::delete('/address/{id}', 'AddressController@delete')->name('addressDelete');
Route::patch('/address/{id}', 'AddressController@update')->name('addressUpdate');
Route::get('/address/create', 'AddressController@create')->name('addressCreateForm');
Route::put('/address/create', 'AddressController@store')->name('addressCreate');


//Admin
Route::get('/admin-panel/login', 'Auth\LoginController@showLoginForm')->name('adminLoginForm');
Route::post('/admin-panel/login', 'Auth\LoginController@adminLogin')->name('adminLogin');
Route::get('/admin-panel/logout', 'Auth\LoginController@adminLogout')->name('adminLogout');


//Products
Route::get('/products', 'ProductController@showSearchPage')->name('searchProductView');
Route::get('/products/{id}', 'ProductController@show')->name('productView');
Route::get('/admin-panel/products/{id}/edit','ProductController@edit')->name('editProduct')->middleware('auth:admin');
Route::patch('/admin-panel/products/{id}','ProductController@update')->name('updateProduct')->middleware('auth:admin');
Route::get('/admin-panel/products/create','ProductController@create')->name('createProduct')->middleware('auth:admin');
Route::put('/admin-panel/products/create','ProductController@store')->name('storeProduct')->middleware('auth:admin');
Route::post('/product-image/edit/{id_image}/{id_product}', 'ProductController@editProductImage')->name('editProductImage');
Route::delete('/product-image/delete/{id_image}/{id_product}', 'ProductController@deleteProductImage')->name('deleteProductImage');
Route::post('/product-image/delete/{id_product}', 'ProductController@addProductImage')->name('addProductImage');

//Categories
Route::get('/admin-panel/categories/create','CategoryController@create')->name('createCategory')->middleware('auth:admin');
Route::put('/admin-panel/categories/create','CategoryController@store')->name('storeCategory')->middleware('auth:admin');

//Promotions
Route::get('/admin-panel/promotions/{id}/edit','PromotionController@edit')->name('editPromotion')->middleware('auth:admin');
Route::patch('/admin-panel/promotions/{id}','PromotionController@update')->name('updatePromotion')->middleware('auth:admin');
Route::get('/admin-panel/promotions/create','PromotionController@create')->name('createPromotion')->middleware('auth:admin');
Route::put('/admin-panel/promotions/create','PromotionController@store')->name('storePromotion')->middleware('auth:admin');

//WishList
Route::post('/api/wishlist', 'UserController@toggleProductWishlist');

//Reports
Route::get('/reports/create/{id_review}', 'ReportController@create')->name('createReport')->middleware('auth:admin');
Route::put('/reports/create', 'ReportController@store')->name('storeReport')->middleware('auth:admin');
Route::get('/reports/success','ReportController@success')->name('successReport')->middleware('auth:admin');

//API
Route::get('/api/products/', 'ProductController@searchAPI')->name('productSearchAPI');
Route::get('/api/products/stock', 'StockController@stockAPI')->name('productStockAPI');
Route::post('/api/shopping-cart', 'ShoppingCartController@add')->name('addProductCart');
Route::delete('/api/shopping-cart', 'ShoppingCartController@delete')->name('deleteProductCart');
Route::patch('/api/shopping-cart', 'ShoppingCartController@update')->name('updateProductCart');
Route::delete('api/admin-panel/users', 'AdminController@deleteUser');
Route::patch('api/admin-panel/users', 'AdminController@blockUser');
Route::get('/shopping-cart', 'ShoppingCartController@show')->name('shoppingCartView');
Route::delete('/api/admin-panel/products/{id}', 'ProductController@delete')->middleware('auth:admin');
Route::delete('/api/admin-panel/promotions/{id}', 'PromotionController@delete')->middleware('auth:admin');
Route::delete('/api/admin-panel/orders/{id}', 'OrderController@delete')->middleware('auth:admin');
Route::delete('/api/admin-panel/categories/{id}', 'CategoryController@delete')->middleware('auth:admin');
Route::delete('/api/admin-panel/reviews/{id}', 'ReviewController@delete')->middleware('auth:admin');
Route::patch('/api/admin-panel/reports', 'ReportController@changeReport')->middleware('auth:admin');

// Images
Route::get('/pic', 'ImageController@test');
Route::post('/image/upload', 'ImageController@store')->name('uploadImage');
Route::post('/image/edit', 'ImageController@edit')->name('editImage');
Route::post('/image/delete', 'ImageController@delete')->name('deleteImage');

Route::get('/api/shopping-cart', 'ShoppingCartController@add');