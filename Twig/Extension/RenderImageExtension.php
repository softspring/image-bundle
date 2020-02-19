<?php

namespace Softspring\ImageBundle\Twig\Extension;

use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RenderImageExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sfs_image_render_picture', [$this, 'renderPicture'], ['is_safe' => ['html']]),
            new TwigFilter('sfs_image_thumbnail', [$this, 'renderThumbnail'], ['is_safe' => ['html']]),
        ];
    }

    public function renderThumbnail(ImageInterface $image): string
    {
        return $this->renderPicture($image, '_thumbnail');
    }

    public function renderPicture(ImageInterface $image, string $version): string
    {
        if (! $imageVersion = $image->getVersion($version)) {
            return '';
        }

        return $this->renderImgTag($imageVersion);

//        <picture>
//  <source media="(min-width: 500w)" srcset="dog-500.png" sizes="100vw">
//  <source media="(min-width: 800w)" srcset="dog-800.png" sizes="100vw">
//  <source media="(min-width: 1000w)" srcset="dog-1000.png"	sizes="800px">
//  <source media="(min-width: 1400w)" srcset="dog-1400.png"	sizes="800px">
//  <img src="dog.png" alt="A dog image">
//</picture>
    }

    /**
     * @param ImageVersionInterface $version
     *
     * @return string
     */
    protected function renderImgTag(ImageVersionInterface $version): string
    {
        $definition = $version->getTypeDefinition();
        $width = $version->getWidth();
        $height = $version->getHeight();

        return sprintf('<img width="%u" height="%u" src="%s" />', $width, $height, $this->getFinalUrl($version));
    }

    /**
     * @param ImageVersionInterface $version
     *
     * @return string
     */
    protected function getFinalUrl(ImageVersionInterface $version): string
    {
        if (substr($version->getUrl(), 0, 5) == 'gs://') {
            return 'https://storage.googleapis.com/'.substr($version->getUrl(), 5);
        }

        return $version->getUrl();
    }
}