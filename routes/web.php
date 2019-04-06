<?php


Route::get('/', 'PlaceToPayTestController@index' );
Route::post('paymentRequest', 'PlaceToPayTestController@paymentRequest' );
Route::post('checkCurrentPaymentProcess', 'PlaceToPayTestController@checkCurrentPaymentProcess' );
Route::post('getAllProcessedRequests', 'PlaceToPayTestController@getAllProcessedRequests' );
