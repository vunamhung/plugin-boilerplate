import gulp from "gulp";
import readme from "gulp-readme-to-markdown";
import replace from "gulp-replace-task";
import { exec } from "child_process";

const { plugin } = require("../../package");

export function replaceIml(done) {
	let sed = `sed -i "" 's/plugin-boilerplate/${plugin.slug}/g' .idea/modules.xml`,
		rename = `mv .idea/Plugin-Boilerplate.iml .idea/${plugin.slug}.iml`,
		cmd = `${rename} && ${sed}`,
		run = exec(cmd);

	run.stdout.pipe(process.stdout);
	run.stderr.pipe(process.stderr);

	done();
}

export function readmeToMarkdown() {
	return gulp
		.src("src/plugin/readme.txt")
		.pipe(
			readme({
				details: false,
				extract: {
					changelog: "CHANGELOG",
					"Frequently Asked Questions": "FAQ",
				},
			}),
		)
		.pipe(gulp.dest("."));
}

export function replaceNamespaceText() {
	return gulp
		.src("src/plugin/**/*")
		.pipe(
			replace({
				patterns: [
					{
						json: {
							namespace: plugin.namespace,
						},
					},
				],
				prefix: "vnh_",
			}),
		)
		.pipe(gulp.dest("src/plugin"));
}
