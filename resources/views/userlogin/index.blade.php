@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Dashboard')

@section('contents')


<section class="content">
    @foreach($events as $event)
        @if($event->availability === 'Open')
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12">
                                <img src="{{ asset('images/' . $event->image_path) }}" class="product-image" alt="Event Image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">{{ $event->session_type }}</h3>
                            <h5>{{ $event->event_date }}</h5>
                            <p>{{ $event->description }}</p>

                            <div class="mt-4">
                                <a href="#" class="btn btn-warning btn-sm btn-flat">
                                    <i class="fas fa-arrow-right fa-sm mr-2"></i> Ikuti Tes
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</section>

@endsection