@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - PSIKOTES')

@section('contents')
    <section class="content">
        <div class="card card-solid">
            <div id="carouselExampleControls" class="carousel slide">
                <div class="carousel-inner">
                    @foreach ($questionsWithAnswers as $index => $question)
                        <div class="carousel-item {{ $index === $currentQuestionIndex ? 'active' : '' }}">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <img src="{{ asset('images/' . $question->category->image_category) }}" class="img-fluid category-image" alt="Category Image" style="width: 600px; height: 350px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h3 class="mt-3 mb-4 text-center text-sm-left font-weight-bold text-warning">
                                        {{ $question->category->name_category }}
                                    </h3>
                                    <p>{!! $question->questions !!}</p>

                                    <form action="{{ route('process_answer') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <p class="font-italic mb-1" style="color: red;">Sangat Tidak Suka</p>
                                            
                                            @for ($i = 1; $i <= 6; $i++)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="selected_answer" id="answer{{ $i }}" value="{{ $i }}" required>
                                                    <label class="form-check-label" for="answer{{ $i }}">{{ $i }}</label>
                                                </div>
                                            @endfor
                                            
                                            <p class="font-italic mb-1" style="color: red;">Sangat Suka</p>
                                        </div>
                                        
                                        <div class="mt-3 mb-4">
                                            {{-- Hidden input fields to store necessary data --}}
                                            <input type="hidden" name="id_category" value="{{ $question->category->id }}">
                                            <input type="hidden" name="id_question" value="{{ $question->id }}">
                                            <input type="hidden" name="currentQuestionIndex" value="{{ $currentQuestionIndex }}">
                                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                            
                                            {{-- Previous and Next buttons for navigation --}}
                                            <button type="button" class="btn btn-outline-primary prev-question" data-target="#carouselExampleControls" data-slide-to="{{ $index - 1 }}" {{ $index === 0 ? 'disabled' : '' }}>
                                                <i class="bi bi-arrow-left"></i> Previous
                                            </button>
                                    
                                            @if ($index === count($questionsWithAnswers) - 1)
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            @else
                                                <button type="button" class="btn btn-outline-primary next-question" data-target="#carouselExampleControls" data-slide-to="{{ $index + 1 }}">
                                                    Next <i class="bi bi-arrow-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
