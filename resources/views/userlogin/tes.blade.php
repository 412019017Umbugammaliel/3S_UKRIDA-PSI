@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - PSIKOTES')

@section('contents')

    <section class="content">
        <div class="card card-solid">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @foreach ($questionsWithAnswers as $index => $question)
                    {{-- @dd($question) --}}
                    <div class="row">
                        {{-- bikin slider --}}
                        <div class="col-12 col-sm-6">
                            <img src="{{ asset('images/' . $question->category->image_category) }}"
                                class="img-fluid category-image" alt="Category Image">
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="mt-3 mb-4 text-center text-sm-left font-weight-bold text-warning">
                                {{ $question->category->name_category }}
                            </h3>
                            <p>{!! $question->questions !!}</p>

                            <form
                                action="{{ route('process_answer', ['currentQuestionIndex' => $index, 'currentQuestion' => $question]) }}"
                                method="post">
                                @csrf
                                <div class="form-group">

                                    <p class="font-italic mb-1" style="color: red;">Sangat Tidak Suka</p>
                                    @foreach ($point as $answerIndex => $answer)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selected_answer"
                                                id="answer{{ $answerIndex }}" value="{{ $answerIndex + 1 }}" required>
                                            <label class="form-check-label" for="answer{{ $answerIndex }}">
                                                {!! $answer->namapoin !!}
                                            </label>
                                        </div>
                                    @endforeach
                                    <p class="font-italic mb-1" style="color: red;">Sangat Suka</p>
                                </div>

                                <div class="mt-3">
                                    <input type="hidden" name="id_category" value="{{ $question->category->id }}">
                                    <input type="hidden" name="id_question" value="{{ $question->id }}">

                                    <button type="submit" name="action" value="previous" class="btn btn-primary"
                                        {{ $index === 0 ? 'disabled' : '' }}>Previous</button>
                                    <button type="submit" name="action" value="next" class="btn btn-primary ml-2"
                                        {{ $index === count($questionsWithAnswers) - 1 ? 'disabled' : '' }}>Next</button>
                                </div>
                            </form>
                        </div>
                        {{-- end slider --}}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
