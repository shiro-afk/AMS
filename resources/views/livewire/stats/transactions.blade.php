
<div>
    <div class="flex flex-wrap px-2 py-3">
        @can('show_total_stats')
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="blue" counter="{{ $categoriesCount }}" title="{{ __('Total Categories') }}"
                    href="{{ route('product-categories.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="orange" counter="{{ $productCount }}" title="{{ __('Total Items') }}"
                    href="{{ route('products') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="red" counter="{{ $brandCount }}" title="{{ __('Total Schools') }}"
                    href="{{ route('brands.index') }}">
                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="green" counter="{{ $userCount }}" title="{{ __('Total User') }}"
                    href="{{ route('users.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
        @endcan
    </div>



    @pushOnce('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endPushOnce

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                var dailyChart = new ApexCharts(document.querySelector("#daily-chart"), @json($this->dailyChartOptions));
                dailyChart.render();
            });
        </script>
        <script>
            var monthlyChart = new ApexCharts(document.querySelector("#monthly-chart"), @json($this->monthlyChartOptions));
            monthlyChart.render();
        </script>
        <script>
            function chart(data, selector) {
                let tes = data;
                let options = {
                    series: [{
                            name: "Sales Total Amount",
                            data: tes.total.sales
                        },
                        {
                            name: "Sales Due Amount",
                            data: tes.due_amount.sales
                        },
                        {
                            name: "Purchase Total Amount",
                            data: tes.total.purchase
                        },
                        {
                            name: "Purchase Due Amount",
                            data: tes.due_amount.purchase
                        }
                    ],
                    chart: {
                        height: 350,
                        width: '100%',
                        type: "bar",
                        zoom: {
                            enabled: false
                        }
                    },
                    responsive: [{
                        breakpoint: undefined,
                        options: {},
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 4,
                            dataLabels: {
                                position: "top"
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: "12px",
                            colors: ["#fff"],
                        },
                        formatter: function(val, opt) {
                            return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                        },
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ["#fff"]
                    },
                    markers: {
                        size: 5,
                        colors: ["#1a56db"],
                        strokeColor: "#ffffff",
                        strokeWidth: 3
                    },
                    xaxis: {
                        categories: tes.labels,
                        labels: {
                            style: {
                                colors: "#1a56db"
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: "Amount",
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "$" + val;
                            },
                        },
                    },
                    legend: {
                        position: "top",
                        horizontalAlign: "center",
                        offsetX: 40,
                    },
                };
                var chart = new ApexCharts(document.querySelector(selector), options);
                chart.render();
            }
            chart({!! $charts !!}, '#chart');
        </script>
    @endpush

</div>
