@php
    $flat_colors = collect([
        '#2196f3',
        '#2196f3dd',
        '#7cc5ffaa',
        '#9ed2fb88',
        '#0fb8ff66',
        '#5aceff44',
        '#8eddff22',
        '#c5edff00',
        '#c5edff00',
        '#c5edff00',
        '#c5edff00',
    ]);
@endphp
<div class="col-12 p-0">
    <div class="">
        {{-- {{ dd($data) }} --}}
    </div>
    {{-- <div class="col-12 my-2 px-2 ">
        <div class="col-12  main-box row">
            <div class="col-12  px-3 py-3 ">
                @php
                $from = Carbon::parse($from);
                $to = Carbon::parse($to);
                @endphp
                إحصائيات {{$from->diffInDays($to)}} أيام
            </div>
        </div>
    </div> --}}
    @section('scripts')
        @can('admin-analytics-read')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
                new Chart(document.getElementById('traffics-chart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: [
                            @foreach (array_reverse($data['traffics']) as $key => $value)
                                "{{ $key }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: '# معدل الزوار',
                            data: [
                                @foreach (array_reverse($data['traffics']) as $key => $value)
                                    "{{ $value }}",
                                @endforeach
                            ],
                            backgroundColor: "#2196f3cc",
                            borderColor: '#2196f3',
                            pointStyle: 'rect',
                            lineTension: '.15',
                            tension: 0.1,
                            fill: true,
                            pointStyle: "circle",
                            pointBorderColor: "#2196f3",
                            pointBackgroundColor: "#fff",
                            pointRadius: 4,
                            borderWidth: 3.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                                labels: {
                                    font: {
                                        size: 14,
                                        family: "kufi-arabic"
                                    }
                                }
                            }
                        },
                        scales: {

                            x: {
                                beginAtZero: false,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: true,
                                    color: "rgb(3,169,244,0.05)"
                                }
                            },

                        },
                        hover: {
                            mode: 'index'
                        },
                        legend: {
                            labels: {

                                fontFamily: 'kufi-arabic',
                                defaultFontFamily: 'kufi-arabic',
                            }
                        },
                        elements: {
                            line: {
                                tension: 1
                            }
                        }
                    }
                });





                new Chart(document.getElementById('new-users').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: [
                            @foreach (array_reverse($data['new_users']['days_list']) as $day)
                                "{{ $day }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: '# معدل المستخدمين الجدد',
                            data: [
                                @foreach (array_reverse($data['new_users']['counts_list']) as $count)
                                    "{{ $count }}",
                                @endforeach
                            ],
                            backgroundColor: "#2196f3cc",
                            borderColor: '#2196f3',
                            pointStyle: 'rect',
                            lineTension: '.15',
                            tension: 0.1,
                            fill: true,
                            pointStyle: "circle",
                            pointBorderColor: "#2196f3",
                            pointBackgroundColor: "#fff",
                            pointRadius: 4,
                            borderWidth: 3.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                                labels: {
                                    font: {
                                        size: 14,
                                        family: "kufi-arabic"
                                    }
                                }
                            }
                        },
                        scales: {

                            x: {
                                beginAtZero: false,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: true,
                                    color: "rgb(3,169,244,0.05)"
                                }
                            },

                        },
                        hover: {
                            mode: 'index'
                        },
                        legend: {
                            labels: {

                                fontFamily: 'kufi-arabic',
                                defaultFontFamily: 'kufi-arabic',
                            }
                        },
                        elements: {
                            line: {
                                tension: 1
                            }
                        }
                    }
                });
                const ChartBrowsers = new Chart(document.getElementById('ChartBrowsers'), {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @foreach ($data['top_browsers'] as $browser)
                                "{{ $browser->browser }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: 'المتصفحات',
                            data: [
                                @foreach ($data['top_browsers'] as $browser)
                                    "{{ $browser->count }}",
                                @endforeach
                            ],

                            backgroundColor: {!! json_encode($flat_colors) !!},
                            borderColor: [
                                'transparent',
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                const ChartOperatingSystems = new Chart(document.getElementById('ChartOperatingSystems'), {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @foreach ($data['top_operating_systems'] as $os)
                                "{{ $os->operating_system }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: 'أنظمة التشغيل',
                            data: [
                                @foreach ($data['top_operating_systems'] as $os)
                                    "{{ $os->count }}",
                                @endforeach
                            ],

                            backgroundColor: {!! json_encode($flat_colors) !!},
                            borderColor: [
                                'transparent',
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                const ChartDevices = new Chart(document.getElementById('ChartDevices'), {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @foreach ($data['top_devices'] as $device)
                                "{{ $device->device }}",
                            @endforeach
                        ],
                        datasets: [{
                            label: 'المتصفحات',
                            data: [
                                @foreach ($data['top_devices'] as $device)
                                    "{{ $device->count }}",
                                @endforeach
                            ],

                            backgroundColor: {!! json_encode($flat_colors) !!},
                            borderColor: [
                                'transparent',
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endcan
    @endsection
</div>
