<?php

Route::get('/', 'TravelerController@index');
Route::get('api/traveler', 'TravelerController@getData');
Route::get('test', function ()
{
	dd(geoip()->getLocation('94.25.169.217')['country']);
});