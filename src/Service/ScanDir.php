<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class ScanDir
{
    private $finder;
    private $directory;
    private $names = [];

//    public function __construct(Finder $finder)
//    {
//        $this->finder = $finder;
//
//    }

    public function scanDirectory(Finder $finder, string $directory)
    {
        $this->finder = $finder;
        $this->directory = $directory;
    }

    public function getFiles()
    {
        return $this->finder->files()->in($this->directory);
    }

    public function getNames()
    {
        foreach ($this->finder->getFiles() as $file) {
            $this->names = $this->removeExtension($file->getFilename());
            dump($this->names);
        }

        return $this->names;
    }

    private function removeExtension(string $name)
    {
        return str_replace('.php', '', $name);
    }
}
