@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">You can start the tour:</div>

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
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <div class="content">
                            <div>
                                <form action="/tour" method="POST">
                                    <label>Participants quantity:</label><input name="tour['participants_qty']"><br>
                                    <label>Game bank:</label><input name="tour['Participants']">
                                    <div>
                                        <button type="submit">Start the tour</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
