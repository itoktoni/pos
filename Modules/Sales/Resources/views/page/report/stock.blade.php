@extends(Helper::setExtendBackend())
@component('components.date', ['array' => ['date']])
@endcomponent
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">Report Stock</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">

                    <!-- <div class="form-group">

                        <label class="col-md-2 control-label">Dari Tanggal</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="from" value="{{ old('from') ?? date('Y-m-d') }}" class="date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <label class="col-md-2 control-label">Ke Tanggal</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="to" value="{{ old('to') ??  Carbon\Carbon::tomorrow()->format('Y-m-d') }}" class="date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                    </div> -->

                    <div class="form-group">

                        {!! Form::label('name', 'Branch', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('branch') ? 'has-error' : ''}}">
                            {{ Form::select('branch', $branch, old('branch') ?? null, ['class'=> 'form-control']) }}
                            {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
                        </div>
                       

                        {!! Form::label('name', 'Product', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('product') ? 'has-error' : ''}}">
                            {{ Form::select('product', $product, old('product') ?? null, ['class'=> 'form-control']) }}
                            {!! $errors->first('product', '<p class="help-block">:message</p>') !!}
                        </div>
                       
                    </div>

                </div>
            </div>

            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <button type="submit" value="export" name="action" class="btn btn-success">Export</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection