@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Contact <span>Us</span></h2>
            <div class="row">
                {!! $page->content !!}
				{{-- <p>
				<center>Call: +91 87797-5441</center><br/><br/>
				<center>Email: support@momsmoonpie.com</center><br/><br/>
				<center>Website: https://www.momsmoonpie.com</center></br><br/>
				</p> --}}
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
