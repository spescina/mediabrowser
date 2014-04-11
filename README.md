# MediaBrowser  

Laravel 4 packages that provide a basic user interface for browsing a server folder, for uploading files and for picking a file

## Install  

Add in `composer.json`  
```
"require": {
    "spescina/mediabrowser": "1.0.*"
}
```

Run `composer update`  

Add the service provider in the `app/config/app.php` file  
```
"Spescina\Mediabrowser\MediabrowserServiceProvider"
```

Publish the package assets running `php artisan asset:publish spescina/mediabrowser`

Publish the package config running `php artisan config:publish spescina/mediabrowser`

## Usage

Needs rework in order to be independent from other packages
