<?php

namespace App\Helper;
use Validator;

trait DataViewer {

    public function scopeSearchPaginateAndOrder($query)
    {
        $request = app()->make('request');

        $v = Validator::make($request->only([
            'column', 'direction', 'per_page'
        ]), [
            'column' => 'required|alpha_dash|in:'.implode(',', self::$columns),
            'direction' => 'required|in:asc,desc',
            'per_page' => 'integer|min:1'
        ]);

        if($v->fails()) {
            throw new \Illuminate\Validation\ValidationException($v);
        }

        return $query
            ->orderBy($request->column, $request->direction)
            ->paginate($request->per_page);
    }

}