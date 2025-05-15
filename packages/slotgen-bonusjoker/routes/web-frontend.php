<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => '\\Slotgen\\SlotgenBonusJoker\\Http\\Controllers\\Site', 'prefix' => 'bonusjoker',  'as' => 'bonusjoker.site.'], function () {
    Route::get('/launch', 'GameController@launchGame')->name('launch');
});

Route::get('/test22', 'Slotgen\SlotgenBonusJoker\Http\Controllers\Site\GameController@launchGame')->name('action');
