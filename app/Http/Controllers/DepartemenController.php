<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index_list()
    {
        return view('listMahasiswa');
    }
}
