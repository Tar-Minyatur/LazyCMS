/**
 * GRUNT: DOWNLOADFILE
 */
module.exports = function (grunt) {
	'use strict';

	return {
		files: [{
			url: 'https://getcomposer.org/installer',
			dest: '<%= cwd %>',
			name: 'composer_installer.php'
		}]
	};
};