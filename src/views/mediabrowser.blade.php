<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
        <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <title>Media Manager</title>
                
                <script type="text/javascript">
                        ZZ = {
                                locale: '{{ Config::get('app.locale') }}',
                                config: {
                                        mediabrowser : {
                                                config: {{ Mediabrowser::configToJSON() }},
                                                field: '{{ $field }}',
                                                value: '{{ $value }}',
                                                allowed: {{ Mediabrowser::jsonAllowedExtensions($field) }}
                                        }
                                }
                        };
                </script>

                {{ Asset::container('header')->styles() }}
                {{ Asset::container('header')->scripts() }}

                <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        </head>
        <body>
                <!--[if lte IE 8]>
                    <p class="browsehappy">Stai utilizzando un browser <strong>vecchio</strong>. Ti consigliamo di effettuarne <a href="http://browsehappy.com/">l'aggiornamento</a> per migliorare la tua esperienza di navigazione.</p>
                <![endif]-->

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
                                                <span>{{ Mediabrowser::localize('upload') }}</span>

                                                <input id="fileupload" type="file" name="files[]" multiple>
                                        </span>
                                        <button id="btn-create-folder" type="button" class="btn btn-default btn-sm">{{ Mediabrowser::localize('create_folder') }}</button>
                                        <input id="input-folder" class="hidden form-control input-sm" type="text" name="folder" placeholder="{{ Mediabrowser::localize('folder') }}" />
                                        <button id="btn-confirm" type="button" class="hidden btn btn-success btn-sm">{{ Mediabrowser::localize('confirm') }}</button>
                                </p>
                                <p class="pull-right">
                                        <button id="btn-select" type="button" class="hidden btn btn-primary btn-sm">{{ Mediabrowser::localize('select') }}</button>
                                        <button id="btn-cancel" type="button" class="btn btn-default btn-sm">{{ Mediabrowser::localize('cancel') }}</button>
                                </p>
                        </div>
                </div>

                {{ Asset::container('footer')->styles() }}
                {{ Asset::container('footer')->scripts() }}

        </body>
</html>
