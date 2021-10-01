@extends('layout')
@section('title')
    Dashboard
@endsection
@section('meta_title')
    Dashboard
@endsection
@section('meta_description')
    Dashboard VGR
@endsection
@section('meta_keywords')
    vgr,dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <h4 class="text-muted text-center mb-3 lh-1 d-block text-truncate">Jumlah Perusahaan</h4>
                            <h2 class="mb-3 text-center">
                                {{ number_format($data['summary']['perusahaan'], 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <h4 class="text-muted text-center mb-3 lh-1 d-block text-truncate">Jumlah Sasaran</h4>
                            <h2 class="mb-3 text-center">
                                {{ number_format($data['summary']['sasaran'], 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <h4 class="text-muted text-center mb-3 lh-1 d-block text-truncate">Dosis</h4>
                            <h2 class="mb-3 text-center">
                                {{ number_format($data['summary']['dosis'], 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="pie_perusahaan" style="height: 320px;"></div>
        </div>
        <div class="col-md-6">
            <div id="pie_dosis" style="height: 320px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 small mt-2">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <th>&nbsp;</th>
                    <th colspan="2" class="text-center">Batch 1</th>
                    <th colspan="2" class="text-center">Batch 2</th>
                    <th colspan="2" class="text-center">Batch 3</th>
                    <th colspan="2" class="text-center">Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center align-middle">GTC, PKS</td>
                        <td class="text-center">Jumlah<br>Perusahaan</td>
                        <td class="text-center align-middle">Dosis</td>
                        <td class="text-center">Jumlah<br>Perusahaan</td>
                        <td class="text-center align-middle">Dosis</td>
                        <td class="text-center">Jumlah<br>Perusahaan</td>
                        <td class="text-center align-middle">Dosis</td>
                        <td class="text-center">Jumlah<br>Perusahaan</td>
                        <td class="text-center align-middle">Dosis</td>
                    </tr>
                    <tr>
                        <td>Done</td>
                        <td class="text-end">211</td>
                        <td class="text-end">372.270</td>
                        <td class="text-end">337</td>
                        <td class="text-end">636.704</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['dosis'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format(211 + 337 + $data['pks']['done']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format(372270 + 636704 + $data['pks']['done']['dosis'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>To be Confirmed</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">{{ number_format($data['pks']['tbc']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['tbc']['dosis'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['tbc']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['tbc']['dosis'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Cancel</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">&nbsp;</td>
                        <td class="text-end">{{ number_format($data['pks']['cancel']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['cancel']['dosis'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['cancel']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['cancel']['dosis'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Total Sasaran yang di Followup</td>
                        <td class="text-end">211</td>
                        <td class="text-end">372.270</td>
                        <td class="text-end">337</td>
                        <td class="text-end">636.704</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['perusahaan']+$data['pks']['tbc']['perusahaan']+$data['pks']['cancel']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['dosis']+$data['pks']['tbc']['dosis']+$data['pks']['cancel']['dosis'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['perusahaan']+$data['pks']['tbc']['perusahaan']+$data['pks']['cancel']['perusahaan'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['pks']['done']['dosis']+$data['pks']['tbc']['dosis']+$data['pks']['cancel']['dosis'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="//code.highcharts.com/highcharts.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            Highcharts.chart('pie_perusahaan', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Perusahaan'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '{point.percentage:.1f} %'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Data',
                    colorByPoint: true,
                    data: [{
                            name: 'Done',
                            y: {{ $data['summary']['pie']['perusahaan']['done'] }}
                        },
                        {
                            name: 'To be Confirmed',
                            y: {{ $data['summary']['pie']['perusahaan']['tbc'] }}
                        },
                    ]
                }],
                credits: {
                    enabled: false
                }
            });
            Highcharts.chart('pie_dosis', {
                chart: {
                    type: 'pie'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Dosis'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '{point.percentage:.1f} %'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Data',
                    colorByPoint: true,
                    data: [{
                            name: 'Done',
                            y: {{ $data['summary']['pie']['dosis']['done'] }}
                        },
                        {
                            name: 'To be Confirmed',
                            y: {{ $data['summary']['pie']['dosis']['tbc'] }}
                        },
                    ]
                }],
                credits: {
                    enabled: false
                }
            });
        });
    </script>
@endsection
