@extends('layouts.app')
@section('style')
    <style>
        td {
            border: 1px solid black;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your ticket</div>
            </div>
        </div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div>
                    <table>
                    @foreach($blank as $str)
                        <tr>
                        @foreach($str as $col)
                                <td>{{ $col }}</td>
                        @endforeach
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
