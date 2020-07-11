import { task, parallel, series } from "gulp";

import { cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, updateComposer } from "./release";
import { getPluginSize, replacePluginTexts, zipPlugin } from "./release";
import { buildPluginPotFile } from "./language";
import { readmeToMarkdown, replaceIml, replaceNamespaceText } from "./general";
import { linkPlugin } from "./setup";
import { backupLocalDB } from "./backup";

task("replace:iml", replaceIml);
task("replace:nameSpace", replaceNamespaceText);
task("backup:local", backupLocalDB);
task("build:potFile", buildPluginPotFile);
task("build:plugin", series(cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, replacePluginTexts, updateComposer));
task("zip:plugin", series(zipPlugin, readmeToMarkdown, getPluginSize));

task("link:plugin", parallel(linkPlugin));
