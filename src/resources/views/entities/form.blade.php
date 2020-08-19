{{--bc--}}<div class="form-group{{ isset($entity) && $entity->errors()->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name','Name:') !!}
    {!! Form::text('name',(isset($entity) ? $entity->name: null),array('class' => (isset($entity) && $entity->errors()->has('name'))? 'form-control is-invalid' : 'form-control')) !!}
    @if (isset($entity) && $entity->errors()->has('name'))
        <span class="help-block invalid-feedback">
            <strong>{{ $entity->errors()->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group">
    {!! Form::label('enabled','Enabled:') !!}
    {!! Form::hidden('enabled',0) !!}
    {!! Form::checkbox('enabled',1, isset($entity)? $entity->enabled : true) !!}
</div>{{--ec--}}

{{--<div class="form-group">
    <a class="btn btn-info" data-toggle="modal" data-target="#modal-list-items" >Select</a>
</div>--}}

<ul class="list list-inline">
    @if (Route::currentRouteName() == 'crudgenerator.entities.edit' || Route::currentRouteName() == 'crudgenerator.entities.update' )
    <li class="list-inline-item">
        <div class="form-group">
            {!! Form::submit('Update Entity',['class' => 'btn btn-primary']) !!}
        </div>
    </li>
    @endif
    @if (Route::currentRouteName() == 'crudgenerator.entities.create' || Route::currentRouteName() == 'crudgenerator.entities.store' )
        <li class="list-inline-item">
            <div class="form-group">
                {!! Form::submit('Create Entity',['class' => 'btn btn-primary']) !!}
            </div>
        </li>
        <li class="list-inline-item">
            <div class="form-group">
                {!! Form::submit('Create and add another',['name' => 'createAndAddAnother','class' => 'btn btn-primary']) !!}
            </div>
        </li>

    @endif
    @if (isset($entity) && $entity->id)
    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.show', ['id' => $entity->id]) }}" class="btn btn-default btn-secondary">Show</a></li>
    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.delete', ['id' => $entity->id]) }}" class="btn btn-default btn-secondary">Delete</a></li>
    @endif
    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.index') }}" class="btn btn-default  btn-light">Back to list</a></li>
</ul>

<div class="modal fade" id="modal-list-items" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ pxcg_trans('permaxis_crudgenerator::messages.select') }}</h4>
            </div>
            <div class="modal-body" id="modal-body-list-items">
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
