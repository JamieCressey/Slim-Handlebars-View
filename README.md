# Slim Framework Handlebars View

[![Build Status](https://travis-ci.org/jamiecressey/Handlebars-View.svg?branch=master)](https://travis-ci.org/jamiecressey/Handlebars-View)

This is a Slim Framework view helper built on top of the Handlebars templating component. You can use this component to create and render templates in your Slim Framework application.

## Install

Via [Composer](https://getcomposer.org/)

```bash
$ composer require jamiecressey/slim-handlebars-view
```

Requires Slim Framework 3 and PHP 5.5.0 or newer.

## Usage

```php
// Create Slim app
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Handlebars View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Handlebars('path/to/templates', [
        'extension' => 'handlebars'
    ]);
    
    return $view;
};

// Define named route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Run app
$app->run();
```

## Custom template functions

This component exposes a custom `path_for()` function to your Handlebars templates. You can use this function to generate complete URLs to any Slim application named route. This is an example Handlebars template:

    {{>layout}}

    <h1>User List</h1>
    <ul>
        <li><a href="{{ path_for('profile', { 'name': 'josh' }) }}">Josh</a></li>
    </ul>

## Testing

```bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@slimframework.com instead of using the issue tracker.

## Credits

- [Jamie Cressey](https://github.com/JamieCressey)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
