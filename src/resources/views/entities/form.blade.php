@if (isset($entity) && $entity->id)
<div class="form-group">
    {!! Form::label('id','Id:') !!}
    {!! Form::text('id',(isset($entity) ? $entity->id: null),array('disabled' => 'disabled', 'class' =>  'form-control disabled')) !!}
</div>
@endif
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
    <li class="list-inline-item">
        <a data-toggle="modal" data-target="#myModal-{{ $entity->id  }}" href="#" class="btn btn-default btn-secondary">
            Delete
        </a>
    </li>
    @endif
    <li class="list-inline-item"><a href="{{ route('crudgenerator.entities.index') }}" class="btn btn-default  btn-light">Back to list</a></li>
</ul>

