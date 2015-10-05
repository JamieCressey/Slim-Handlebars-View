<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/JamieCressey/Slim-Handlebars-View
 * @copyright Copyright (c) 2015 Jamie Cressey
 * @license   https://github.com/JamieCressey/Slim-Handlebars-View/blob/master/LICENSE.md (MIT License)
 */
namespace Slim\Views;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\HandlebarsExtension;

/**
 * Handlebars View
 *
 * This class is a Slim Framework view helper built
 * on top of the Handlebars templating component. Handlebars is
 * a JS component created by wycats.
 *
 * @link http://handlebarsjs.com/
 */
class Handlebars implements \ArrayAccess
{
    /**
     * Handlebars loader
     *
     * @var \Handlebars_LoaderInterface
     */
    protected $loader;

    /**
     * Handlebars environment
     *
     * @var \Handlebars_Environment
     */
    protected $environment;

    /**
     * Default view variables
     *
     * @var array
     */
    protected $defaultVariables = [];

    /********************************************************************************
     * Constructors and service provider registration
     *******************************************************************************/

    /**
     * Create new Handlebars view
     *
     * @param string $path     Path to templates directory
     * @param array  $settings Handlebars environment settings
     */
    public function __construct($path, $settings = [], $partials = 'partials')
    {
	$this->loader = new \Handlebars\Loader\FilesystemLoader($path, $settings);
	$this->partialLoader = new \Handlebars\Loader\FilesystemLoader($partials, $settings);

	$this->environment = new \Handlebars\Handlebars([ "loader" => $this->loader, "partials_loader" => $this->partialLoader ]);
    }

    /********************************************************************************
     * Methods
     *******************************************************************************/


    /**
     * Fetch rendered template
     *
     * @param  string $template Template pathname relative to templates directory
     * @param  array  $data     Associative array of template variables
     *
     * @return string
     */
    public function fetch($template, $data = [])
    {
        $data = array_merge($this->defaultVariables, $data);

        return $this->environment->loadTemplate($template)->render($data);
    }

    /**
     * Output rendered template
     *
     * @param ResponseInterface $response
     * @param  string $template Template pathname relative to templates directory
     * @param  array $data Associative array of template variables
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data = [])
    {
         $response->getBody()->write($this->fetch($template, $data));

         return $response;
    }

    /********************************************************************************
     * Accessors
     *******************************************************************************/

    /**
     * Return Handlebars loader
     *
     * @return \Handlebars_LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Return Handlebars environment
     *
     * @return \Handlebars_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/

    /**
     * Does this collection have a given key?
     *
     * @param  string $key The data key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item for key
     *
     * @param string $key The data key
     *
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function offsetSet($key, $value)
    {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection
     *
     * @param string $key The data key
     */
    public function offsetUnset($key)
    {
        unset($this->defaultVariables[$key]);
    }

    /********************************************************************************
     * Countable interface
     *******************************************************************************/

    /**
     * Get number of items in collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->defaultVariables);
    }

    /********************************************************************************
     * IteratorAggregate interface
     *******************************************************************************/

    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->defaultVariables);
    }
}
