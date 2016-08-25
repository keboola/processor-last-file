<?php

namespace Keboola\Processor\LastFile\Tests;

use Keboola\Processor\LastFile;
use Keboola\Temp\Temp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class LastFileTest extends TestCase
{

    public function prepareTmpDir($tmp)
    {
        $fs = new Filesystem();
        $fs->mkdir($tmp->getTmpFolder() . "/data/in/files");
        $fs->mkdir($tmp->getTmpFolder() . "/data/out/files");
        $fs->copy(__DIR__ . "/data/in/files/1", $tmp->getTmpFolder() . "/data/in/files/1");
        $fs->copy(__DIR__ . "/data/in/files/1.manifest", $tmp->getTmpFolder() . "/data/in/files/1.manifest");
        $fs->copy(__DIR__ . "/data/in/files/2", $tmp->getTmpFolder() . "/data/in/files/2");
        $fs->copy(__DIR__ . "/data/in/files/2.manifest", $tmp->getTmpFolder() . "/data/in/files/2.manifest");
        $fs->copy(__DIR__ . "/data/in/files/3", $tmp->getTmpFolder() . "/data/in/files/3");
        $fs->copy(__DIR__ . "/data/in/files/3.manifest", $tmp->getTmpFolder() . "/data/in/files/3.manifest");
        $fs->copy(__DIR__ . "/data/in/files/4", $tmp->getTmpFolder() . "/data/in/files/4");
        $fs->copy(__DIR__ . "/data/in/files/4.manifest", $tmp->getTmpFolder() . "/data/in/files/4.manifest");
        $fs->copy(__DIR__ . "/data/in/files/5", $tmp->getTmpFolder() . "/data/in/files/5");
        $fs->copy(__DIR__ . "/data/in/files/5.manifest", $tmp->getTmpFolder() . "/data/in/files/5.manifest");
    }

    public function testDummy()
    {
        $this->assertTrue(true);
    }

    public function testLastFileTag1()
    {
        $tmp = new Temp();
        $this->prepareTmpDir($tmp);
        $tmpDir = $tmp->getTmpFolder();
        $lastFile = new LastFile($tmpDir . "/data/in/files/");
        $lastFile->filterTag("tag1", $tmpDir . "/data/out/files/");
        $finder = new Finder();
        $files = (array) $finder->files()->in($tmpDir . "/data/out/files/")->sortByName()->getIterator();
        $this->assertEquals(2, count($files));
        $this->assertArrayHasKey($tmpDir . "/data/out/files/2", $files);
        $this->assertArrayHasKey($tmpDir . "/data/out/files/2.manifest", $files);
    }

    public function testLastFileTag2()
    {
        $tmp = new Temp();
        $this->prepareTmpDir($tmp);
        $tmpDir = $tmp->getTmpFolder();
        $lastFile = new LastFile($tmpDir . "/data/in/files/");
        $lastFile->filterTag("tag2", $tmpDir . "/data/out/files/");
        $finder = new Finder();
        $files = (array) $finder->files()->in($tmpDir . "/data/out/files/")->sortByName()->getIterator();
        $this->assertEquals(2, count($files));
        $this->assertArrayHasKey($tmpDir . "/data/out/files/1", $files);
        $this->assertArrayHasKey($tmpDir . "/data/out/files/1.manifest", $files);
    }

    public function testLastFileTag3()
    {
        $tmp = new Temp();
        $this->prepareTmpDir($tmp);
        $tmpDir = $tmp->getTmpFolder();
        $lastFile = new LastFile($tmpDir . "/data/in/files/");
        $lastFile->filterTag("tag3", $tmpDir . "/data/out/files/");
        $finder = new Finder();
        $files = (array) $finder->files()->in($tmpDir . "/data/out/files/")->sortByName()->getIterator();
        $this->assertEquals(2, count($files));
        $this->assertArrayHasKey($tmpDir . "/data/out/files/3", $files);
        $this->assertArrayHasKey($tmpDir . "/data/out/files/3.manifest", $files);
    }

    public function testLastFileTag4()
    {
        $tmp = new Temp();
        $this->prepareTmpDir($tmp);
        $tmpDir = $tmp->getTmpFolder();
        $lastFile = new LastFile($tmpDir . "/data/in/files/");
        $lastFile->filterTag("tag4", $tmpDir . "/data/out/files/");
        $finder = new Finder();
        $files = (array) $finder->files()->in($tmpDir . "/data/out/files/")->sortByName()->getIterator();
        $this->assertEquals(2, count($files));
        $this->assertArrayHasKey($tmpDir . "/data/out/files/5", $files);
        $this->assertArrayHasKey($tmpDir . "/data/out/files/5.manifest", $files);
    }

    /**
     * @expectedException \Keboola\Processor\Exception
     * @expectedExceptionMessage No files found with tag 'tag5'.
     */
    public function testLastFileTag5()
    {
        $tmp = new Temp();
        $this->prepareTmpDir($tmp);
        $tmpDir = $tmp->getTmpFolder();
        $lastFile = new LastFile($tmpDir . "/data/in/files/");
        $lastFile->filterTag("tag5", $tmpDir . "/data/out/files/");
    }
}
