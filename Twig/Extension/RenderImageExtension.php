<?php

namespace Softspring\ImageBundle\Twig\Extension;

use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RenderImageExtension extends AbstractExtension
{
    /**
     * @var array
     */
    protected $imageTypes;

    /**
     * RenderImageExtension constructor.
     *
     * @param array $imageTypes
     */
    public function __construct(array $imageTypes)
    {
        $this->imageTypes = $imageTypes;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('sfs_image_render_image', [$this, 'renderImage'], ['is_safe' => ['html']]),
            new TwigFilter('sfs_image_render_picture', [$this, 'renderPicture'], ['is_safe' => ['html']]),
        ];
    }

    public function renderImage(ImageInterface $image, string $version, array $attr = []): string
    {
        if (! $imageVersion = $image->getVersion($version)) {
            return '';
        }

        return $this->renderImgTag($imageVersion, $attr);
    }

    public function renderPicture(ImageInterface $image): string
    {
        $config = $this->imageTypes[$image->getType()];

        if (!isset($config['picture'])) {
            throw new \Exception('picture config is not set for '.$image->getType());
        }

        $html = '<picture>';
        foreach ($config['picture']['sources'] ?? [] as $source) {
            $sourceAttrs = [
                'srcset' => $this->getFinalUrl($image->getVersion($source['src_version'])),
            ];
            if (!empty($source['media'])) {
                $sourceAttrs['media'] = $source['media'];
            }
            if (!empty($source['sizes'])) {
                $sourceAttrs['sizes'] = $source['sizes'];
            }
            $html .= '<source '. $this->htmlAttributes($sourceAttrs) . ' />';
        }

        $html .= $this->renderImgTag($image->getVersion($config['picture']['img']['src_version']));
        $html .= '</picture>';

        return $html;
    }


    protected function htmlAttributes(array $attributes): string
    {
        array_walk($attributes, function(&$value, $attribute) { $value = "$attribute=\"$value\""; });
        return implode(' ', $attributes);
    }

    /**
     * @param ImageVersionInterface $version
     * @param array                 $attr
     *
     * @return string
     */
    protected function renderImgTag(ImageVersionInterface $version, array $attr = []): string
    {
        $attributes = array_merge([
            'width' => $version->getWidth(),
            'height' => $version->getHeight(),
        ], $attr);

        $attributes['src'] = $this->getFinalUrl($version);

        return '<img '. $this->htmlAttributes($attributes) . ' />';
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