@extends('crudgenerator::layouts.admin')
@section('content')
    <h1>{{ __('permaxis_crudgenerator::messages.confirm_delete_item') }} : {{ $entity->name }}</h1>
    {!! Form::Open(array('url' => route('crudgenerator.entities.destroy',['id' => $entity->id]),'method' => 'DELETE')) !!}
            <div class="form-group">
                {!! Form::submit('DELETE',['class' => 'btn btn-primary']) !!}
            </div>
    {!! Form::close() !!}
@endsection