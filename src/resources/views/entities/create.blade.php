@extends('crudgenerator::layouts.admin')
@section('content')
    <h1>{{ __('permaxis_crudgenerator::messages.create_entity') }}</h1>
    @if (session('createAction') && session('createAction') == 'failed')
        <div class="alert alert-danger">
            {{ __('permaxis_crudgenerator::messages.entity_not_created') }}
        </div>
    @endif
    @if (session('createAction') && session('createAction') == 'success')
        <div class="alert alert-success">
            {{ __('permaxis_crudgenerator::messages.entity_created_with_success') }}
        </div>
    @endif
    {!! Form::Open(array('url' => route('crudgenerator.entities.store'),'method' => 'post', 'files' => true)) !!}

        @include('crudgenerator::entities.form')

    {!! Form::close() !!}

    @if (isset($errors) && count($errors))
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($entity) && $entity->errors() != null  && count($entity->errors()))
        <div class="alert alert-danger">
            <ul>
                @foreach($entity->errors()->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


@endsection