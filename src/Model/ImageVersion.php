<?php

namespace Softspring\ImageBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

abstract class ImageVersion implements ImageVersionInterface
{
    /**
     * @var ImageInterface|null
     */
    protected $image;

    /**
     * @var string|null
     */
    protected $version;

    /**
     * @var File|null
     */
    protected $upload;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var int|null
     */
    protected $width;

    /**
     * @var int|null
     */
    protected $height;

    /**
     * @var int|null
     */
    protected $fileSize;

    /**
     * @var string|null
     */
    protected $fileMimeType;

    /**
     * @var int|null
     */
    protected $uploadedAt;

    public function __construct(string $version = null, ImageInterface $image = null)
    {
        $this->setVersion($version);
        if ($image instanceof ImageInterface) {
            $image->addVersion($this);
        }
    }

    
    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    
    public function setImage(?ImageInterface $image): void
    {
        $this->image = $image;
    }

    
    public function getVersion(): ?string
    {
        return $this->version;
    }

    
    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    
    public function getUpload(): ?File
    {
        return $this->upload;
    }

    
    public function setUpload(?File $upload): void
    {
        $this->upload = $upload;
        $this->uploadedAt = gmdate('U');

        if ($this->getImage()) {
            $this->getImage()->markUploadedAtNow();
        }
    }

    
    public function getUrl(): ?string
    {
        return $this->url;
    }

    
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    
    public function getWidth(): ?int
    {
        return $this->width;
    }

    
    public function setWidth(?int $width): void
    {
        $this->width = $width;
    }

    
    public function getHeight(): ?int
    {
        return $this->height;
    }

    
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    
    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    
    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    
    public function setFileMimeType(?string $fileMimeType): void
    {
        $this->fileMimeType = $fileMimeType;
    }

    
    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt ? \DateTime::createFromFormat('U', $this->uploadedAt) : null;
    }
}
