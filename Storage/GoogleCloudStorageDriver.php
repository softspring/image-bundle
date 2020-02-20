<?php

namespace Softspring\ImageBundle\Storage;

use Google\Cloud\Storage\StorageClient;
use Symfony\Component\HttpFoundation\File\File;

class GoogleCloudStorageDriver implements StorageDriverInterface
{
    /**
     * @var StorageClient
     */
    protected $storageClient;

    /**
     * @var string
     */
    protected $bucket;

    /**
     * GoogleCloudStorageDriver constructor.
     *
     * @param StorageClient $storageClient
     * @param string        $bucket
     */
    public function __construct(StorageClient $storageClient, string $bucket)
    {
        $this->storageClient = $storageClient;
        $this->bucket = $bucket;
    }

    /**
     * @inheritDoc
     */
    public function store(File $file, string $destName): string
    {
        $bucket = $this->storageClient->bucket($this->bucket);
        $stgObject = $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => $destName,
        ]);

        return 'gs://'.$this->bucket.'/'.$stgObject->name();
    }
}