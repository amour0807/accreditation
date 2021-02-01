<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Imports\AlumniImport;
use Maatwebsite\Excel\Facades\Excel;

class AlumniImportController extends Controller
{
    public function show(){
        return view('secretary.index');
    }
    public function store(Request $request){
        $file = $request->file('file')->store('import');

        //Excel::import(new AlumniImport, $file);
        $import = new AlumniImport;
        $import->import($file);
        if($import->failures()->isNotEmpty()){
            return back()->withFailures($import->failures());
        }
        // dd($import->errors);
        // (new AlumniImport)->import($file);

        return back()-with('success','Excel file imported successfully');
    }
}
