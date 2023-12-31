@extends('layouts.admin')

@section('heading')
    <h1 class="m-0 text-dark">
        {{ __('Questions') }}
        <a href="{{ route('questionnaire.question.create', ['questionnaire' => $questionnaire]) }}" class="btn btn-success btn-lg">{{ __('Add Question') }}</a>
    </h1>
@endsection

@section('content')
    <div class="card-header">
        <h3 class="card-title">{{ __('List of Questions') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>{{ __('Pair') }}</th>
                <th>{{ __('Title') }}</th>
            </tr>
            @forelse($questions as $question)
                <tr>
                    <td>
                        <div>{{ $question->pair->getPairTitle() }}</div>
                        <div>
                            <span>{{ $question->typeIndicator1->title_fa }} ({{ $question->typeIndicator1->symbol }})</span><br>
                            <span>{{ $question->typeIndicator2->title_fa }} ({{ $question->typeIndicator2->symbol }})</span>
                        </div>
                    </td>
                    <td>
                        <div><a href="{{ route('questionnaire.question.edit', ['questionnaire' => $questionnaire, 'question' => $question]) }}">{{ $question->title }}</a></div>
                        <div>
                            <span>[ {{ $question->point_first }} ] {{ $question->option_first }}</span><br>
                            <span>[ {{ $question->point_second }} ] {{ $question->option_second }}</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">{{ __('No questions have been added yet.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
