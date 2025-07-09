@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2>Refund Status</h2>
    
            <!-- Display refund response data -->
            <div class="card">
                <div class="card-header">
                    Refund Response Data
                </div>
                <div class="card-body">
                    @if(isset($res_data))
					<pre>
					@php print_r($res_data); die(); @endphp
                        <pre>{{ json_encode($res_data) }}</pre>
                    @else
                        <p>No data received from the refund request.</p>
                    @endif
                </div>
            </div>
    
            <!-- Display status response data -->
            <div class="card mt-3">
                <div class="card-header">
                    Refund Status Check Response
                </div>
                <div class="card-body">
                    @if(isset($res_data_status))
                        <pre>{{ json_encode($res_data_status) }}</pre>
                    @else
                        <p>No status data received from PhonePe.</p>
                    @endif
                </div>
            </div>
    
            <!-- Optionally display success/failure message -->
            <div class="mt-3">
                @if(isset($res_data) && json_decode($res_data)->status == 'SUCCESS')
                    <div class="alert alert-success">
                        <strong>Refund Successful!</strong> Your refund has been processed.
                    </div>
                @elseif(isset($res_data) && json_decode($res_data)->status != 'SUCCESS')
                    <div class="alert alert-danger">
                        <strong>Refund Failed!</strong> Something went wrong with your refund.
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>Waiting for status update...</strong>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
