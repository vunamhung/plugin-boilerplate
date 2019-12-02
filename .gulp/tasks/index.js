import { task, parallel, series } from "gulp";

import { bsLocal } from "./browserSync";
import { watchFiles } from "./watch";
import { cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, updateComposer } from "./release";
import { getPluginSize, replacePluginTexts, zipPlugin } from "./release";
import { buildPluginPotFile } from "./language";
import { readmeToMarkdown, replaceNamespaceText } from "./general";
import { linkPlugin } from "./setup";

task("replace:nameSpace", replaceNamespaceText);
task("build:potFile", buildPluginPotFile);
task("build:plugin", series(cleanDist, cleanDSStore, copyPlugin, deleteEmptyDir, replacePluginTexts, updateComposer));
task("zip:plugin", series(zipPlugin, readmeToMarkdown, getPluginSize));

task("link:plugin", parallel(linkPlugin));
task("default", parallel(watchFiles, bsLocal));
