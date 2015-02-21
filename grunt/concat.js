/**
* GRUNT: CONCAT
*/
module.exports = {
	dist: {
		src: ['src/assets/js/*.js', '!src/assets/js/<%= package.name %>.js'],
		dest: 'dist/assets/js/<%= package.name %>.js'
	},
	build: {
		src: ['src/assets/js/*.js', '!src/assets/js/<%= package.name %>.js'],
		dest: 'src/assets/js/<%= package.name %>.js'
	}
};