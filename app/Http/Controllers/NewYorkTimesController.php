<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewYorkTimesController extends Controller
{
    public function index()
    {
        return NewYorkTimes::orderBy('pub_date', 'desc')
            ->paginate(10);
    }
}
