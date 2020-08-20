<div class="modal fade" id="{{ $modal_id }}" role="dialog">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            @if (isset($route))
            {!! Form::Open(array('url' => $route,'method' => 'DELETE')) !!}
            @endif
            <div class="modal-header">
                <h4 class="modal-title">{{ pxcg_trans('permaxis_crudgenerator::messages.alert_suppression') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1>{{ pxcg_trans('permaxis_crudgenerator::messages.confirm_delete_item') }} {{--{{ $item->name }} --}}</h1>
                <div class="form-group">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ pxcg_trans('permaxis_crudgenerator::messages.cancel') }}</button>
                {!! Form::submit(pxcg_trans('permaxis_crudgenerator::messages.confirm'),['id' => $submit_id,'class' => 'btn btn-primary']) !!}
            </div>
            @if (isset($route))
            {!! Form::close() !!}
            @endif
        </div>

    </div>
</div>
