{{--bc--}}<div class="form-group{{ isset($entity) && $entity->errors()->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name','Name:') !!}
    {!! Form::text('name',(isset($entity) ? $entity->name: null),array('class' => 'form-control')) !!}
    @if (isset($entity) && $entity->errors()->has('name'))
        <span class="help-block">
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
    @if (Route::currentRouteName() == 'crudgenerator.bs3.entities.edit' || Route::currentRouteName() == 'crudgenerator.bs3.entities.update' )
    <li>
        <div class="form-group">
            {!! Form::submit('Update Entity',['class' => 'btn btn-primary']) !!}
        </div>
    </li>
    @endif
    @if (Route::currentRouteName() == 'crudgenerator.bs3.entities.create' || Route::currentRouteName() == 'crudgenerator.bs3.entities.store' )
        <li>
            <div class="form-group">
                {!! Form::submit('Create Entity',['class' => 'btn btn-primary']) !!}
            </div>
        </li>
        <li>
            <div class="form-group">
                {!! Form::submit('Create and add another',['name' => 'createAndAddAnother','class' => 'btn btn-primary']) !!}
            </div>
        </li>

    @endif
    @if (isset($entity) && $entity->id)
    <li><a href="{{ route('crudgenerator.bs3.entities.show', ['id' => $entity->id]) }}" class="btn btn-default">Show</a></li>
    <li><a href="{{ route('crudgenerator.bs3.entities.delete', ['id' => $entity->id]) }}" class="btn btn-default">Delete</a></li>
    @endif
    <li><a href="{{ route('crudgenerator.bs3.entities.index') }}" class="btn btn-default">Back to list</a></li>
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
