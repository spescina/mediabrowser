<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Media Manager</title>

    <script type="text/javascript">
        ZZ = {
            locale: '{{ Config::get('app.locale') }}',
            config: {
                mediabrowser: {
                    config: {!! Mediabrowser::configToJSON() !!},
                    field: '{{ $field }}',
                    value: '{{ $value }}',
                    allowed: {!! Mediabrowser::allowedExtensionsToJSON($field) !!},
                    labels: {
                        'confirm_delete': '{{ Mediabrowser::lang('confirm_delete') }}'
                    }
                }
            }
        };
    </script>

    @if (Config::get('app.debug'))
        <link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.css">
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('packages/spescina/mediabrowser/dist/mediabrowser.css') }}">
    @else
        <link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
        <link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('packages/spescina/mediabrowser/dist/mediabrowser.min.css') }}">
    @endif

    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}"/>
</head>
<body>
<div class="container">
    <div class="row" id="mediabrowser"></div>
</div>
<div id="bottom-bar">
    <div class="container">
        <div id="progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
        <p class="pull-left">
            <span class="btn btn-primary btn-sm fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>{{ Mediabrowser::lang('upload') }}</span>

                    <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <button id="btn-create-folder" type="button"
                    class="btn btn-default btn-sm">{{ Mediabrowser::lang('create_folder') }}</button>
            <input id="input-folder" class="hidden form-control input-sm" type="text" name="folder"
                   placeholder="{{ Mediabrowser::lang('folder') }}"/>
            <button id="btn-confirm" type="button"
                    class="hidden btn btn-success btn-sm">{{ Mediabrowser::lang('confirm') }}</button>
        </p>
        <p class="pull-right">
            <button id="btn-select" type="button"
                    class="hidden btn btn-primary btn-sm">{{ Mediabrowser::lang('select') }}</button>
            <button id="btn-cancel" type="button"
                    class="btn btn-default btn-sm">{{ Mediabrowser::lang('cancel') }}</button>
        </p>
    </div>
</div>

@if (Config::get('app.debug'))
    <script src="{{ URL::asset('packages/spescina/mediabrowser/dist/mediabrowser.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.js"></script>
@else
    <script src="{{ URL::asset('packages/spescina/mediabrowser/dist/mediabrowser.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
@endif

</body>
</html>
