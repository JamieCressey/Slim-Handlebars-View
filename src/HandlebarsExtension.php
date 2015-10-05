<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/JamieCressey/Slim-Handlebars-View
 * @copyright Copyright (c) 2015 Jamie Cressey
 * @license   https://github.com/JamieCressey/Slim-Handlebars-View/blob/master/LICENSE.md (MIT License)
 */
namespace Slim\Views;

class HandlebarsExtension extends \Handlebars_Extension
{
    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * @var string|\Slim\Http\Uri
     */
    private $uri;

    public function __construct($router, $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function getName()
    {
        return 'slim';
    }

    public function getFunctions()
    {
        return [
            new \Handlebars_SimpleFunction('path_for', array($this, 'pathFor')),
            new \Handlebars_SimpleFunction('base_url', array($this, 'baseUrl')),
        ];
    }

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }
}
