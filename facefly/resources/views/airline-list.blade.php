@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
@parent
@endsection

@section('content')

<main>
    <div class="container">
        <section>
            <h2>
                International Airlines
            </h2>
            <article>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label">ID</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Nation</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Airlines</label>
                                    </div>
                                </div>
                                @foreach($nations as $nation)
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div><big class="time"></big></div>
                                        <div><span class="place">{{$nation->nation_id}}</span></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div><big class="time"></big></div>
                                        <div><span class="place">{{$nation->nation_name}}</span></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div><big class="time"></big></div>
                                        @foreach($airlines as $airline)
                                        @if ($nation->nation_id == $airline->airline_nation_id)
                                        <div><span class="place">{{$airline->airline_name}}</span></div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    </div>
</main>

@endsection