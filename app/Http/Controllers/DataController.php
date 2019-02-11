<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function open()
    {
		$datas = "This data is open and can be accessed without the client being authenticated";
		return response()->json(compact('datas'), 200);
	}

	public function closed()
	{
		$datas = "Only authorized users can see this";
		return response()->json(compact('datas'), 200);
	}
}
