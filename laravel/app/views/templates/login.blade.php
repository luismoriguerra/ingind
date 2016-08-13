@extends('layouts/main')

@section('body')
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-offset-3 col-sm-6 well">
                <h2>Bienvenido al Chat!</h2>
                <hr/>
                {{ Form::open(array('action' => 'AuthController@postLogin')) }}
                    <div class="form-group">
                        {{ Form::label('usuario', 'Usuario', array('class' => 'control-label')) }}
                        {{ Form::text('usuario', null, array( 'class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('password','Password', array('class' => 'control-label')) }}
                        {{ Form::password('password',  array('class' => 'form-control')) }}
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-danger">Iniciar</button>
                    </div>
                {{ Form::close() }}
                @if($errors)
                    <ul class="text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@stop
