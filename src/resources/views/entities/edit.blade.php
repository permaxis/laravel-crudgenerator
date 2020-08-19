@extends('vendor/permaxis/crudgenerator/layouts.admin')
@section('content')

    <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.edit_entity') }}</h1>

    @if (session('updateAction') && session('updateAction') == 'success')
        <div class="alert alert-success">
            {{ pxcg_trans('permaxis_crudgenerator::messages.entity_updated_with_success') }}
        </div>
    @endif
    @if (session('updateAction') && session('updateAction') == 'failed')
        <div class="alert alert-danger">
            {{ pxcg_trans('permaxis_crudgenerator::messages.entity_updated_not_updated') }}
        </div>
    @endif
    {!! Form::Open(array('url' => route('crudgenerator.entities.update',['id' => $entity->id]),'method' => 'put', 'files' => true)) !!}
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