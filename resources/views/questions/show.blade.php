@extends('layouts.app')

@section('content')
    <question-page v-bind:question="{{ $question }}"></question-page>
@endsection
