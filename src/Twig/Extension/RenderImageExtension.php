<?php

namespace Softspring\ImageBundle\Twig\Extension;

use Softspring\ImageBundle\Render\ImageRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RenderImageExtension extends AbstractExtension
{
    protected ImageRenderer $imageRenderer;

    public function __construct(ImageRenderer $imageRenderer)
    {
        $this->imageRenderer = $imageRenderer;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sfs_image_render_image', [$this->imageRenderer, 'renderImage'], ['is_safe' => ['html']]),
            new TwigFilter('sfs_image_render_picture', [$this->imageRenderer, 'renderPicture'], ['is_safe' => ['html']]),
            new TwigFilter('sfs_image_url', [$this->imageRenderer, 'imageUrl']),
        ];
    }
}
