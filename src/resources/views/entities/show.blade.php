@extends('vendor/permaxis/crudgenerator/layouts.admin')
@section('content')
    <h1>{{ __('permaxis_crudgenerator::messages.show_entity') }}</h1>

    <table class="table table-bordered">
        <tr><th>Id:</th><td>{{ $entity->id }}</td></tr>
        {{--bc--}}<tr><th>Name:</th><td>{{ $entity->name }}</td></tr>
        <tr><th>{{ __('permaxis_crudgenerator::messages.entity.enabled') }}:</th><td>{{ ($entity->enabled)? 'Yes':'No' }}</td></tr>{{--ec--}}
        <tr><th>{{ __('permaxis_crudgenerator::messages.entity.created_at') }}:</th><td>{{  $entity->created_at->format('d/m/Y H:i:s') }}</td></tr>{{--ec--}}
        <tr><th>{{ __('permaxis_crudgenerator::messages.entity.updated_at') }}:</th><td>{{  $entity->updated_at->format('d/m/Y H:i:s') }}</td></tr>{{--ec--}}
    </table>

    <ul class="list-inline">
        <li><a href="{{ route('crudgenerator.entities.edit', ['id' => $entity->id]) }}" class="btn btn-primary">{{ __('permaxis_crudgenerator::messages.edit') }}</a></li>
        <li><a href="{{ route('crudgenerator.entities.delete', ['id' => $entity->id]) }}" class="btn btn-default">{{ __('permaxis_crudgenerator::messages.delete') }}</a></li>
        <li><a href="{{ route('crudgenerator.entities.index') }}" class="btn btn-default">{{ __('permaxis_crudgenerator::messages.back_to_list') }}</a></li>
        <li></li>
    </ul>
@endsection