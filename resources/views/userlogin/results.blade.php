@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Hasil Psikotes')

@section('contents')
    <section class="content">
        <div class="card card-solid">
            <div class="card-body">
                <h3 class="text-center mb-4 font-weight-bold text-warning">Hasil Psikotes</h3>

                @foreach ($categories as $category)
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            {{ $category->name_category }}
                        </div>
                        <div class="card-body">
                            @php
                                $categoryPoint = $categoryPoints->where('id_category', $category->id_category)->first();
                                $classifications = $category->classifications;
                            @endphp

                            @if ($categoryPoint)
                                <p>Total Points: {{ $categoryPoint->total_points }}</p>
                                <p>Classifications:</p>
                                <ul>
                                    @foreach ($classifications as $classification)
                                        <li>{{ $classification->title }} - {{ $classification->description }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>{{ __('No data available yet') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    <a href="{{ route('userlogin') }}" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </section>
@endsection
