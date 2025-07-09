@extends('layouts.front')
@section('style')
<style>
    body {
        color: #000;
        overflow-x: hidden;
        height: 100%;
        background-color: #8C9EFF;
        background-repeat: no-repeat;
    }

    .card {
        z-index: 0;
        background-color: #ECEFF1;
        padding-bottom: 20px;
        margin-top: 90px;
        margin-bottom: 90px;
        border-radius: 10px;
    }

    .top {
        padding-top: 40px;
        padding-left: 13% !important;
        padding-right: 13% !important;
    }

    /*Icon progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: #455A64;
        padding-left: 0px;
        margin-top: 30px;
    } 

    #progressbar li {
        list-style-type: none;
        font-size: 13px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400;
    }

    #progressbar .step0:before {
        font-family: FontAwesome;
        content: "\f10c";
        color: #fff;
    }

    #progressbar li:before {
        width: 40px;
        height: 40px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        background: #C5CAE9;
        border-radius: 50%;
        margin: auto;
        padding: 0px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 12px;
        background: #C5CAE9;
        position: absolute;
        left: 0;
        top: 16px;
        z-index: -1;
    }

    #progressbar li:last-child:after {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        position: absolute;
        left: -50%;
    }

    #progressbar li:nth-child(2):after, #progressbar li:nth-child(3):after {
        /* left: -50%; */
    }

    #progressbar li:first-child:after {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        position: absolute;
        left: 50%;
    }

    #progressbar li:last-child:after {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #progressbar li:first-child:after {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: #651FFF;
    }

    #progressbar li.active:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    .icon {
        width: 60px;
        height: 60px;
        margin-right: 15px;
    }

    .icon-content { 
        padding-bottom: 20px;
    }

    @media screen and (max-width: 992px) {
        .icon-content {
            width: 50%;
        }
    }
</style>
@endsection
@section('content')
   
    <section>
        <div class="container px-1 px-md-4 py-5 mx-auto">
            <div class="card">
                <div class="row d-flex justify-content-between px-3 top _d-none">
                    <div class="d-flex">
                        <h5>ORDER <span class="text-primary font-weight-bold">#{{ $trackingDetails->order_id }}</span></h5>
                    </div>
                    <div class="d-flex flex-column text-sm-right">
                        {{-- <p class="mb-0">Expected Arrival <span>01/12/19</span></p> --}}
                        <p>Status: <span class="font-weight-bold"><b>{{ $trackingDetails->status }}</b></span></p>
                        <p>AWB <span class="font-weight-bold">{{ $trackingDetails->awb }}</span></p>
                    </div>
                </div>
                @php
                    $scans = !empty($trackingDetails->scan_details) ? json_decode($trackingDetails->scan_details,true) : [];
                    // if(!empty($scans)){
                    //     $scans = array_reverse($scans);
                    // }
                @endphp
                <!-- Add class 'active' to progress -->
                {{-- <div class="row d-flex justify-content-center">
                    <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        @foreach ($scans as $scan)
                            <li class="active step0"></li>
                        @endforeach
                    </ul>
                    </div>
                </div> --}}
                <hr>
                <div class="row justify-content-between top">
                    @foreach ($scans as $scan)
                        <div class="row d-flex icon-content">
                            {{-- <img class="icon" src="https://i.imgur.com/9nnc9Et.png"> --}}
                            <div class="d-flex flex-column">
                                <p class="font-weight-bold">{{ $scan['date'] }}<br><b>{{ $scan['activity'] }}</b><br><i>{{ $scan['location'] }}</i></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
    <script>
        var updateCartUrl = "{{ route('front.cart.update') }}";
    </script>
@endsection
