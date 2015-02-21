/**
 * GRUNT: SASS
 */
module.exports = {
	build: {
		options: {
			style: 'compact'
		},
		files: {
			'src/assets/css/main.css' : 'src/assets/scss/main.scss'
		}
	},
	dist: {
		options: {
			style: 'compact'
		},
		files: {
			'dist/assets/css/main.css' : 'src/assets/scss/main.scss'
		}
	}
};