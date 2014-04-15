[![Build Status](https://travis-ci.org/spescina/mediabrowser.svg?branch=master)](https://travis-ci.org/spescina/mediabrowser?branch=master)
[![Coverage Status](https://coveralls.io/repos/spescina/mediabrowser/badge.png?branch=master)](https://coveralls.io/r/spescina/mediabrowser?branch=master)
# MediaBrowser  

Laravel 4 packages that provide a basic user interface for browsing a server folder, for uploading files and for picking a file

## Install && Usage

Add in `composer.json`  
```
"require": {
    "spescina/mediabrowser": "2.x"
}
```

Run `composer update`  

Add the service provider in the `app/config/app.php` file  
```
"Spescina\Mediabrowser\MediabrowserServiceProvider"
```

Publish the package assets running `php artisan asset:publish spescina/mediabrowser`

Publish the package config running `php artisan config:publish spescina/mediabrowser`

Include package scripts and stylesheets in your template file
```
<link media="all" type="text/css" rel="stylesheet" href="http://pangea.dev/packages/spescina/mediabrowser/src/css/vendor/jquery.fancybox.css">
<link media="all" type="text/css" rel="stylesheet" href="http://pangea.dev/packages/spescina/mediabrowser/src/css/mediabrowser-include.css">
```
```
<script src="http://pangea.dev/packages/spescina/mediabrowser/src/js/vendor/jquery.fancybox.js"></script>
<script src="http://pangea.dev/packages/spescina/mediabrowser/src/js/mediabrowser-include.js"></script>
```

Insert an input field and a button for the lightbox trigger, for example
```
<input type="text" name="yourfield" value="uploads/image.jpg" class="form-control" />
<span class="input-group-btn">
        <a data-fancybox-type="iframe" href="{{ URL::route('mediabrowser', array('yourfield', 'uploads/image.jpg')) }}" class="btn btn-default lightbox" type="button"><span class="glyphicon glyphicon-folder-open"></span></a>
</span>
```

The url of the browser can be generated through the `mediabrowser` named route. It accepts two parameters, field name and optionally the selected value.