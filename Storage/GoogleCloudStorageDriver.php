<?php

namespace Softspring\ImageBundle\Storage;

use Google\Cloud\Storage\StorageClient;
use Softspring\ImageBundle\Model\ImageVersionInterface;

class GoogleCloudStorageDriver implements StorageInterface
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
    public function store(ImageVersionInterface $version): string
    {
        $bucket = $this->storageClient->bucket($this->bucket);
        $stgObject = $bucket->upload(fopen($version->getUpload()->getRealPath(), 'r'), [
            'name' => sha1(time().$version->getUpload()->getRealPath()).'.'.$version->getUpload()->guessExtension(),
        ]);

        return 'gs://'.$this->bucket.'/'.$stgObject->name();
    }
}