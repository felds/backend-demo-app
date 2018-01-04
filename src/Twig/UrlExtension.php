<?php
declare(strict_types=1);

namespace App\Twig;

class UrlExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    public $publicDir;

    public function __construct(string $publicDir)
    {
        $this->publicDir = $publicDir;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('public_path', [$this, 'publicPath']),
        ];
    }

    public function publicPath(string $path)
    {
        if (strpos($path, $this->publicDir) !== 0) {
            throw new \RuntimeException("Asset path is not on the public path.");
        }

        return substr($path, strlen($this->publicDir));
    }
}
