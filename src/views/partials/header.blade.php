<link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

@if (Config::get('app.debug'))
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('packages/spescina/mediabrowser/src/vendor/jquery-file-upload/css/jquery.fileupload.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('packages/spescina/mediabrowser/src/css/mediabrowser.css') }}">
@else
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('packages/spescina/mediabrowser/dist/mediabrowser.min.css') }}">
@endif