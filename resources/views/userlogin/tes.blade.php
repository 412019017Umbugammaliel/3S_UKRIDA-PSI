@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - PSIKOTES')

@section('contents')

<section class="content">
    <div class="card card-solid">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-sm-6">
                    <img src="{{ asset('images/' . $currentQuestion->category->image_category) }}"
                        class="img-fluid category-image" alt="Category Image">
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="mt-3 mb-4 text-center text-sm-left font-weight-bold text-warning">
                        {{ $currentQuestion->category->name_category }}
                    </h3>
                    <p>{!! $currentQuestion->questions !!}</p>

                    <form
                        action="{{ route('process_answer', ['currentQuestionIndex' => $currentQuestionIndex, 'currentQuestion' => $currentQuestion]) }}"
                        method="post">
                        @csrf
                        <div class="form-group">
                            <p class="font-italic mb-1" style="color: red;">Sangat Tidak Suka</p>
                            @foreach ($answers as $index => $answer)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="selected_answer"
                                        id="answer{{ $index }}" value="{{ $index + 1 }}" required>
                                    <label class="form-check-label" for="answer{{ $index }}">
                                        {!! $answer->point !!}
                                    </label>
                                </div>
                            @endforeach
                            <p class="font-italic mb-1" style="color: red;">Sangat Suka</p>
                        </div>

                        <div class="mt-3">
                            <input type="hidden" name="currentQuestionIndex" value="{{ $currentQuestionIndex }}">
                            <input type="hidden" name="currentQuestion" value="{{ $currentQuestion->id }}">
                            <button type="submit" name="action" value="previous" class="btn btn-primary" {{
                                $currentQuestionIndex===0 ? 'disabled' : '' }}>Previous</button>
                            <button type="submit" name="action" value="next" class="btn btn-primary ml-2" {{
                                $currentQuestionIndex===count($questionsWithAnswers ?? []) - 1 ? 'disabled' : ''
                                }}>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
