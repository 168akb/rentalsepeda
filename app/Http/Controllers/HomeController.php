<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Member;
use App\ProductTranscation;
use App\Transcation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['totalTransaksi'] = Transcation::where('status', 'selesai')->count();
        $data['totalMember'] = User::where('level_id', 3)->count();
        $data['totalSepeda'] = Product::count();
        $data['totalIncomeMonth'] = Transcation::where('created_at','LIKE','%'.date('Y-m').'%')
                                    ->where('status', 'Selesai')
                                    ->sum('grand_total');
        $tr = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->where('tgl_sewa','LIKE','%'.date('Y-m').'%')
                                    ->groupBy(\DB::raw('day(tgl_sewa)'))
                                    ->orderBy(\DB::raw('day(tgl_sewa)'))
                                    ->get();
        $mn = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->where('tgl_sewa','LIKE','%'.date('Y').'%')
                                    ->groupBy(\DB::raw('month(tgl_sewa)'))
                                    ->orderBy(\DB::raw('month(tgl_sewa)'))
                                    ->get();
        $yr = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->groupBy(\DB::raw('year(tgl_sewa)'))
                                    ->orderBy(\DB::raw('year(tgl_sewa)'))
                                    ->get();
        $chart = [];
        $month = [];
        $year = [];
        foreach ($tr as $row){
            $chart['label'][] = $row->tgl_sewa;
            $chart['data'][] = (int)$row->count;
        }
        foreach ($mn as $row){
            $month['label'][] = $row->tgl_sewa;
            $month['data'][] = (int)$row->count;
        }
        foreach ($yr as $row){
            $year['label'][] = $row->tgl_sewa;
            $year['data'][] = (int)$row->count;
        }
        $chart['chart_data'] = json_encode($chart);
        $month['chart_data'] = json_encode($month);
        $year['chart_data'] = json_encode($year);

        return view('home', compact('data','chart','month','year'));
    }

    public function filter(Request $request){
        $data['totalTransaksi'] = Transcation::where('status', 'selesai')->count();
        $data['totalMember'] = User::where('level_id', 3)->count();
        $data['totalSepeda'] = Product::count();
        $data['totalIncomeMonth'] = Transcation::where('created_at','LIKE','%'.date('Y-m').'%')
                                    ->where('status', 'Selesai')
                                    ->sum('pay');
        $tr = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->whereBetween('tgl_sewa',[$request->awal,$request->akhir])
                                    ->groupBy('tgl_sewa')
                                    ->orderBy('tgl_sewa')
                                    ->get();
        $mn = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->whereBetween('tgl_sewa',[$request->awal,$request->akhir])
                                    ->groupBy(\DB::raw('month(tgl_sewa)'))
                                    ->orderBy(\DB::raw('month(tgl_sewa)'))
                                    ->get();
        $yr = Transcation::select(\DB::raw("COUNT(*) as count"), \DB::raw("tgl_sewa"))
                                    ->groupBy(\DB::raw('year(tgl_sewa)'))
                                    ->orderBy(\DB::raw('year(tgl_sewa)'))
                                    ->get();

        $chart = [];
        $month = [];
        $year = [];

        foreach ($tr as $row){
            $chart['label'][] = $row->tgl_sewa;
            $chart['data'][] = (int)$row->count;
        }
        foreach ($mn as $row){
            $month['label'][] = $row->tgl_sewa;
            $month['data'][] = (int)$row->count;
        }
        foreach ($yr as $row){
            $year['label'][] = $row->tgl_sewa;
            $year['data'][] = (int)$row->count;
        }

        $chart['chart_data'] = json_encode($chart);
        $month['chart_data'] = json_encode($month);
        $year['chart_data'] = json_encode($year);

        return view('home', compact('data','chart','month','year'));
    }
}