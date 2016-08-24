<?php
namespace Keboola\Processor;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class LastFile
{
    protected $path;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function __construct($path)
    {
        $this->setPath($path);
    }

    public function filterTag($tag)
    {
        $finder = new Finder();
        $finder->name("*.manifest");
        $manifests = [];

        foreach ($finder->in($this->getPath()) as $file) {
            $manifest = json_decode($file->getContents(), true);
            if (in_array($tag, $manifest["tags"])) {
                $manifests[$file->getFilename()] = $manifest;
            }
        }

        if (count($manifests) === 0) {
            throw new Exception("No files found with tag '{$tag}'.");
        }

        reset($manifests);
        $latestManifest = current($manifests);
        $latestKey = key($manifests);
        foreach ($manifests as $key => $manifest) {
            if ($manifest["created"] > $latestManifest["created"] ||
                $manifest["created"] == $latestManifest["created"] &&
                (int) $manifest["id"] > (int) $latestManifest["id"]
            ) {
                $latestManifest = $manifest;
                $latestKey = $key;
            }
        }

        $fs = new Filesystem();
        $finder = new Finder();

        foreach ($finder->in($this->getPath()) as $file) {
            if ($file->getFilename() == $latestKey ||
                $file->getFilename() == substr($latestKey, 0, strlen($latestKey) - 9)
            ) {
                continue;
            } else {
                $fs->remove($file->getPathname());
            }
        }
    }
}
