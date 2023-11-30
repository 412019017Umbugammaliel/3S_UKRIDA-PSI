@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Results')

@section('contents')
    <section class="content">
        <div class="card card-solid">
            <div class="card-body">
                <h2 class="text-center mb-4">Results</h2>

                @if ($categoryPoints)
                    @if ($categoryPoints->isEmpty())
                        <p>No results available.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoryPoints as $categoryPoint)
                                    <tr>
                                        <td>{{ $categoryPoint->category->name_category }}</td>
                                        <td>{{ $categoryPoint->total_points }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @else
                    <p>No results available.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
