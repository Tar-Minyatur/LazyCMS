/**
 * GRUNT: AUTOPREFIXER
 */
module.exports = {
	build: {
		options: {
			browsers: [
				'last 2 version',
				'ie 8',
				'ie 9',
				'ie 10',
				'Firefox > 20'
			]
		},
		files: {
			'src/assets/css/main.css' : 'src/assets/css/main.css'
		}
	},
	dist: {
		options: {
			browsers: [
				'last 2 version',
				'ie 8',
				'ie 9',
				'ie 10',
				'Firefox > 20'
			]
		},
		files: {
			'dist/assets/css/main.css' : 'dist/assets/css/main.css'
		}
	}
};