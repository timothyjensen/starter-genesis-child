/**
 * Gulp task config file.
 *
 * @package starter-genesis-child
 */

'use strict';

var gulp    = require( 'gulp' ),
	pkg     = require( './package.json' ),
	toolkit = require( 'gulp-wp-toolkit' );

toolkit.extendConfig(
	{
		theme: {
			name: pkg.theme.name,
			themeuri: pkg.homepage,
			description: pkg.theme.description,
			author: pkg.author,
			authoruri: pkg.theme.authoruri,
			version: pkg.version,
			license: pkg.license,
			licenseuri: pkg.theme.licenseuri,
			tags: pkg.theme.tags,
			textdomain: pkg.name,
			domainpath: pkg.theme.domainpath,
			template: pkg.theme.template,
			notes: pkg.theme.notes
		},
		css: {
			basefontsize: 10, // Used by postcss-pxtorem.
			remmediaquery: false,
            scss: {
                'style': {
                    src: 'develop/scss/style.scss',
                    dest: './',
                    outputStyle: 'expanded',
                },
                'style.min': {
                    src: 'develop/scss/style.scss',
                    dest: './',
                    outputStyle: 'compressed',
                }
            },
		},
		js: {
			'theme': [
				'develop/js/responsive-menus.js'
			]
		},
		dest: {
			images: './assets/images/',
			js: './assets/js/'
		},
		server: {
			url: 'wpsandbox.local'
		}
	}
);

toolkit.extendTasks( gulp, { /* Task Overrides...none at this time */ } );
