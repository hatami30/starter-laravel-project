<?php

namespace Modules\DocumentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function index()
    {
        return view("documentmanagement::index");
    }

    public function create()
    {
        return view("documentmanagement::create");
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view("documentmanagement::show");
    }

    public function edit($id)
    {
        return view("documentmanagement::edit");
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
