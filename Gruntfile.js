//var path = 'app/webroot/';

module.exports = function(grunt){

	require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);
	
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        cssmin: {
        	build: {
        		files: {
        			'public_html/wp-content/themes/soundblast/css/min/main.min.css': ['public_html/wp-content/themes/soundblast/css/*.css', 'public_html/wp-content/themes/soundblast/*.css']
        		}
        	}
        },
        uglify: {
		    build: {
		        files: {
		            'public_html/wp-content/themes/soundblast/scripts/min/main.min.js': ['public_html/wp-content/themes/soundblast/scripts/frontend/*.js', 'public_html/wp-content/themes/soundblast/scripts/*.js'],             
		        }
		    }
		},
		watch: {
			scripts: {
				files: ['public_html/wp-content/themes/soundblast/scripts/frontend/*.js', 'public_html/wp-content/themes/soundblast/scripts/*.js', 'public_html/wp-content/themes/soundblast/css/*.css', 'public_html/wp-content/themes/soundblast/*.css'],
				tasks: ['uglify', 'cssmin'],
				options: {
				  spawn: false
				}
			}
		}
    });

    grunt.registerTask('default', []);

};