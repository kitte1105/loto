@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to Russian Loto</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div>
                    @guest
                        <a href="/client">Get the ticket</a>
                    @else
                        <a href="/server">Start the tour</a>
                        <a href="/statistics">View the statistics</a>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
