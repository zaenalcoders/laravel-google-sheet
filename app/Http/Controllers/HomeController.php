<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Revolution\Google\Sheets\Facades\Sheets;
use stdClass;

class HomeController extends Controller
{

    /**
     * kadin
     *
     * @return void
     */
    public function kadin()
    {
        if (Cache::has('kadin_cached_data')) {
            $perusahaan = Cache::get('kadin_cached_data');
        } else {
            $cached = Sheets::spreadsheet(config('sheets.spreadsheet_id'))
                ->sheet(config('sheets.sheet_id'))
                ->range('C2:U100000')
                ->get();
            Cache::put('kadin_cached_data', $cached, Carbon::now()->addHours(1));
            $perusahaan = $cached;
        }
        $collect_data = collect($perusahaan)->map(function ($i) {
            $l = count($i) - 1;
            return [
                'name' => $i[0],
                'pesanan' => (int)$i[2],
                'sasaran' => (int)$i[$l - 5],
                'dosis' => (int)$i[$l - 4],
                'status' => ($i[$l] == 'Batal VGR' ? 'Cancel' : $i[$l])
            ];
        })->all();
        $done = collect($collect_data)->filter(function ($i) {
            return $i['status'] == 'Done';
        })->unique('name')->values();
        $tbc = collect($collect_data)->filter(function ($i) {
            return $i['status'] == 'To Be Confirmed';
        })->unique('name')->values()->count();
        $cancel = collect($collect_data)->filter(function ($i) {
            return $i['status'] == 'Cancel';
        })->unique('name')->values();
        $data['summary']['jumlah_perusahaan'] = $done->count() + $tbc;
        $data['summary']['jumlah_sasaran'] = collect($collect_data)->sum(function ($i) {
            return (int)$i['pesanan'];
        });
        $data['summary']['jumlah_dosis'] = $data['summary']['jumlah_sasaran'] * 2;
        $data['data']['done']['perusahaan'] = $done->count();
        $data['data']['done']['dosis'] = $done->sum(function ($i) {
            return (int)$i['dosis'];
        });
        $data['data']['cancel']['perusahaan'] = $cancel->count();
        $data['data']['cancel']['dosis'] = $cancel->sum(function ($i) {
            return (int)$i['pesanan'] * 2;
        });
        $data['data']['tbc']['perusahaan'] = $tbc;
        $data['data']['tbc']['dosis'] = $cancel->sum(function ($i) {
            return (int)$i['pesanan'] * 2;
        }) - ($data['data']['done']['dosis'] - $data['data']['cancel']['dosis']);
        return response(json_encode($data, JSON_PRETTY_PRINT))->header('content-type', 'application/json');
    }
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        return $this->kadin();
        //BUMN
        // $cached = Sheets::spreadsheet('1rLEy9cw60TePbn-5M1tqf1A3g5zebNjhNsdDGYCPcY8')
        //     ->sheet('Analisis (Rev 001-OnGoing)')
        //     ->range('B2:B100')
        //     ->get();
        // return response()->json($cached);
        $data = Sheets::spreadsheet(config('sheets.spreadsheet_id'))
            ->sheet(config('sheets.sheet_id'))
            ->range('C2:C100000')
            ->get();
        // $done = $test->filter(function ($i) {
        //     return $i['status'] == 'Done';
        // })->values()->unique('name')->count();
        // $data['test'] = $test;
        // $data['done'] = $done;
        return response(json_encode($data, JSON_PRETTY_PRINT))->header('content-type', 'application/json');
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
