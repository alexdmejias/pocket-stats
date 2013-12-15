"use strict";

module.exports = function(grunt) {
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	var paths = {
		libraryDir: 'library',
		appDir: '../application'
	};


	grunt.initConfig({
		paths: paths,

		watch: {
			compass: {
				files: ['<%= paths.libraryDir %>/scss/**/*.scss'],
				tasks: ['compass']
			},

			livereload: {
				options: { livereload: true },
				files: ['<%= paths.libraryDir %>/css/style.css', '<%= paths.appDir %>/**/*.php']
			}
		},

		compass: {
			dist: {
				options: {
					force: true,
					cssDir: '<%= paths.libraryDir %>/css/',
					sassDir: '<%= paths.libraryDir %>/scss/'
				}
			}
		},

        rsync: {
            options: {
                src: "../",
                args: ["--verbose"],
                exclude: ['.git*', 'node_modules', '.sass-cache', 'Gruntfile.js', 'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc'],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            staging: {
                options: {
                    dest: "/var/www/labs.alexdmejias.com/pocket/",
                    host: "mejias@162.243.38.222"
                }
            }
        }

	});

	grunt.registerTask('default', ['watch']);
};