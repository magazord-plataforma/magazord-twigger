<?php

namespace MagaZord\TwigLint;

/**
 * @author Rafael Becker <rafael.becker@magazord.com.br>
 */
class MockExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var string[]
     */
    protected $functions = [];

    /**
     * @var string[]
     */
    protected $filters = [];

    /**
     * @var string
     */
    protected $addonsDir;

    /**
     * @param string $addonsDir
     */
    public function __construct(string $addonsDir = '/addons')
    {
        $this->addonsDir = $addonsDir;
        $this->functions = $this->ini_function();
        $this->filters = $this->ini_filters();
    }

    /**
     * @return array|string[]
     */
    protected function ini_function() {
        return $this->get_array_file($this->addonsDir . DIRECTORY_SEPARATOR . 'twig_functions.txt');
    }

    /**
     * @return array|string[]
     */
    protected function ini_filters()
    {
        return $this->get_array_file($this->addonsDir . DIRECTORY_SEPARATOR . 'twig_filters.txt');
    }

    /**
     * @param $path
     *
     * @return array|string[]
     */
    protected function get_array_file($path)
    {
        if (!file_exists($path)) {
            return [];
        }
        if (!$content = file_get_contents($path)) {
            return [];
        }
        if (!$data = explode(PHP_EOL, $content)) {
            return [];
        }
        return $data;
    }

    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return array_map(function ($extension) {
            return new \Twig\TwigFunction($extension, function () {
                return "mock";
            });
        }, $this->functions);
    }

    /**
     * @return array|\Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return array_map(function ($extension) {
            return new \Twig\TwigFilter($extension, function () {
                return "mock";
            });
        }, $this->filters);
    }
}
