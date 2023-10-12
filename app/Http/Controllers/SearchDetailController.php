<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\SearchDetailDataTable;

class SearchDetailController extends Controller
{
    public function index(SearchDetailDataTable $dataTable)
    {
        return $dataTable->render('search_details.index');
    }
}
