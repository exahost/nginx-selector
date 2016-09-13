<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Dashboard extends Controller
{
    public function index()	{
		return view('dashboard.index');
	}
    public function server_list()	{
		return view('dashboard.server-list');
	}
}
