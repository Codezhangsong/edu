<?php

namespace App\Http\Controllers;

use PHPExcel_Worksheet_Drawing;

use Excel;

class TestController extends Controller
{
    public function get()
    {
        $excel_file_path = 'public\456.xlsx';
        Excel::load($excel_file_path, function($reader) use( &$res ) {
            $reader = $reader->getSheet(2);
            $res = $reader->toArray();
            dd($res);
        });
    }


}
