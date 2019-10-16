import { exec } from "child_process";
import gulp from "gulp";
import zip from "gulp-zip";
import del from "del";
import deleteEmpty from "delete-empty";
import replace from "gulp-replace-task";
import size from "gulp-size";
import notify from "gulp-notify";

import paths from "../paths";

const { plugin } = require("../../package");

export function zipPlugin() {
	return gulp
		.src(`./dist/done/${plugin.name}/**/*`)
		.pipe(zip(`${plugin.name}.zip`))
		.pipe(gulp.dest("./dist"));
}

export function deleteEmptyDir() {
	return deleteEmpty("./dist/build/");
}

export function cleanDSStore(done) {
	const cmd = "find ./src -type f -name '*.DS_Store' -ls -delete",
		run = exec(cmd);

	run.stdout.pipe(process.stdout);
	run.stderr.pipe(process.stderr);

	done();
}

export function cleanDist() {
	return del("./dist/**");
}

export function copyPlugin() {
	return gulp.src(paths.plugin.build).pipe(gulp.dest(`./dist/build/${plugin.name}`));
}

export function replacePluginTexts() {
	return gulp
		.src(`./dist/build/${plugin.name}/**/*`)
		.pipe(
			replace({
				patterns: [
					{
						json: {
							namespace: plugin.namespace,
							prefix: plugin.prefix,
							title: plugin.title,
							short_title: plugin.short_title,
							tags: plugin.tags,
							name: plugin.name,
							version: plugin.version,
							uri: plugin.uri,
							author: plugin.author,
							author_uri: plugin.author_uri,
							plugin_uri: plugin.plugin_uri,
							document_uri: plugin.document_uri,
							license: plugin.license,
							license_uri: plugin.license_uri,
							copyright: plugin.copyright,
							textdomain: plugin.name,
							description: plugin.description,
							wp_requires: plugin.wp_requires,
							php_requires: plugin.php_requires,
							tested_up_to: plugin.tested_up_to,
							dev_mode: plugin.dev_mode,
						},
					},
				],
				prefix: "vnh_",
			}),
		)
		.pipe(gulp.dest(`./dist/done/${plugin.name}`));
}

export function getPluginSize() {
	const s = size({
		pretty: true,
		showFiles: true,
	});

	return gulp
		.src("./dist/*.zip")
		.pipe(s)
		.pipe(
			notify({
				title: plugin.name,
				onLast: true,
				message: () => `This plugin's size is ${s.prettySize}`,
			}),
		);
}
