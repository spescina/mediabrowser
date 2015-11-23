@if (Config::get('app.debug'))
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery/dist/jquery.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/handlebars/handlebars.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-truncate/jquery.truncate.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/blockui/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/js/ajax.js') }}"></script>
    <script src="{{ asset('packages/spescina/mediabrowser/src/js/mediabrowser.js') }}"></script>
@else
    <script src="{{ asset('packages/spescina/mediabrowser/dist/mediabrowser.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
@endif