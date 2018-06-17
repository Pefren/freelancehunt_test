<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traveler;
use Illuminate\Support\Facades\DB;

class TravelerController extends Controller
{
    public function index()
    {
	    $highest_rating = Traveler::selectRaw("sum(rating) as sum_rating, name")
	                              ->groupBy('name')
	                              ->orderBy('sum_rating','desc')
	                              ->first();

	    $average_rating = DB::table('travelers')->selectRaw("AVG(rating) AS value")->first()->value;

        return view('traveler.index')
	        ->with(compact('highest_rating', 'average_rating'));
    }

    public function getData()
    {
        $model = Traveler::searchPaginateAndOrder();
        $columns = Traveler::$columns;

        return response()
            ->json([
                'model' => $model,
                'columns' => $columns
            ]);
    }
}
