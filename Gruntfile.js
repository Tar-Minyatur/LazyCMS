module.exports = function (grunt) {
	'use strict';

	// Loads all grunt tasks in /grunt.
	require('load-grunt-config')(grunt);
	// Displays execution time of each task in Terminal.
	require('time-grunt')(grunt);

	grunt.registerTask('install', [
		'downloadfile',
		'exec:install_composer',
		'composer:build:install',
		'clean:installer'
	]);

	grunt.registerTask('package', [
		'jshint:cms_before_concat',
		'clean:dist_clean',
		'copy:cms',
		'composer:dist:install',
		'concat:dist',
		'jshint:cms_after_concat',
		'uglify:dist',
		'sass:dist',
		'autoprefixer:dist',
		'copy:example',
		'compress:dist'
	]);

	grunt.registerTask('watch', [
		// TODO Implement tasks to watch file changes and to boot up a standalone PHP server
	]);

	grunt.registerTask('default', [
		'jshint:cms_before_concat',
		'concat:build',
		'sass:build',
		'autoprefixer:build'
	]);
};