<?php

Route::get('user', 'UserController@welcome');

Route::group(['module' => 'User', 'prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/view_users', [App\Modules\User\Http\Controllers\UserController::class, 'viewUsers'])->name('view_users');
    Route::post('/get_users', [App\Modules\User\Http\Controllers\UserController::class, 'getUsers'])->name('get_users');
    Route::post('/save_user', [App\Modules\User\Http\Controllers\UserController::class, 'saveUser'])->name('save_user');
    Route::post('/update_user', [App\Modules\User\Http\Controllers\UserController::class, 'updateUser'])->name('update_user');
    Route::post('/delete_user', [App\Modules\User\Http\Controllers\UserController::class, 'deleteUser']);
    Route::get('/add_user', [App\Modules\User\Http\Controllers\UserController::class, 'addUser'])->name('add_user');
    Route::get('/edit_user/{id}', [App\Modules\User\Http\Controllers\UserController::class, 'editUser'])->name('edit_user');

    Route::get('/view_user_role_permission', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'viewUserRolePermission'])->name('view_user_role_permission');

    Route::get('/view_role_permissions', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'viewRolePermissions'])->name('view_role_permissions');
    Route::post('/get_role_permissions', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'getRolePermissions'])->name('get_role_permissions');
    Route::post('/save_role_permission', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'saveRolePermission'])->name('save_role_permission');
    Route::post('/update_role_permission', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'updateRolePermission'])->name('update_role_permission');
    Route::post('/delete_role_permission', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'deleteRolePermission']);
    Route::get('/add_role_permission', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'addRolePermission'])->name('add_role_permission');
    Route::get('/edit_role_permission/{id}', [App\Modules\User\Http\Controllers\RolePermissionController::class, 'editRolePermission'])->name('edit_role_permission');
});
