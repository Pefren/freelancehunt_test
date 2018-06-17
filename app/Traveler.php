<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\DataViewer;

class Traveler extends Model
{
	use DataViewer;

	public static $columns = [
		'id', 'name', 'checkin date', 'checkin country',
		'ip', 'rating', 'favorite country',
		'is active', 'created at',
		'updated at'
	];
}
