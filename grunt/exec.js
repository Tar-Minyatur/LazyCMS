/**
 * GRUNT: EXEC
 */
module.exports = function (grunt)  {
	'use strict';
	
	return {
		install_composer: {
			cmd: 'php composer_installer.php'
		}
	};
};