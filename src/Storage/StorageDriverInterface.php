<?php

namespace Softspring\ImageBundle\Storage;

use Symfony\Component\HttpFoundation\File\File;

interface StorageDriverInterface
{
    /**
     * @param File   $file
     * @param string $destName
     *
     * @return string
     */
    public function store(File $file, string $destName): string;

    /**
     * @param string $fileName
     */
    public function remove(string $fileName): void;
}