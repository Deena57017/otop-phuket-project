@extends('admin.layout')
@section('title', 'หน้าสรุปจำนวนการสั่งสินค้ารายปี')
@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black ">
            <div class="card-body">
            <form action="{{url('statistic/year')}}" method="POST">
                <div class="row">
                    <div class="col-md-4" >
                        <div align="right">
                            <select name="year" class="form-control" style="width: 100%;">
                                @for($year = 2018; $year < 2031; $year++)
                                    <option value="{{ $year }}" @if($year == $yearSummary) {{ 'selected' }} @endif >
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div align="left">
                            <button class="w3-btn" style="background-color:#8ad633">เรียกดูสถิติ <i class="fa fa-search "></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5"></div>

                </div>
                {{ csrf_field() }}
            </form>
                <br>

            <canvas id="summary_order" style="height:40vh; width:80vw"></canvas><br>
            <canvas id="summary_total" style="height:40vh; width:80vw"></canvas>
            </div>
        </div>
    </div>
        <br><br>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
    <script>
        let chartOrderData = {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    backgroundColor: {!! json_encode($colorPerMonth) !!},
                    hoverBackgroundColor: {!! json_encode($colorPerMonth) !!},
                    borderWidth: 1,
                    data: {!! json_encode($countOrderPerMonth) !!}
                }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: { display: false },
                title: {
                    display: true,
                    text: 'จำนวนรายการสั่งซื้อประจำปี: ' + {!! json_encode($yearSummary) !!}
                }
            }
        }

        let chartTotalData = {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    backgroundColor: {!! json_encode($colorPerMonth) !!},
                    hoverBackgroundColor: {!! json_encode($colorPerMonth) !!},
                    borderWidth: 1,
                    data: {!! json_encode($totalPerMonth) !!}
                }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: { display: false },
                title: {
                    display: true,
                    text: 'จำนวนราคาการสั่งซื้อประจำปี: ' + {!! json_encode($yearSummary) !!}
                }
            }
        }

        window.onload = function() {
            let chartOrder = document.getElementById('summary_order').getContext('2d');
            new Chart(chartOrder, chartOrderData);

            let chartTotal = document.getElementById('summary_total').getContext('2d');
            new Chart(chartTotal, chartTotalData);
        };
    </script>
@endsection