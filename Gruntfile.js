module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        jshint: {
            files: ['Gruntfile.js', 'public/src/js/*.js'],
            options: {
                globals: {
                    jQuery: true,
                    console: true,
                    module: true
                }
            }
        },
        copy: {
            dev: {
                files: [
                    {
                        expand: true,
                        src: [
                            'bower_components/jquery/dist/jquery.js',
                            'bower_components/bootstrap/dist/js/bootstrap.js',
                            'bower_components/handlebars/handlebars.js',
                            'bower_components/jquery-file-upload/js/jquery.fileupload.js',
                            'bower_components/jquery-file-upload/js/jquery.fileupload-process.js',
                            'bower_components/jquery-file-upload/js/jquery.fileupload-validate.js',
                            'bower_components/jquery-file-upload/js/jquery.iframe-transport.js',
                            'bower_components/jquery-file-upload/js/vendor/jquery.ui.widget.js',
                            'bower_components/jquery-truncate/jquery.truncate.js',
                            'bower_components/blockui/jquery.blockUI.js'
                        ],
                        dest: 'public/src/js/vendor',
                        flatten: true
                    },
                    {
                        expand: true,
                        src: [
                            'bower_components/bootstrap/dist/css/bootstrap.css',
                            'bower_components/font-awesome/css/font-awesome.css',
                            'bower_components/jquery-file-upload/css/jquery.fileupload.css',
                        ],
                        dest: 'public/src/css/vendor',
                        flatten: true
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/bootstrap/dist',
                        src: ['fonts/*'],
                        dest: 'public/src/css'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/font-awesome',
                        src: ['fonts/*'],
                        dest: 'public/src/css'
                    }
                ]
            }
        },
        clean: {
            dev: [
                'public/src/js/vendor',
                'public/src/css/vendor',
                'public/src/img/vendor',
            ]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('dev', ['jshint', 'clean:dev', 'copy:dev']);

    grunt.registerTask('default', ['jshint']);

};