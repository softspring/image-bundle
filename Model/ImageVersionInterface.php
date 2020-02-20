<?php

namespace Softspring\ImageBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

interface ImageVersionInterface
{
    /**
     * @return ImageInterface|null
     */
    public function getImage(): ?ImageInterface;

    /**
     * @param ImageInterface|null $parent
     */
    public function setImage(?ImageInterface $parent): void;

    /**
     * @return string|null
     */
    public function getVersion(): ?string;

    /**
     * @param string|null $version
     */
    public function setVersion(?string $version): void;

    /**
     * @return File|null
     */
    public function getUpload(): ?File;

    /**
     * @param File|null $upload
     */
    public function setUpload(?File $upload): void;

    /**
     * @return string|null
     */
    public function getUrl(): ?string;

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void;

    /**
     * @return int|null
     */
    public function getWidth(): ?int;

    /**
     * @param int|null $width
     */
    public function setWidth(?int $width): void;

    /**
     * @return int|null
     */
    public function getHeight(): ?int;

    /**
     * @param int|null $height
     */
    public function setHeight(?int $height): void;

    /**
     * @return int|null
     */
    public function getFileSize(): ?int;

    /**
     * @param int|null $fileSize
     */
    public function setFileSize(?int $fileSize): void;

    /**
     * @return string|null
     */
    public function getFileMimeType(): ?string;

    /**
     * @param string|null $fileMimeType
     */
    public function setFileMimeType(?string $fileMimeType): void;

    /**
     * @return \DateTime|null
     */
    public function getUploadedAt(): ?\DateTime;

    /**
     * @return array|null
     */
    public function getTypeDefinition(): ?array;
}