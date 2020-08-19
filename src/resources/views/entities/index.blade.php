@extends('vendor/permaxis/crudgenerator/layouts.admin')
@section('javascripts')
    @parent
    <script>
        $( document ).ready(function() {
            $('#delete-selected-items').deleteSelectedItems({
                'url': '{{ route('crudgenerator.entities.destroy_entities') }}',
                'urlRedirect' : '{{ route('crudgenerator.entities.index',[],true) }}',
                'csrf_token' : '{{ csrf_token() }}'
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            inlineFieldUpdate({
                'selector' : '.inline-update-field',
                'fields' : {
                    /*bc*/'name': {
                        'name' : 'name',
                        'type' : 'text',
                    },
                    'enabled': {
                        'name' : 'enabled',
                        'type' : 'select',
                        'values' : {
                            0 : 'No',
                            1 : 'Yes'
                        }
                    },/*ec*/
                },
                '_token' : '{{ csrf_token() }}',
                remoteUrl : "{{ route('crudgenerator.entities.update', ['id' => 1]) }}"

            });
        });
    </script>
@endsection
@section('content')
    <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.entities_list') }}</h1>
    @if (session('deleteAction') && session('deleteAction') == 'success')
        <div class="alert alert-success">
            {{ pxcg_trans('permaxis_crudgenerator::messages.entity_deleted_with_success') }}
        </div>
    @endif
    @if (session('createAction') && session('createAction') == 'success')
        <div class="alert alert-success">
            {{ pxcg_trans('permaxis_crudgenerator::messages.entity_created_with_success') }}
        </div>
    @endif

    @include('crudgenerator::entities.search')

    <h5><strong>{{ $total }} entities</strong></h5>
    @if (count($entities))
        <div class="table-responsive" id="list-items">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th><a href="{{ route('crudgenerator.entities.index', $sorting['id'] ) }}" class="sort-item">Id</a>{!! pxcg_sort_item($sortBy, $sortDir, 'id') !!}</th>
                    {{--bc--}}<th><a href="{{ route('crudgenerator.entities.index', $sorting['name'] )}}" class="sort-item">Name</a>{!! pxcg_sort_item($sortBy, $sortDir, 'name') !!}</th>
                    <th><a href="{{ route('crudgenerator.entities.index', $sorting['enabled'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.enabled') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'enabled') !!}</th>{{--ec--}}
                    <th><a href="{{ route('crudgenerator.entities.index', $sorting['created_at'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.created_at') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'created_at') !!}</th>
                    <th><a href="{{ route('crudgenerator.entities.index', $sorting['updated_at'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.updated_at') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'updated_at') !!}</th>
                    <th>Actions</th>
                    <th>
                        {!! Form::checkbox('selectAllItems',1,null,['id' => 'selectAllItems']) !!}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($entities as $item)
                    <tr data-id="{{ $item->id }}" {{--data-name="{{ $item->name }}--}}">
                        <td><a href="{{ route('crudgenerator.entities.show' , ['id' => $item->id]) }}">{{ $item->id }}</a></td>
                    {{--bc--}}<td class="inline-update-field"{!! pxcg_inline_update_field(route('crudgenerator.entities.update',['id' => $item->id]), $item->id, 'name', $item->name,  $item->name) !!}>{{ $item->name }}</td>
                        <td class="inline-update-field"{!! pxcg_inline_update_field(route('crudgenerator.entities.update',['id' => $item->id]), $item->enabled, 'enabled', $item->enabled,  ($item->enabled)?  'Yes' : 'No', ($item->enabled)?  'Yes' : 'No') !!}>{{ ($item->enabled) ? 'Yes' : 'No' }}</td>{{--ec--}}
                        <td>{{  $item->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{  $item->updated_at->format('d/m/Y H:i:s')  }}</td>
                        <td>
                            <ul class="list list-inline">
                                @if (!isset($layout) || (isset($layout) && $layout=='index'))
                                    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.show' , ['id' => $item->id]) }}">{{ pxcg_trans('permaxis_crudgenerator::messages.show') }}</a></li>
                                    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.edit' , ['id' => $item->id]) }}">{{ pxcg_trans('permaxis_crudgenerator::messages.edit') }}</a></li>
                                    <li class="list-inline-item">
                                        <a href="#" data-toggle="modal" data-target="#myModal-{{ $item->id  }}">{{ pxcg_trans('permaxis_crudgenerator::messages.delete') }}</a>
                                        @include('crudgenerator::entities._modal', array('modal_id' => 'myModal-'. $item->id, 'item_id' => $item->id, 'submit_id' => 'submit-'.$item->id))
                                    </li>
                                @endif
                             </ul>
                        </td>
                        <td>
                            {!! Form::checkbox('selectItem') !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br/>
        </div>
        <div class="row">
            <div class="center-block">
                {{--{{ $entities->links() }}--}}
                {!! $paginator->toHtml() !!}
            </div>
        </div>
    @endif
    <ul class="list list-inline">
        @if (Route::currentRouteName() == 'crudgenerator.entities.index' || Route::currentRouteName() == 'crudgenerator::crudgenerator.entities.search' )
            <li class="list-inline-item">
                <div class="form-group">
                    <a href="{{ route('crudgenerator.entities.create') }}" class="btn btn-primary" >{{ pxcg_trans('permaxis_crudgenerator::messages.create_entity') }}</a>
                </div>
            </li>
            @if (count($entities))
                <li class="list-inline-item">
                    <div class="form-group">
                        <a href="#" data-toggle="modal"  data-target="#modal-delete-selected-items" class="btn btn-default btn-secondary" >{{ pxcg_trans('permaxis_crudgenerator::messages.delete_entity') }}</a>
                    </div>
                </li>
            @endif
        @endif
    </ul>

    @include('crudgenerator::entities._modal', array('modal_id' => 'modal-delete-selected-items', 'submit_id' => 'delete-selected-items'))

@endsection
