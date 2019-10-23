<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\ChildrenImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importExportView()
    {
        return view('imports.index');
    }

    // public function import(ImportFileCsvRequest $request)
    // {
    //     $this->importService->importFile($request->get('data'));

    //     return redirect(route('import.create'))->with('message', trans('import.message.success'));
    // }

    public function import() 
    {
        Excel::import(new ChildrenImport, request()->file('file'));
           
        return back();
    }
}
