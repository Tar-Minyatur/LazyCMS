/**
 * GRUNT: COMPRESS
 */
module.exports = {
	dist: {
		options: {
			archive: 'dist/<%= package.name %>-<%= package.version %>.zip'
		},
		files: [{
			expand: true,
			cwd: 'dist/',
			src: ['**'],
			dest: ''
		}]
	}
};