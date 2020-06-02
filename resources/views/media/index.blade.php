@extends('logoinc::master')

@section('page_title', __('logoinc::generic.media'))

@section('content')
    <div class="page-content container-fluid">
        @include('logoinc::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="admin-section-title">
                    <h3><i class="logoinc-images"></i> {{ __('logoinc::generic.media') }}</h3>
                </div>
                <div class="clear"></div>
                <div id="filemanager">
                    <media-manager
                        base-path="{{ config('logoinc.media.path', '/') }}"
                        :show-folders="{{ config('logoinc.media.show_folders', true) ? 'true' : 'false' }}"
                        :allow-upload="{{ config('logoinc.media.allow_upload', true) ? 'true' : 'false' }}"
                        :allow-move="{{ config('logoinc.media.allow_move', true) ? 'true' : 'false' }}"
                        :allow-delete="{{ config('logoinc.media.allow_delete', true) ? 'true' : 'false' }}"
                        :allow-create-folder="{{ config('logoinc.media.allow_create_folder', true) ? 'true' : 'false' }}"
                        :allow-rename="{{ config('logoinc.media.allow_rename', true) ? 'true' : 'false' }}"
                        :allow-crop="{{ config('logoinc.media.allow_crop', true) ? 'true' : 'false' }}"
                        :details="{{ json_encode(['thumbnails' => config('logoinc.media.thumbnails', []), 'watermark' => config('logoinc.media.watermark', (object)[])]) }}"
                        ></media-manager>
                </div>
            </div><!-- .row -->
        </div><!-- .col-md-12 -->
    </div><!-- .page-content container-fluid -->
@stop

@section('javascript')
<script>
new Vue({
    el: '#filemanager'
});
</script>
@endsection
