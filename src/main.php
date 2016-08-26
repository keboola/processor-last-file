<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

$arguments = getopt("d::", array("data::"));
if (!isset($arguments["data"])) {
    print "Data folder not set.";
    exit(1);
}

if (!file_exists($arguments["data"] . "/config.json")) {
    print "config.json file not found";
    exit(1);
}

$config = json_decode(file_get_contents($arguments["data"] . "/config.json"), true);

if (isset($config["parameters"]["tag"])) {
    $tag = $config["parameters"]["tag"];
} else {
    print "Tag not defined.";
    exit(1);
}

try {
    $datadir = $arguments["data"] . "/in/files";
    $processor = new \Keboola\Processor\LastFile($datadir);
    $result = $processor->filterTag($tag, $arguments["data"] . "/out/files");
} catch (\Keboola\Processor\Exception $e) {
    print $e->getMessage();
    exit(1);
}

print "Processed {$rows} rows.";
exit(0);
