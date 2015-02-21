/**
 * GRUNT: WATCH
 */

module.exports = {
	css: {
		files: [
			'src/assets/**/*.scss'
		],
		tasks: ['sass:build', 'autoprefixer:build']
	},
	js: {
		files: 'src/assets/**/*.js',
		tasks: ['jshint:cms_before_concat', 'concat:build']
	}
};