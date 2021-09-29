<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Testing Google Sheet</title>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.6.0.slim.js"></script>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-6 text-start">
                <a class="btn btn-primary" href="https://docs.google.com/spreadsheets/d/12msPt8b5Kc31tkayx7dYmLkbK8FNgwqRbDmppqxBgOg/edit?usp=sharing" target="_blank">
                    Edit Google Sheet
                </a>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary" onclick="window.location.reload()">
                    Reload Data
                </button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <h3 style="text-align: center">Count : {{ $data->summary->count }}</h3>
            </div>
            <div class="col-6">
                <h3 style="text-align: center">Total : {{ number_format($data->summary->total, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div>
            <div id="chart"></div>
        </div>
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        $(document).ready(() => {
            Highcharts.chart('chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Google sheet data'
                },
                xAxis: {
                    categories: {!! collect($data->categories)->toJson() !!},
                    crosshair: true
                },
                series: [{
                    name: 'Data',
                    data: {!! collect($data->values)->toJson() !!}

                }]
            });
        });
    </script>
</body>

</html>
