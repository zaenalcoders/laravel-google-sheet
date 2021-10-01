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
        })->unique('name')->values();
        $cancel = collect($collect_data)->filter(function ($i) {
            return $i['status'] == 'Cancel';
        })->unique('name')->values();
        $data['summary']['perusahaan'] = $done->count() + $tbc->count();
        $data['summary']['sasaran'] = collect($collect_data)->sum(function ($i) {
            return (int)$i['pesanan'];
        });
        $data['summary']['dosis'] = $data['summary']['sasaran'] * 2;

        $data['summary']['pie']['perusahaan']['done'] = $done->count();
        $data['summary']['pie']['perusahaan']['tbc'] = $tbc->count();

        $data['summary']['pie']['dosis']['done'] = $done->sum(function ($i) {
            return (int)$i['dosis'];
        });
        $data['summary']['pie']['dosis']['tbc'] = $tbc->sum(function ($i) {
            return (int)$i['dosis'];
        });

        $data['pks']['done']['perusahaan'] = $done->count();
        $data['pks']['done']['dosis'] = $done->sum(function ($i) {
            return (int)$i['dosis'];
        });
        $data['pks']['cancel']['perusahaan'] = $cancel->count();
        $data['pks']['cancel']['dosis'] = $cancel->sum(function ($i) {
            return (int)$i['pesanan'] * 2;
        });
        $data['pks']['tbc']['perusahaan'] = $tbc->count();
        $data['pks']['tbc']['dosis'] = $cancel->sum(function ($i) {
            return (int)$i['pesanan'] * 2;
        }) - ($data['pks']['done']['dosis'] - $data['pks']['cancel']['dosis']);
        return $data;
    }
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        // return $this->kadin();
        $data = $this->kadin();
        return response()->view('pages.dashboard', compact('data'));
    }
}
