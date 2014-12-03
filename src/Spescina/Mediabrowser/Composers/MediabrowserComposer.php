<?php namespace Spescina\Mediabrowser\Composers;

use Illuminate\Support\Facades\App;
use Teepluss\Asset\Facades\Asset;

class MediabrowserComposer {

        public function compose($view)
        {
                $this->setupAssets();
        }

        /**
         * Load application assets
         */
        private function setupAssets()
        {
                switch (App::environment()) {
                        default:
                                Asset::container('header')->add('bootstrap-css', 'packages/spescina/mediabrowser/src/css/vendor/bootstrap.css');
                                Asset::container('header')->add('fontawesome-css', 'packages/spescina/mediabrowser/src/css/vendor/font-awesome.css');
                                Asset::container('header')->add('uploader-css', 'packages/spescina/mediabrowser/src/css/vendor/jquery.fileupload.css');
                                Asset::container('header')->add('mediabrowser-css', 'packages/spescina/mediabrowser/src/css/mediabrowser.css');

                                Asset::container('footer')->add('jquery', 'packages/spescina/mediabrowser/src/js/vendor/jquery.js');
                                Asset::container('footer')->add('bootstrap-js', 'packages/spescina/mediabrowser/src/js/vendor/bootstrap.js', array('jquery'));
                                Asset::container('footer')->add('handlebars-js', 'packages/spescina/mediabrowser/src/js/vendor/handlebars.js', array('jquery'));
                                Asset::container('footer')->add('jquery-ui-widget', 'packages/spescina/mediabrowser/src/js/vendor/jquery.ui.widget.js', array('jquery'));
                                Asset::container('footer')->add('jquery-truncate', 'packages/spescina/mediabrowser/src/js/vendor/jquery.truncate.js', array('jquery'));
                                Asset::container('footer')->add('jquery-blockui', 'packages/spescina/mediabrowser/src/js/vendor/jquery.blockUI.js', array('jquery'));
                                Asset::container('footer')->add('uploader-transport-js', 'packages/spescina/mediabrowser/src/js/vendor/jquery.iframe-transport.js', array('jquery'));
                                Asset::container('footer')->add('uploader-process-js', 'packages/spescina/mediabrowser/src/js/vendor/jquery.fileupload-process.js', array('jquery', 'uploader-js'));
                                Asset::container('footer')->add('uploader-validation-js', 'packages/spescina/mediabrowser/src/js/vendor/jquery.fileupload-validate.js', array('jquery', 'uploader-js'));
                                Asset::container('footer')->add('uploader-js', 'packages/spescina/mediabrowser/src/js/vendor/jquery.fileupload.js', array('jquery', 'jquery-ui-widget', 'uploader-transport-js'));

                                Asset::container('footer')->add('ajax-js', 'packages/spescina/mediabrowser/src/js/ajax.js', array('jquery'));
                                Asset::container('footer')->add('mediabrowser-js', 'packages/spescina/mediabrowser/src/js/mediabrowser.js', array('jquery', 'ajax-js', 'bootstrap-js', 'handlebars-js'));
                                break;
                }
        }

}
