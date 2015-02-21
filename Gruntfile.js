module.exports = function(grunt) {

    require('load-grunt-config')(grunt);
    require('time-grunt')(grunt);

    grunt.registerTask('install', [
        'downloadfile',
        'exec:install_composer',
        'composer:build:install',
        'clean:installer']);

    grunt.registerTask('package', [
        'jshint:cms_before_concat',
        'clean:dist_clean',
        'copy:cms',
        'composer:dist:install',
        'concat:dist',
        'jshint:cms_after_concat',
        'uglify:dist',
        'sass:dist',
        'csslint:cms_after_sass',
        'csslint:example',
        'copy:example',
        'compress:dist']);

    grunt.registerTask('watch', [
        // TODO Implement tasks to watch file changes and to boot up a standalone PHP server
        ]);

    grunt.registerTask('default', [
        'jshint:cms_before_concat',
        'concat:build',
        'sass:build',
        'csslint:cms_after_sass',
        'csslint:example']);

};