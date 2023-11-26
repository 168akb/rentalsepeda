@extends('layouts.app')

@section('title','Dashboard')

@section('content')

    @if(Auth::user()->level_id != '3')
<!-- Start Status area -->
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2><span class="counter">{{$data['totalTransaksi']}}</span></h2>
                            <p>Transaksi Berhasil</p>
                        </div>
                        <div class="sparkline-bar-stats1">9,4,8,6,5,6,4,8,3,5,9,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2><span class="counter">{{$data['totalMember']}}</span></h2>
                            <p>Total Member</p>
                        </div>
                        <div class="sparkline-bar-stats2">1,4,8,3,5,6,4,8,3,3,9,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2><span class="counter">{{$data['totalSepeda']}}</span> Unit</h2>
                            <p>Total Sepeda</p>
                        </div>
                        <div class="sparkline-bar-stats3">4,2,8,2,5,6,3,8,3,5,9,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2>Rp. <span class="counter">{{ $data['totalIncomeMonth'] }}</span></h2>
                            <p>Pendapatan Bulan Ini</p>
                        </div>
                        <div class="sparkline-bar-stats4">2,4,8,4,5,7,4,7,3,5,7,5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Status area-->

    <!-- Bar Chart area End-->
    <div class="line-chart-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="line-chart-wp chart-display-nn">
                        <h3>Tabel tren penyewaan sepeda</h3>
                        <canvas height="140vh" width="380vw" id="myChart"></canvas>
                        <br>
                        <div class="row form-group">
                                <div class="col-sm-3">
                                    <br>
                                    <button class="btn btn-sm btn-primary" onclick="timeparse(this)" value="year">Tahunan</button>
                                    <button class="btn btn-sm btn-primary" onclick="timeparse(this)" value="month">Bulanan</button>
                                    <button class="btn btn-sm btn-primary" onclick="timeparse(this)" value="day">Harian</button>
                                </div>
                            <form action="{{ route('home.filter') }}" method="GET">
                                <div class="col-sm-3">
                                    <label for="awal">Tanggal</label>
                                    <input id="awal" class="form-control" type="date" name="awal" value="{{ app('request')->input('awal') }}" >
                                </div>
                                <div class="col-sm-3">
                                    <label for="akhir">Tanggal Akhir</label>
                                    <input id="akhir" class="form-control" type="date" name="akhir" value="{{ app('request')->input('akhir') }}" >
                                </div>
                                <div class="col-sm-2" style="padding-top: 25px">
                                    <button type="submit" class="btn btn-primary" ><i class="fa fa-filter"></i></button>
                            </form>
                                    <a href="/"><i class="btn btn-success">Clear</i></a>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bar Chart area End-->
    @else
        <div class="line-chart-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height:54vh;">

                    <div class="line-chart-wp chart-display-nn">
                        <h1>Halo, <b>{{Auth::user()->name}}</b>.</h1>
                        <br>
                        <h2>Selamat Datang di Sistem Informasi Rental Sepeda Rysafi!</h2>
                        <br>
                        <h2>Anda login sebagai <b>{{Auth::user()->level->name}}</b>.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@include('layouts.checkdata')

@endsection
@push('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script>

var cData = JSON.parse('<?php echo $chart['chart_data']; ?>');
var mData = JSON.parse('<?php echo $month['chart_data']; ?>');
var yData = JSON.parse('<?php echo $year['chart_data']; ?>');

const ctx = document.getElementById('myChart');
const data =  {
    type: 'line',
    data: {
        labels: cData.label,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: cData.data,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 3
        }]
    },
    options: {
        scales: {
            x:{
                type: 'time',
                time:{
                    unit:'day',
                }
            },
            y:{
                ticks:{
                    stepSize: 1,
                    beginAtZero: true
                    }
            }
        }
    }
};
const chart = new Chart(ctx, data);
function timeparse(period){
    console.log(period.value);
    if(period.value == 'month'){
        chart.options.scales.x.time.unit = period.value;
        chart.data.labels = mData.label;
        chart.data.datasets[0].data = mData.data;
        chart.options.scales.x.time.unit = 'month';
        console.log(chart.options.scales.x.time.unit);
        console.log(chart.data.labels);
    }
    if(period.value == 'year'){
        chart.options.scales.x.time.unit = period.value;
        chart.data.labels = yData.label;
        chart.options.scales.y.ticks.stepSize = 4;
        chart.data.datasets[0].data = yData.data;
        chart.options.scales.x.time.unit = 'year';
        console.log(chart.options.scales.x.time.unit);
        console.log(chart.data.labels);
    }
    if(period.value == 'day'){
        chart.options.scales.x.time.unit = period.value;
        chart.data.labels = cData.label;
        chart.data.datasets[0].data = cData.data;
        console.log(chart.options.scales.x.time.unit);
        console.log(chart.data.labels);
    }

    chart.update();
}
</script>
@endpush