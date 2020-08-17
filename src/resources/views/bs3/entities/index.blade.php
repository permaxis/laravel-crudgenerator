@extends('vendor/permaxis/crudgenerator/layouts.admin')
@section('javascripts')
    @parent
    <script>
        $( document ).ready(function() {
            $('#delete-selected-items').deleteSelectedItems({
                'url': '{{ route('crudgenerator.bs3.entities.destroy_entities') }}',
                'urlRedirect' : '{{ route('crudgenerator.bs3.entities.index',[],true) }}',
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
                remoteUrl : "{{ route('crudgenerator.bs3.entities.update', ['id' => 1]) }}"

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
            <table class="table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th><a href="{{ route('crudgenerator.bs3.entities.index', $sorting['id'] ) }}" class="sort-item">Id</a>{!! pxcg_sort_item($sortBy, $sortDir, 'id') !!}</th>
                    {{--bc--}}<th><a href="{{ route('crudgenerator.bs3.entities.index', $sorting['name'] )}}" class="sort-item">Name</a>{!! pxcg_sort_item($sortBy, $sortDir, 'name') !!}</th>
                    <th><a href="{{ route('crudgenerator.bs3.entities.index', $sorting['enabled'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.enabled') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'enabled') !!}</th>{{--ec--}}
                    <th><a href="{{ route('crudgenerator.bs3.entities.index', $sorting['created_at'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.created_at') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'created_at') !!}</th>
                    <th><a href="{{ route('crudgenerator.bs3.entities.index', $sorting['updated_at'] )}}" class="sort-item">{{ pxcg_trans('permaxis_crudgenerator::messages.entity.updated_at') }}</a>{!! pxcg_sort_item($sortBy, $sortDir, 'updated_at') !!}</th>
                    <th>Actions</th>
                    <th>
                        {!! Form::checkbox('selectAllItems',1,null,['id' => 'selectAllItems']) !!}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($entities as $item)
                    <tr data-id="{{ $item->id }}" {{--data-name="{{ $item->name }}--}}">
                        <td><a href="{{ route('crudgenerator.bs3.entities.show' , ['id' => $item->id]) }}">{{ $item->id }}</a></td>
                    {{--bc--}}<td class="inline-update-field"{!! pxcg_inline_update_field(route('crudgenerator.bs3.entities.update',['id' => $item->id]), $item->id, 'name', $item->name,  $item->name) !!}>{{ $item->name }}</td>
                        <td class="inline-update-field"{!! pxcg_inline_update_field(route('crudgenerator.bs3.entities.update',['id' => $item->id]), $item->enabled, 'enabled', $item->enabled,  ($item->enabled)?  'Yes' : 'No', ($item->enabled)?  'Yes' : 'No') !!}>{{ ($item->enabled) ? 'Yes' : 'No' }}</td>{{--ec--}}
                        <td>{{  $item->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{  $item->updated_at->format('d/m/Y H:i:s')  }}</td>
                        <td>
                            <ul class="list list-inline">
                                @if (!isset($layout) || (isset($layout) && $layout=='index'))
                                    <li><a href="{{ route('crudgenerator.bs3.entities.show' , ['id' => $item->id]) }}">{{ pxcg_trans('permaxis_crudgenerator::messages.show') }}</a></li>
                                    <li><a href="{{ route('crudgenerator.bs3.entities.edit' , ['id' => $item->id]) }}">{{ pxcg_trans('permaxis_crudgenerator::messages.edit') }}</a></li>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#myModal-{{ $item->id }}">{{ pxcg_trans('permaxis_crudgenerator::messages.delete') }}</a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal-{{ $item->id }}" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    {!! Form::Open(array('url' => route('crudgenerator.bs3.entities.destroy',['id' => $item->id]),'method' => 'DELETE')) !!}
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">{{ pxcg_trans('permaxis_crudgenerator::messages.alert_suppression') }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.confirm_delete_item') }} {{--{{ $item->name }} --}}</h1>
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ pxcg_trans('permaxis_crudgenerator::messages.cancel') }}</button>
                                                        {!! Form::submit(pxcg_trans('permaxis_crudgenerator::messages.confirm'),['class' => 'btn btn-primary']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>

                                            </div>
                                        </div>

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
        @if (Route::currentRouteName() == 'crudgenerator.bs3.entities.index' || Route::currentRouteName() == 'crudgenerator::crudgenerator.bs3.entities.search' )
            <li>
                <div class="form-group">
                    <a href="{{ route('crudgenerator.bs3.entities.create') }}" class="btn btn-primary" >{{ pxcg_trans('permaxis_crudgenerator::messages.create_entity') }}</a>
                </div>
            </li>
            @if (count($entities))
                <li>
                    <div class="form-group">
                        <a href="#" data-toggle="modal"  data-target="#modal-delete-selected-items" class="btn btn-primary" >{{ pxcg_trans('permaxis_crudgenerator::messages.delete_entity') }}</a>
                    </div>
                </li>
            @endif
        @endif
    </ul>

    <div class="modal fade" id="modal-delete-selected-items" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ pxcg_trans('permaxis_crudgenerator::messages.alert_suppression') }}</h4>
                </div>
                <div class="modal-body">
                    <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.confirm_delete_selected_entities') }}</h1>
                    <div class="form-group">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ pxcg_trans('permaxis_crudgenerator::messages.cancel') }}</button>
                    {!! Form::submit(pxcg_trans('permaxis_crudgenerator::messages.confirm'),['id'=>'delete-selected-items', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>

        </div>
    </div>

@endsection
