/**
 * GRUNT: COMPOSER
 */
var path = require('path');

module.exports = function (grunt) {
	'use strict';

	return {
		options: {
			usePhp: true,
			composerLocation: path.resolve() + '/composer.phar'
		},
		build: {
			options: {
				cwd: 'src/',
				flags: ['dev']
			}
		},
		dist: {
			options: {
				cwd: 'dist/',
				flags: ['no-dev']
			}
		}
	};
};