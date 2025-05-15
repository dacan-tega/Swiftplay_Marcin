<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::group(['prefix' => 'lucky81', 'as' => 'lucky81.'], function () {
        Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
            Route::get('', null)->name('root');
            Route::post('/', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@gameAction')->name('action');
            Route::get('/history', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@history')->name('history');
            Route::post('/launch', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@launchGame')->name('launch');
            Route::get('/launch', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@launchGameApi')->name('launch');
            Route::get('/info', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@info')->name('info');
            Route::get('/history', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@history')->name('history');
            Route::get('/payout', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@payout')->name('payout');
            Route::get('/game-rule', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@gameRule')->name('game-rule');
            Route::get('/history', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@history')->name('history');
            Route::get('/history_detail', 'Slotgen\SlotgenLucky81\Http\Controllers\Api\GameController@historyDetail')->name('history_detail');
        });
    });
});
