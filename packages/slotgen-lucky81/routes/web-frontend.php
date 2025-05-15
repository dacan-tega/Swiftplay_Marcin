<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => '\\Slotgen\\SlotgenLucky81\\Http\\Controllers\\Site', 'prefix' => 'lucky81',  'as' => 'lucky81.site.'], function () {
    Route::get('/launch', 'GameController@launchGame')->name('launch');
});

Route::get('/test22', 'Slotgen\SlotgenLucky81\Http\Controllers\Site\GameController@launchGame')->name('action');
