@extends('admin.layout')
@section('title', 'หน้าสรุปจำนวนการสั่งสินค้ารายเดือน')
@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black ">
            <div class="card-body">
            <form action="{{url('statistic/month')}}" method="POST">
                <div class="row">
                    <div class="col-md-5" >
                        <div align="right">
                            <select name="month" class="form-control" style="width: 100%;">
                                @for($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}" @if($month == $monthSummary) {{ 'selected' }} @endif >
                                        {{ $monthList[$month] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5" >
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
                    <div class="col-md-2">
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
        const getDaysInMonth = function(month,year) {
            return new Date(year, month, 0).getDate();
        };

        const daysInMonth = getDaysInMonth({!! json_encode($monthSummary) !!}, {!! json_encode($yearSummary) !!})
        const dayList = []
        for (let index = 1; index <= daysInMonth; index++) {
            const dayText = index.toString().padStart(2, '0')
            dayList.push(dayText)
        }

        let chartOrderData = {
            type: 'bar',
            data: {
                labels: dayList,
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
                    text: 'จำนวนรายการสั่งซื้อประจำเดือน: ' + {!! json_encode($monthList[$monthSummary]) !!} + ' ' + {!! json_encode($yearSummary) !!}
                }
            }
        }

        let chartTotalData = {
            type: 'bar',
            data: {
                labels: dayList,
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
                    text: 'จำนวนราคาการสั่งซื้อประจำเดือน: ' + {!! json_encode($monthList[$monthSummary]) !!} + ' ' + {!! json_encode($yearSummary) !!}
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