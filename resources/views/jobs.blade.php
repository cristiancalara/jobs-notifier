@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <nav class="nav nav-pills nav-fill m-4">
                    <a class="nav-item nav-link @if(!$status) active @endif" href="{{ route('jobs') }}">New</a>
                    @foreach ($statuses as $s)
                        <a class="nav-item nav-link @if($status && $s->id == $status->id) active @endif"
                           href="{{ route('jobs', ['key' => $s->key]) }}">
                            {{ $s->label }}
                        </a>
                    @endforeach
                </nav>
                <jobs :status="{{ json_encode($status) }}"></jobs>
            </div>
        </div>
    </div>
@endsection
