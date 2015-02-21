/**
 * GRUNT: CLEAN
 */
module.exports = function (grunt)  {
	'use strict';
	return {
		dist_clean: ['dist/**', '!dist/vendor/**'],
		installer: ['composer_installer.php']
	};
};