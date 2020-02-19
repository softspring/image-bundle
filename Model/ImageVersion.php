<?php

namespace Softspring\ImageBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var UploadedFile|null
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

    public function __construct(string $version, ImageInterface $image)
    {
        $this->setVersion($version);
        $image->addVersion($this);
    }

    /**
     * @inheritDoc
     */
    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    /**
     * @inheritDoc
     */
    public function setImage(?ImageInterface $image): void
    {
        $this->image = $image;
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    /**
     * @inheritDoc
     */
    public function getUpload(): ?UploadedFile
    {
        return $this->upload;
    }

    /**
     * @inheritDoc
     */
    public function setUpload(?UploadedFile $upload): void
    {
        $this->upload = $upload;
        $this->uploadedAt = gmdate('U');
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @inheritDoc
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function setWidth(?int $width): void
    {
        $this->width = $width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    /**
     * @inheritDoc
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * @inheritDoc
     */
    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @inheritDoc
     */
    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    /**
     * @inheritDoc
     */
    public function setFileMimeType(?string $fileMimeType): void
    {
        $this->fileMimeType = $fileMimeType;
    }

    /**
     * @inheritDoc
     */
    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt ? \DateTime::createFromFormat("U", $this->uploadedAt) : null;
    }

    /**
     * @inheritDoc
     */
    public function getTypeDefinition(): ?array
    {
        if (!$image = $this->getImage()) {
            return null;
        }

        if (!$type = $image->getType()) {
            return null;
        }

        $definition = $type->getDefinition();

        return $definition[$this->version] ?? null;
    }
}