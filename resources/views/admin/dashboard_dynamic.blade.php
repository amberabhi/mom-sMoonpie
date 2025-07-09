@extends('layouts.admin-master')
@section('title')
    Dashbaord
@endsection
@push('css')
    <!-- jquery.vectormap css -->
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Qovex Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-tag-plus-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Total Orders</div>
                        </div>
                    </div>
                    <h4 class="mt-4">{{ $orderOverview['totalOrderCount'] }}</h4>
                    <div class="row">
                        <div class="col-7">
                            <p class="mb-0"><span class="text-success me-2"> 0.28% <i class="mdi mdi-arrow-up"></i>
                                </span></p>
                        </div>
                        <div class="col-5 align-self-center">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 62%"
                                    aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Total Customers</div>

                        </div>
                    </div>
                    <h4 class="mt-4">{{ $totalCustomerCount }}</h4>
                    <div class="row">
                        <div class="col-7">
                            <p class="mb-0"><span class="text-success me-2"> 0.16% <i class="mdi mdi-arrow-up"></i>
                                </span></p>
                        </div>
                        <div class="col-5 align-self-center">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 62%"
                                    aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Sales Report</h4>

                    <div id="dash-line-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-6">
            <div class="card">
                <div class="card-body mb-3">
                    <h4 class="card-title mb-4">Sales Analytics</h4>

                    <div class="row align-items-center mb-3">
                        <div class="col-sm-6">
                            <div id="donut-chart" class="apex-charts"></div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i>
                                                Online
                                            </p>
                                            <h5>$ 2,652</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i class="mdi mdi-circle text-success me-1"></i>
                                                Offline</p>
                                            <h5>$ 2,284</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-3">
                                            <p class="mb-1 text-truncate"><i class="mdi mdi-circle text-warning me-1"></i>
                                                Marketing</p>
                                            <h5>$ 1,753</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Revenue</h4>

                    <div id="dash-column-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Order Overview</h4>

                    <div>
                        <div class="pb-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="mb-0">Pending </p>
                                </div>
                                <div class="col-4">
                                    <div class="text-end">
                                        <div>
                                            <h4 class="mb-0">{{ $orderOverview['pendingOrderCount'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="mb-0">Confirmed </p>
                                </div>
                                <div class="col-4">
                                    <div class="text-end">
                                        <div>
                                            <h4 class="mb-0">{{ $orderOverview['shippedOrderCount'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="mb-0">Shipped </p>
                                </div>
                                <div class="col-4">
                                    <div class="text-end">
                                        <div>
                                            <h4 class="mb-0">{{ $orderOverview['deliveredOrderCount'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="mb-0">Delivered </p>
                                </div>
                                <div class="col-4">
                                    <div class="text-end">
                                        <div>
                                            <h4 class="mb-0">{{ $orderOverview['cancelledOrderCount'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="mb-0">Cancelled </p>
                                </div>
                                <div class="col-4">
                                    <div class="text-end">
                                        <div>
                                            <h4 class="mb-0">{{ $orderOverview['confirmedOrderCount'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Testimonials</h4>
                    <div class="mb-4">
                        {{-- <h5><span class="text-primary">{{$testimonials->count()}}</span> Satisfied clients</h5> --}}
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-quote-left h4 text-primary"></i>
                    </div>
                    <div id="reviewExampleControls" class="carousel slide review-carousel" data-ride="carousel">
                        <div class="carousel-inner">
                            @forelse ($testimonials as $testimonial)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div>
                                        <b>{{$testimonial->title}}</b>
                                        <p>{{ $testimonial->review }}</p>
                                        <div class="d-flex align-items-start mt-4">
                                            <div class="avatar-sm me-3">
                                                <img src="{{ asset('images/testimonial/' . $testimonial->image) }}" alt="Testimonial Image" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-size-16 mt-2">{{ $testimonial->customer_name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <a class="carousel-control-prev" href="#reviewExampleControls" role="button"
                            data-bs-slide="prev">
                            <i class="mdi mdi-chevron-left carousel-control-icon"></i>
                        </a>
                        <a class="carousel-control-next" href="#reviewExampleControls" role="button"
                            data-bs-slide="next">
                            <i class="mdi mdi-chevron-right carousel-control-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    {{-- <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body mb-4">
                    <h4 class="card-title mb-4">Monthly Sales</h4>

                    <div id="scatter-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- end row -->

    <div class="row">
        {{-- <div class="col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-white-50">
                        <h5 class="text-white">{{ $totalCustomerCount }} Customers</h5>
                        <p>Click view more to view all the customers.</p>
                        <div>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-success btn-sm">View more</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-8">
                            <div class="mt-4">
                                <img src="{{ URL::asset('build/images/widget-img.png') }}" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Revenue by location</h4>

                    <div class="row">
                        <div class="col-sm-6">
                            <div id="usa-vectormap" style="height: 230px"></div>
                        </div>

                        <div class="col-sm-5 ms-auto">
                            <div class="mt-4 mt-sm-0">
                                <p>Last month Revenue</p>

                                <div class="d-flex align-items-start py-3">
                                    <div class="flex-1">
                                        <p class="mb-2">California</p>
                                        <h5 class="mb-0">$ 2,256</h5>
                                    </div>
                                    <div class="ms-auto">
                                        2.52 % <i class="mdi mdi-arrow-up text-success ms-1"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start py-3 border-top">
                                    <div class="flex-1">
                                        <p class="mb-2">Nevada</p>
                                        <h5 class="mb-0">$ 1,853</h5>
                                    </div>
                                    <div class="ms-auto">
                                        1.26 % <i class="mdi mdi-arrow-up text-success ms-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- end row -->

    <div class="row">
        {{-- <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Inbox</h4>

                    <ul class="inbox-wid list-unstyled">
                        <li class="inbox-list-item">
                            <a href="#">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 align-self-center">
                                        <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt=""
                                            class="avatar-sm rounded-circle">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Paul</h5>
                                        <p class="text-truncate mb-0">Hey! there I'm available</p>
                                    </div>
                                    <div class="font-size-12 ms-auto">
                                        05 min
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="inbox-list-item">
                            <a href="#">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 align-self-center">
                                        <img src="{{ URL::asset('build/images/users/avatar-4.jpg') }}" alt=""
                                            class="avatar-sm rounded-circle">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Mary</h5>
                                        <p class="text-truncate mb-0">This theme is awesome!</p>
                                    </div>
                                    <div class="font-size-12 ms-auto">
                                        12 min
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="inbox-list-item">
                            <a href="#">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 align-self-center">
                                        <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" alt=""
                                            class="avatar-sm rounded-circle">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Cynthia</h5>
                                        <p class="text-truncate mb-0">Nice to meet you</p>
                                    </div>
                                    <div class="font-size-12 ms-auto">
                                        18 min
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="inbox-list-item">
                            <a href="#">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 align-self-center">
                                        <img src="{{ URL::asset('build/images/users/avatar-6.jpg') }}" alt=""
                                            class="avatar-sm rounded-circle">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Darren</h5>
                                        <p class="text-truncate mb-0">I've finished it! See you so</p>
                                    </div>
                                    <div class="font-size-12 ms-auto">
                                        2hr ago
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="#" class="btn btn-primary btn-sm">Load more</a>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Orders</h4>
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead>
                                <tr>
                                    <th scope="col">Order no.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Billing Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Payment Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestOrders as $order)
                                    @php
                                        $color = match($order->order_status) {
                                            'Cancelled' => 'danger',
                                            'Completed', 'Delivered' => 'success',
                                            'Pending' => 'warning',
                                            default => 'primary',
                                        };
                            
                                        $pcolor = match($order->payment_status) {
                                            'Unpaid' => 'danger',
                                            'Paid' => 'success',
                                            'refunded' => 'warning',
                                            default => 'primary',
                                        };
                            
                                        $orderDate = $order->created_at->format('Y-m-d');
                                    @endphp
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $orderDate }}</td>
                                        <td>{{ $order->firstname }} {{ $order->lastname }}</td>
                                        <td>₹ {{ number_format($order->total_amount, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-soft-{{ $color }} font-size-12">
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-soft-{{ $pcolor }} font-size-12">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@push('script')
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        // line chart
        var options = {
            series: [
            {
                name: {{$monthWiseOrderCount['previousYear']['year']}},
                type: 'line',
                data: {{$monthWiseOrderCount['previousYear']['data']}},
            },
            {
                name: {{$monthWiseOrderCount['currentYear']['year']}},
                type: 'area',
                data: {{$monthWiseOrderCount['currentYear']['data']}},
            }
        ],
        chart: {
            height: 260,
            type: 'line',

            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        colors: ['#45cb85', '#3b5de7'],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'smooth',
            width: '3',
            dashArray: [4, 0], 
        },

        markers: {
            size: 3
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            title: {
                    text: 'Month'
            }
        },

        fill: {
            type:'solid',
            opacity: [1, 0.1],
        },

        legend: {
            position: 'top',
            horizontalAlign: 'right',
        }
        };

        var chart = new ApexCharts(document.querySelector("#dash-line-chart"), options);
        chart.render();
    </script>

    <script>
        // column chart
        var options = {
            series: [
                {
                    name: {{$monthWiseRevenue['previousYear']['year']}},
                    data: {{$monthWiseRevenue['previousYear']['data']}},
                },
                {
                    name: {{$monthWiseRevenue['currentYear']['year']}},
                    data: {{$monthWiseRevenue['currentYear']['data']}},
                }
            ],
            chart: {
                type: 'bar',
                height: 260,
                stacked: true,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            colors: ['#ced6f9', '#3b5de7'],
            fill: {
                opacity: 1
            }   
        };

        var chart = new ApexCharts(document.querySelector("#dash-column-chart"), options);
        chart.render();
    </script>
@endpush
