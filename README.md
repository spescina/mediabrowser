[![Build Status](https://travis-ci.org/spescina/mediabrowser.svg?branch=develop)](https://travis-ci.org/spescina/mediabrowser?branch=develop)
[![Coverage Status](https://coveralls.io/repos/spescina/mediabrowser/badge.png?branch=develop)](https://coveralls.io/r/spescina/mediabrowser?branch=develop)
# MediaBrowser  

Laravel 5.2 package that provide a basic user interface for browsing a server folder, for uploading files and for picking a file

<img alt="MediaBrowser preview" src="https://cloud.githubusercontent.com/assets/1956604/11344541/51e04444-9212-11e5-80c0-c39c15edaa4d.jpg" width="400">

## Install && Usage

Run `composer require spescina/mediabrowser`  

Add the service provider in the `config/app.php` file  
```php
Spescina\Mediabrowser\Providers\MediabrowserServiceProvider::class
```

Publish the package assets running `php artisan vendor:publish`  

Mediabrowser uses **Fancybox** as IFrame popup loader and for this reason requires jQuery. 

Include in your template files Mediabrowser stylesheets
```html
<link media="all" type="text/css" rel="stylesheet" href="http://localhost/packages/spescina/mediabrowser/dist/mediabrowser-include.min.css">
```
and scripts
```html
<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://localhost/packages/spescina/mediabrowser/dist/mediabrowser-include.min.js"></script>
```

Now you have to insert an input field and a button for the fancybox trigger, for example
```html
<input type="text" name="yourfield" value="uploads/image.jpg" class="form-control" />
<span class="input-group-btn">
        <a data-fancybox-type="iframe" href="{{ route('mediabrowser', array('yourfield', 'uploads/image.jpg')) }}" class="btn btn-default mediabrowser-js" type="button"><span class="glyphicon glyphicon-folder-open"></span></a>
</span>
```


## Notes
- The library url can be generated through the `mediabrowser` named route. It accepts two parameters, field name and optionally the selected value.  
- Mediabrowser is configured for loading optimized assets when your laravel application is not in debug mode.
