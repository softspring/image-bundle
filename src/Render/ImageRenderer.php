<?php

namespace Softspring\ImageBundle\Render;

use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Softspring\ImageBundle\Type\ImageTypesCollection;

class ImageRenderer
{
    protected ImageTypesCollection $imageTypesCollection;

    public function __construct(ImageTypesCollection $imageTypesCollection)
    {
        $this->imageTypesCollection = $imageTypesCollection;
    }

    public function imageUrl(ImageInterface $image, $version, array $attr = []): string
    {
        if (is_array($version)) {
            foreach ($version as $singleVersion) {
                if ($url = $this->getFinalUrl($singleVersion)) {
                    return $url;
                }
            }

            return '';
        } else {
            if (!$imageVersion = $image->getVersion($version)) {
                return '';
            }

            return $this->getFinalUrl($imageVersion);
        }
    }

    public function renderImage(ImageInterface $image, $version, array $attr = []): string
    {
        if (is_array($version)) {
            foreach ($version as $singleVersion) {
                if ($html = $this->renderImage($image, $singleVersion, $attr)) {
                    return $html;
                }
            }

            return '';
        } else {
            if (!$imageVersion = $image->getVersion($version)) {
                return '';
            }

            return $this->renderImgTag($imageVersion, $attr);
        }
    }

    public function renderPicture(ImageInterface $image, string $picture = '_default', array $attr = []): string
    {
        $config = $this->imageTypesCollection->getType($image->getType());

        if (!isset($config['pictures'][$picture])) {
            throw new \Exception('picture config is not set for '.$image->getType());
        }

        $html = '<picture>';
        foreach ($config['pictures'][$picture]['sources'] ?? [] as $source) {
            $sourceAttrs = $source['attrs'] ?? [];
            $sourceAttrs['srcset'] = implode(', ', array_map(function ($srcset) use ($image) {
                return $this->getFinalUrl($image->getVersion($srcset['version'])).($srcset['suffix'] ? " {$srcset['suffix']}" : '');
            }, $source['srcset']));
            $html .= '<source '.$this->htmlAttributes($sourceAttrs).' />';
        }

        $html .= $this->renderImgTag($image->getVersion($config['pictures'][$picture]['img']['src_version']), $attr);
        $html .= '</picture>';

        return $html;
    }

    protected function htmlAttributes(array $attributes): string
    {
        array_walk($attributes, function (&$value, $attribute) { $value = "$attribute=\"$value\""; });

        return implode(' ', $attributes);
    }

    protected function renderImgTag(ImageVersionInterface $version, array $attr = []): string
    {
        $attributes = array_merge([
            'width' => $version->getWidth(),
            'height' => $version->getHeight(),
        ], $attr);

        $attributes['src'] = $this->getFinalUrl($version);

        return '<img '.$this->htmlAttributes($attributes).' />';
    }

    protected function getFinalUrl(ImageVersionInterface $version): string
    {
        if ('gs://' == substr($version->getUrl(), 0, 5)) {
            return 'https://storage.googleapis.com/'.substr($version->getUrl(), 5);
        }

        return $version->getUrl();
    }
}
