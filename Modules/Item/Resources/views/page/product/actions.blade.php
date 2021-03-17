<div class="action text-center">
    @if (isset($actions['update']))
    <a id="linkMenu" href="{{ route($module.'_update', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-primary">@lang('pages.update')</a>
    @endif

    <a id="linkMenu" href="{{ route($module.'_variant', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-success">Variant
    </a>
</div>