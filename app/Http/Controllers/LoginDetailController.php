<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\LoginDetailDataTable;

class LoginDetailController extends Controller
{
    public function index(LoginDetailDataTable $dataTable)
    {
        return $dataTable->render('login_details.index');
    }
}
