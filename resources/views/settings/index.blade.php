@extends('logoinc::master')

@section('page_title', __('logoinc::generic.viewing').' '.__('logoinc::generic.settings'))

@section('css')
    <style>
        .panel-actions .logoinc-trash {
            cursor: pointer;
        }
        .panel-actions .logoinc-trash:hover {
            color: #e94542;
        }
        .settings .panel-actions{
            right:0px;
        }
        .panel hr {
            margin-bottom: 10px;
        }
        .panel {
            padding-bottom: 15px;
        }
        .sort-icons {
            font-size: 21px;
            color: #ccc;
            position: relative;
            cursor: pointer;
        }
        .sort-icons:hover {
            color: #37474F;
        }
        .logoinc-sort-desc {
            margin-right: 10px;
        }
        .logoinc-sort-asc {
            top: 10px;
        }
        .page-title {
            margin-bottom: 0;
        }
        .panel-title code {
            border-radius: 30px;
            padding: 5px 10px;
            font-size: 11px;
            border: 0;
            position: relative;
            top: -2px;
        }
        .modal-open .settings  .select2-container {
            z-index: 9!important;
            width: 100%!important;
        }
        .new-setting {
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }
        .new-setting .panel-title {
            margin: 0 auto;
            display: inline-block;
            color: #999fac;
            font-weight: lighter;
            font-size: 13px;
            background: #fff;
            width: auto;
            height: auto;
            position: relative;
            padding-right: 15px;
        }
        .settings .panel-title{
            padding-left:0px;
            padding-right:0px;
        }
        .new-setting hr {
            margin-bottom: 0;
            position: absolute;
            top: 7px;
            width: 96%;
            margin-left: 2%;
        }
        .new-setting .panel-title i {
            position: relative;
            top: 2px;
        }
        .new-settings-options {
            display: none;
            padding-bottom: 10px;
        }
        .new-settings-options label {
            margin-top: 13px;
        }
        .new-settings-options .alert {
            margin-bottom: 0;
        }
        #toggle_options {
            clear: both;
            float: right;
            font-size: 12px;
            position: relative;
            margin-top: 15px;
            margin-right: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            z-index: 9;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .new-setting-btn {
            margin-right: 15px;
            position: relative;
            margin-bottom: 0;
            top: 5px;
        }
        .new-setting-btn i {
            position: relative;
            top: 2px;
        }
        textarea {
            min-height: 120px;
        }
        textarea.hidden{
            display:none;
        }

        .logoinc .settings .nav-tabs{
            background:none;
            border-bottom:0px;
        }

        .logoinc .settings .nav-tabs .active a{
            border:0px;
        }

        .select2{
            width:100% !important;
            border: 1px solid #f1f1f1;
            border-radius: 3px;
        }

        .logoinc .settings input[type=file]{
            width:100%;
        }

        .settings .select2{
            margin-left:10px;
        }

        .settings .select2-selection{
            height: 32px;
            padding: 2px;
        }

        .logoinc .settings .nav-tabs > li{
            margin-bottom:-1px !important;
        }

        .logoinc .settings .nav-tabs a{
            text-align: center;
            background: #f8f8f8;
            border: 1px solid #f1f1f1;
            position: relative;
            top: -1px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }

        .logoinc .settings .nav-tabs a i{
            display: block;
            font-size: 22px;
        }

        .tab-content{
            background:#ffffff;
            border: 1px solid transparent;
        }

        .tab-content>div{
            padding:10px;
        }

        .settings .no-padding-left-right{
            padding-left:0px;
            padding-right:0px;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover{
            background:#fff !important;
            color:#62a8ea !important;
            border-bottom:1px solid #fff !important;
            top:-1px !important;
        }

        .nav-tabs > li a{
            transition:all 0.3s ease;
        }


        .nav-tabs > li.active > a:focus{
            top:0px !important;
        }

        .logoinc .settings .nav-tabs > li > a:hover{
            background-color:#fff !important;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="logoinc-settings"></i> {{ __('logoinc::generic.settings') }}
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('logoinc::alerts')
        @if(config('logoinc.show_dev_tips'))
        <div class="alert alert-info">
            <strong>{{ __('logoinc::generic.how_to_use') }}:</strong>
            <p>{{ __('logoinc::settings.usage_help') }} <code>setting('group.key')</code></p>
        </div>
        @endif
    </div>

    <div class="page-content settings container-fluid">
        <form action="{{ route('logoinc.settings.update') }}" method="POST" enctype="multipart/form-data">
            {{ method_field("PUT") }}
            {{ csrf_field() }}
            <input type="hidden" name="setting_tab" class="setting_tab" value="{{ $active }}" />
            <div class="panel">

                <div class="page-content settings container-fluid">
                    <ul class="nav nav-tabs">
                        @foreach($settings as $group => $setting)
                            <li @if($group == $active) class="active" @endif>
                                <a data-toggle="tab" href="#{{ \Illuminate\Support\Str::slug($group) }}">{{ $group }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($settings as $group => $group_settings)
                        <div id="{{ \Illuminate\Support\Str::slug($group) }}" class="tab-pane fade in @if($group == $active) active @endif">
                            @foreach($group_settings as $setting)
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ $setting->display_name }} @if(config('logoinc.show_dev_tips'))<code>setting('{{ $setting->key }}')</code>@endif
                                </h3>
                                <div class="panel-actions">
                                    <a href="{{ route('logoinc.settings.move_up', $setting->id) }}">
                                        <i class="sort-icons logoinc-sort-asc"></i>
                                    </a>
                                    <a href="{{ route('logoinc.settings.move_down', $setting->id) }}">
                                        <i class="sort-icons logoinc-sort-desc"></i>
                                    </a>
                                    @can('delete', logoinc::model('Setting'))
                                    <i class="logoinc-trash"
                                       data-id="{{ $setting->id }}"
                                       data-display-key="{{ $setting->key }}"
                                       data-display-name="{{ $setting->display_name }}"></i>
                                    @endcan
                                </div>
                            </div>

                            <div class="panel-body no-padding-left-right">
                                <div class="col-md-10 no-padding-left-right">
                                    @if ($setting->type == "text")
                                        <input type="text" class="form-control" name="{{ $setting->key }}" value="{{ $setting->value }}">
                                    @elseif($setting->type == "text_area")
                                        <textarea class="form-control" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</textarea>
                                    @elseif($setting->type == "rich_text_box")
                                        <textarea class="form-control richTextBox" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</textarea>
                                    @elseif($setting->type == "code_editor")
                                        <?php $options = json_decode($setting->details); ?>
                                        <div id="{{ $setting->key }}" data-theme="{{ @$options->theme }}" data-language="{{ @$options->language }}" class="ace_editor min_height_400" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</div>
                                        <textarea name="{{ $setting->key }}" id="{{ $setting->key }}_textarea" class="hidden">{{ $setting->value ?? '' }}</textarea>
                                    @elseif($setting->type == "image" || $setting->type == "file")
                                        @if(isset( $setting->value ) && !empty( $setting->value ) && Storage::disk(config('logoinc.storage.disk'))->exists($setting->value))
                                            <div class="img_settings_container">
                                                <a href="{{ route('logoinc.settings.delete_value', $setting->id) }}" class="logoinc-x delete_value"></a>
                                                <img src="{{ Storage::disk(config('logoinc.storage.disk'))->url($setting->value) }}" style="width:200px; height:auto; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                            </div>
                                            <div class="clearfix"></div>
                                        @elseif($setting->type == "file" && isset( $setting->value ))
                                            @if(json_decode($setting->value) !== null)
                                                @foreach(json_decode($setting->value) as $file)
                                                  <div class="fileType">
                                                    <a class="fileType" target="_blank" href="{{ Storage::disk(config('logoinc.storage.disk'))->url($file->download_link) }}">
                                                      {{ $file->original_name }}
                                                    </a>
                                                    <a href="{{ route('logoinc.settings.delete_value', $setting->id) }}" class="logoinc-x delete_value"></a>
                                                 </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        <input type="file" name="{{ $setting->key }}">
                                    @elseif($setting->type == "select_dropdown")
                                        <?php $options = json_decode($setting->details); ?>
                                        <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                        <select class="form-control" name="{{ $setting->key }}">
                                            <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                            @if(isset($options->options))
                                                @foreach($options->options as $index => $option)
                                                    <option value="{{ $index }}" @if($default == $index && $selected_value === NULL) selected="selected" @endif @if($selected_value == $index) selected="selected" @endif>{{ $option }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    @elseif($setting->type == "radio_btn")
                                        <?php $options = json_decode($setting->details); ?>
                                        <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                        <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                        <ul class="radio">
                                            @if(isset($options->options))
                                                @foreach($options->options as $index => $option)
                                                    <li>
                                                        <input type="radio" id="option-{{ $index }}" name="{{ $setting->key }}"
                                                               value="{{ $index }}" @if($default == $index && $selected_value === NULL) checked @endif @if($selected_value == $index) checked @endif>
                                                        <label for="option-{{ $index }}">{{ $option }}</label>
                                                        <div class="check"></div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    @elseif($setting->type == "checkbox")
                                        <?php $options = json_decode($setting->details); ?>
                                        <?php $checked = (isset($setting->value) && $setting->value == 1) ? true : false; ?>
                                        @if (isset($options->on) && isset($options->off))
                                            <input type="checkbox" name="{{ $setting->key }}" class="toggleswitch" @if($checked) checked @endif data-on="{{ $options->on }}" data-off="{{ $options->off }}">
                                        @else
                                            <input type="checkbox" name="{{ $setting->key }}" @if($checked) checked @endif class="toggleswitch">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-2 no-padding-left-right">
                                    <select class="form-control group_select" name="{{ $setting->key }}_group">
                                        @foreach($groups as $group)
                                        <option value="{{ $group }}" {!! $setting->group == $group ? 'selected' : '' !!}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary pull-right">{{ __('logoinc::settings.save') }}</button>
        </form>

        <div style="clear:both"></div>

        @can('add', logoinc::model('Setting'))
        <div class="panel" style="margin-top:10px;">
            <div class="panel-heading new-setting">
                <hr>
                <h3 class="panel-title"><i class="logoinc-plus"></i> {{ __('logoinc::settings.new') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('logoinc.settings.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="setting_tab" class="setting_tab" value="{{ $active }}" />
                    <div class="col-md-3">
                        <label for="display_name">{{ __('logoinc::generic.name') }}</label>
                        <input type="text" class="form-control" name="display_name" placeholder="{{ __('logoinc::settings.help_name') }}" required="required">
                    </div>
                    <div class="col-md-3">
                        <label for="key">{{ __('logoinc::generic.key') }}</label>
                        <input type="text" class="form-control" name="key" placeholder="{{ __('logoinc::settings.help_key') }}" required="required">
                    </div>
                    <div class="col-md-3">
                        <label for="type">{{ __('logoinc::generic.type') }}</label>
                        <select name="type" class="form-control" required="required">
                            <option value="">{{ __('logoinc::generic.choose_type') }}</option>
                            <option value="text">{{ __('logoinc::form.type_textbox') }}</option>
                            <option value="text_area">{{ __('logoinc::form.type_textarea') }}</option>
                            <option value="rich_text_box">{{ __('logoinc::form.type_richtextbox') }}</option>
                            <option value="code_editor">{{ __('logoinc::form.type_codeeditor') }}</option>
                            <option value="checkbox">{{ __('logoinc::form.type_checkbox') }}</option>
                            <option value="radio_btn">{{ __('logoinc::form.type_radiobutton') }}</option>
                            <option value="select_dropdown">{{ __('logoinc::form.type_selectdropdown') }}</option>
                            <option value="file">{{ __('logoinc::form.type_file') }}</option>
                            <option value="image">{{ __('logoinc::form.type_image') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="group">{{ __('logoinc::settings.group') }}</label>
                        <select class="form-control group_select group_select_new" name="group">
                            @foreach($groups as $group)
                                <option value="{{ $group }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <a id="toggle_options"><i class="logoinc-double-down"></i> {{ mb_strtoupper(__('logoinc::generic.options')) }}</a>
                        <div class="new-settings-options">
                            <label for="options">{{ __('logoinc::generic.options') }}
                                <small>{{ __('logoinc::settings.help_option') }}</small>
                            </label>
                            <div id="options_editor" class="form-control min_height_200" data-language="json"></div>
                            <textarea id="options_textarea" name="details" class="hidden"></textarea>
                            <div id="valid_options" class="alert-success alert" style="display:none">{{ __('logoinc::json.valid') }}</div>
                            <div id="invalid_options" class="alert-danger alert" style="display:none">{{ __('logoinc::json.invalid') }}</div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <button type="submit" class="btn btn-primary pull-right new-setting-btn">
                        <i class="logoinc-plus"></i> {{ __('logoinc::settings.add_new') }}
                    </button>
                    <div style="clear:both"></div>
                </form>
            </div>
        </div>
        @endcan
    </div>

    @can('delete', logoinc::model('Setting'))
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('logoinc::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="logoinc-trash"></i> {!! __('logoinc::settings.delete_question', ['setting' => '<span id="delete_setting_title"></span>']) !!}
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('logoinc::settings.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('logoinc::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endcan

@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#toggle_options').click(function () {
                $('.new-settings-options').toggle();
                if ($('#toggle_options .logoinc-double-down').length) {
                    $('#toggle_options .logoinc-double-down').removeClass('logoinc-double-down').addClass('logoinc-double-up');
                } else {
                    $('#toggle_options .logoinc-double-up').removeClass('logoinc-double-up').addClass('logoinc-double-down');
                }
            });

            @can('delete', logoinc::model('Setting'))
            $('.panel-actions .logoinc-trash').click(function () {
                var display = $(this).data('display-name') + '/' + $(this).data('display-key');

                $('#delete_setting_title').text(display);

                $('#delete_form')[0].action = '{{ route('logoinc.settings.delete', [ 'id' => '__id' ]) }}'.replace('__id', $(this).data('id'));
                $('#delete_modal').modal('show');
            });
            @endcan

            $('.toggleswitch').bootstrapToggle();

            $('[data-toggle="tab"]').click(function() {
                $(".setting_tab").val($(this).html());
            });

            $('.delete_value').click(function(e) {
                e.preventDefault();
                $(this).closest('form').attr('action', $(this).attr('href'));
                $(this).closest('form').submit();
            });
        });
    </script>
    <script type="text/javascript">
    $(".group_select").not('.group_select_new').select2({
        tags: true,
        width: 'resolve'
    });
    $(".group_select_new").select2({
        tags: true,
        width: 'resolve',
        placeholder: '{{ __("logoinc::generic.select_group") }}'
    });
    $(".group_select_new").val('').trigger('change');
    </script>
    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="{{ route('logoinc.upload') }}" target="form_target" method="POST" enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
        {{ csrf_field() }}
        <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
        <input type="hidden" name="type_slug" id="type_slug" value="settings">
    </form>

    <script>
        var options_editor = ace.edit('options_editor');
        options_editor.getSession().setMode("ace/mode/json");

        var options_textarea = document.getElementById('options_textarea');
        options_editor.getSession().on('change', function() {
            console.log(options_editor.getValue());
            options_textarea.value = options_editor.getValue();
        });
    </script>
@stop
