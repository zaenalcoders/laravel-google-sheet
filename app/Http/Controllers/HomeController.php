<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use stdClass;

class HomeController extends Controller
{
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        $summary = Sheets::spreadsheet(config('sheets.spreadsheet_id'))
            ->sheet(config('sheets.sheet_id'))
            ->range('A1:B1')
            ->get();
        $items = [];
        foreach ($summary as $sheet) {
            $items['count'] = (int)$sheet[0];
            $items['total'] = (int)$sheet[1];
        }
        $sheet_data = Sheets::spreadsheet(config('sheets.spreadsheet_id'))
            ->sheet(config('sheets.sheet_id'))
            ->range('A3:B1400')
            ->get();
        $data = new stdClass;
        $data->summary = (object)$items;
        $data->categories = (object)collect($sheet_data)->map(function ($i) {
            return $i[0];
        });
        $data->values = (object)collect($sheet_data)->map(function ($i) {
            return (float)$i[1];
        });
        return response()->view('home', compact('data'));
    }
}
