<h3>{{ __('permaxis_crudgenerator::messages.search') }}</h3>
<div class="row">
    <div class="col-sm-6">
        {!! Form::Open(array('url' => route('crudgenerator.entities.index'),'method' => 'GET')) !!}
        {{-- csrf_field() --}}
        <div class="form-group">
            {!! Form::label('id','Id:', array('class' => 'small')) !!}
            {!! Form::text('id',(request('id'))? request('id') : null,array('class' => 'form-control')) !!}
        </div>
        {{--bc--}}<div class="form-group">
            {!! Form::label('name','Name:', array('class' => 'small')) !!}
            {!! Form::text('name',(request('name'))? request('name') : null ,array('class' => 'form-control')) !!}
        </div>{{--ec--}}

        <div class="form-group">
            {!! Form::submit(__('permaxis_crudgenerator::messages.search'),['class' => 'btn btn-primary btn-sm','id' => 'search-items']) !!}
        </div>

        @if (isset($errors) && count($errors))
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        {!! Form::close() !!}
    </div>
</div>