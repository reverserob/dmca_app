@extends('app')

@section('content')

    <h1 class="page-heading">Prepare a DMCA Notice</h1>

    {!! Form::open(['action' => 'NoticesController@store']) !!}

    <!-- Form input -->

    <div class="form-group">


        {!! Form::textarea('template', $template, ['class' => 'form-control'])  !!}
    </div>

    <div class="form-group">

        {!! Form::submit('Deliver DMCA Notice Now', ['class' => 'bnt bnt-primary form-control'])  !!}
    </div>

    {!! Form::close() !!}

@endsection