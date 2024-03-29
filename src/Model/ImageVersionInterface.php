<?php

namespace Softspring\ImageBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

interface ImageVersionInterface
{
    public function getImage(): ?ImageInterface;

    public function setImage(?ImageInterface $parent): void;

    public function getVersion(): ?string;

    public function setVersion(?string $version): void;

    public function getUpload(): ?File;

    public function setUpload(?File $upload): void;

    public function getUrl(): ?string;

    public function setUrl(?string $url): void;

    public function getWidth(): ?int;

    public function setWidth(?int $width): void;

    public function getHeight(): ?int;

    public function setHeight(?int $height): void;

    public function getFileSize(): ?int;

    public function setFileSize(?int $fileSize): void;

    public function getFileMimeType(): ?string;

    public function setFileMimeType(?string $fileMimeType): void;

    public function getUploadedAt(): ?\DateTime;
}
