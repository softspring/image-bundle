<?php

namespace Softspring\ImageBundle\Storage;

use Symfony\Component\HttpFoundation\File\File;

interface StorageDriverInterface
{
    public function store(File $file, string $destName): string;

    public function remove(string $fileName): void;
}
