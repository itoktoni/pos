<x-editor />
<x-jscolor />

<div class="form-group">
    {!! Form::label('name', 'Product Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Slug', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'slug') ? 'has-error' : ''}}">
        {!! Form::text($form.'slug', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Brand', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_brand_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_brand_id', $brand, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_brand_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_category_id', $category, null, ['class'=> 'form-control ', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'SKU', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sku') ? 'has-error' : ''}}">
        {!! Form::text($form.'sku', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sku', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Main Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'image') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'image', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">

    {!! Form::label('name', 'Tag', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has($form.'item_tag_json') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_tag_json[]', $tag, json_decode($model->item_product_item_tag_json), ['class'=> 'form-control ', 'multiple']) }}
        {!! $errors->first($form.'item_tag_json', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<hr>
<div class="form-group">

    {!! Form::label('name', 'Active', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-2 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control ']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Display Frontpage', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-2 {{ $errors->has($form.'display') ? 'has-error' : ''}}">
        {{ Form::select($form.'display', ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'display', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Have Variants', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-2 {{ $errors->has($form.'is_variant') ? 'has-error' : ''}}">
        {{ Form::select($form.'is_variant', ['0' => 'No', '1' => 'Yes'], null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'is_variant', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<hr>
<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div
        class="mb-md col-md-{{ isset($model->item_product_image) && !empty($model->item_product_image) ? '8' : '10' }}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control simple', 'id' => '', 'rows' => '5']) !!}
    </div>

    <div class="col-md-2">
        @isset ($model->item_product_image)
        <img width="100%" class="img-thumbnail"
            src="{{ Helper::files($template.'/thumbnail_'.$model->item_product_image) }}" alt="">
        @endisset
    </div>
</div>

<hr>
<div class="form-group">
    {!! Form::label('name', 'Default Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'price') ? 'has-error' : ''}}">
        {!! Form::number($form.'price', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'price', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Price Stroke', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'stroke') ? 'has-error' : ''}}">
        {!! Form::number($form.'stroke', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'stroke', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Weight / Gram', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'weight') ? 'has-error' : ''}}">
        {!! Form::number($form.'weight', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'weight', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Flag Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'flag_name') ? 'has-error' : ''}}">
        {!! Form::text($form.'flag_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'flag_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Flag Color', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'flag_color') ? 'has-error' : ''}}">
        {!! Form::text($form.'flag_color', null, ['class' => 'form-control jscolor']) !!}
        {!! $errors->first($form.'flag_color', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Flag Background', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'flag_background') ? 'has-error' : ''}}">
        {!! Form::text($form.'flag_background', null, ['class' => 'form-control jscolor']) !!}
        {!! $errors->first($form.'flag_background', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingSeo">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeo"
                    aria-expanded="true" aria-controls="collapseSeo">
                    PAGE SEO
                </a>
            </h4>
        </div>
        <div id="collapseSeo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSeo">
            <div class="panel-body">

                <div class="form-group">

                    {!! Form::label('name', 'SEO', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10 mb-md {{ $errors->has($form.'page_seo') ? 'has-error' : ''}}">
                        {!! Form::textarea($form.'page_seo', null, ['class' => 'form-control', 'id' => '',
                        'rows' => '5']) !!}
                        {!! $errors->first($form.'page_seo', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Custom Page 1
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">

                <div class="form-group">
                    {!! Form::label('name', 'Page Name', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_name_1') ? 'has-error' : ''}}">
                        {!! Form::text($form.'page_name_1', null, ['class' => 'form-control']) !!}
                        {!! $errors->first($form.'page_name_1', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::label('name', 'Page Active', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_active_1') ? 'has-error' : ''}}">
                        {{ Form::select($form.'page_active_1', ['0' => 'Not Active', '1' => 'Active'], null, ['class'=> 'form-control']) }}
                        {!! $errors->first($form.'page_active_1', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">

                    {!! Form::label('name', 'Content', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10 {{ $errors->has($form.'page_content_1') ? 'has-error' : ''}}">
                        {!! Form::textarea($form.'page_content_1', null, ['class' => 'form-control editor', 'id' => '',
                        'rows' => '5']) !!}
                        {!! $errors->first($form.'page_content_1', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    Custom Page 2
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('name', 'Page Name', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_name_2') ? 'has-error' : ''}}">
                        {!! Form::text($form.'page_name_2', null, ['class' => 'form-control']) !!}
                        {!! $errors->first($form.'page_name_2', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::label('name', 'Page Active', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_active_2') ? 'has-error' : ''}}">
                        {{ Form::select($form.'page_active_2', ['0' => 'Not Active', '1' => 'Active'], null, ['class'=> 'form-control']) }}
                        {!! $errors->first($form.'page_active_2', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">

                    {!! Form::label('name', 'Content', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10 {{ $errors->has($form.'page_content_2') ? 'has-error' : ''}}">
                        {!! Form::textarea($form.'page_content_2', null, ['class' => 'form-control editor', 'id' => '',
                        'rows' => '5']) !!}
                        {!! $errors->first($form.'page_content_2', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree">
                    Custom Page 3
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('name', 'Page Name', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_name_3') ? 'has-error' : ''}}">
                        {!! Form::text($form.'page_name_3', null, ['class' => 'form-control']) !!}
                        {!! $errors->first($form.'page_name_3', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::label('name', 'Page Active', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($form.'page_active_3') ? 'has-error' : ''}}">
                        {{ Form::select($form.'page_active_3', ['0' => 'Not Active', '1' => 'Active'], null, ['class'=> 'form-control']) }}
                        {!! $errors->first($form.'page_active_3', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">

                    {!! Form::label('name', 'Content', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10 {{ $errors->has($form.'page_content_3') ? 'has-error' : ''}}">
                        {!! Form::textarea($form.'page_content_3', null, ['class' => 'form-control editor', 'id' => '',
                        'rows' => '5']) !!}
                        {!! $errors->first($form.'page_content_3', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>