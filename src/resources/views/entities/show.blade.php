@extends('vendor/permaxis/laravel-crudgenerator/layouts.admin')
@section('content')
    <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.show_entity') }}</h1>

    <table class="table table-bordered">
        <tr><th>Id:</th><td>{{ $entity->id }}</td></tr>
        {{--bc--}}<tr><th>Name:</th><td>{{ $entity->name }}</td></tr>
        <tr><th>{{ pxcg_trans('permaxis_crudgenerator::messages.entity.enabled') }}:</th><td>{{ ($entity->enabled)? 'Yes':'No' }}</td></tr>{{--ec--}}
        <tr><th>{{ pxcg_trans('permaxis_crudgenerator::messages.entity.created_at') }}:</th><td>{{  $entity->created_at->format('d/m/Y H:i:s') }}</td></tr>
        <tr><th>{{ pxcg_trans('permaxis_crudgenerator::messages.entity.updated_at') }}:</th><td>{{  $entity->updated_at->format('d/m/Y H:i:s') }}</td></tr>
    </table>

    <ul class="list list-inline">
        <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.edit', ['id' => $entity->id]) }}" class="btn btn-primary">{{ pxcg_trans('permaxis_crudgenerator::messages.edit') }}</a></li>
        <li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#myModal-{{ $entity->id  }}" class="btn btn-default btn-secondary">{{ pxcg_trans('permaxis_crudgenerator::messages.delete') }}</a></li>
        <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.index') }}" class="btn btn-default  btn-light">{{ pxcg_trans('permaxis_crudgenerator::messages.back_to_list') }}</a></li>
        <li></li>
    </ul>

    @if (isset($entity) && $entity->id)
        @include('vendor/permaxis/laravel-crudgenerator/include._modal', array('route' => route('crudgenerator.entities.destroy',['id' => $entity->id]), 'modal_id' => 'myModal-'. $entity->id, 'submit_id' => 'submit-'.$entity->id))
    @endif

@endsection