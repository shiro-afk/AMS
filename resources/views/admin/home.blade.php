@section('title', __('Dashboard'))

@section('breadcrumb')
    <div class="relative bg-indigo-50 p-4 sm:p-6 rounded-sm mb-4">
        <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
            <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                    <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                    <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                    <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                        <stop stop-color="#A5B4FC" offset="0%" />
                        <stop stop-color="#818CF8" offset="100%" />
                    </linearGradient>
                    <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                        <stop stop-color="#4338CA" offset="0%" />
                        <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <g transform="rotate(64 36.592 105.604)">
                        <mask id="welcome-d" fill="#fff">
                            <use xlink:href="#welcome-a" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" />
                    </g>
                    <g transform="rotate(-51 91.324 -105.372)">
                        <mask id="welcome-f" fill="#fff">
                            <use xlink:href="#welcome-e" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" />
                    </g>
                    <g transform="rotate(44 61.546 392.623)">
                        <mask id="welcome-h" fill="#fff">
                            <use xlink:href="#welcome-g" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" />
                    </g>
                </g>
            </svg>
        </div>
        <div class="relative">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold mb-1">{{ __('Hello') }}, {{ Auth::user()->name }} 👋
            </h1>
            <p>{{ 'What are you look for today ?' }}</p>
            <div class="py-5 px-4">
                <livewire:stats.transactions />
            </div>
        </div>
    </div>
@endsection
<x-app-layout>
    <div class="px-2 mx-auto">
        {{-- <livewire:calculator /> --}}

        @can('dashboard_access')


                <div class="mx-auto w-11/12 overflow-hidden md:w-3/5">
@section('content')
<div class="pl-50">
        <div class="">
            <div class="">

                <div class="card">
                    <div class="card-header">
                    @foreach($categories as $category)
                @php
                $cname = $category->name;
                   $ccount = $category->products->count();
                @endphp
            @endforeach
                        <div id="container">

                    </div>
                    <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
</div>

        @endcan

    </div>
</x-app-layout>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categories = @json($categories);

        const chartData = categories.map(category => ({
            name: category.name,
            y: category.products.length // Assuming products is an array
        }));

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Items per Category'
            },
            xAxis: {
                categories: categories.map(category => category.name)
            },
            yAxis: {
                title: {
                    text: 'Items'
                }
            },
            series: [{
                name: 'Items per Category',
                data: chartData
            }],
            legend: {
                enabled: false // Set this to false to hide the legend toggle button
            }
        });
    });
</script>
