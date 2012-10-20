# DevtimeBackboneBundle 

Easily setup and use backbone.js (0.9.2) with Symfony 2.1.1

Follow [@gigo6000 on Twitter](http://twitter.com/gigo6000). Tweet any questions or suggestions you have about the project.

## Symfony setup
This bundle requires the use of Symfony 2.1.1  and greater

The latest versions of jquery, underscore.js and backbone.js are included. 
    
### Installation

### Step 1: Download DevtimeBackboneBundle using composer

Add DevtimeBackboneBundle in your composer.json:

```js
{
    "require": {
        "devtime/backbone-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update devtime/backbone-bundle
```

Composer will install the bundle to your project's `vendor/devtime` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Devtime\BackboneBundle\DevtimeBackboneBundle(),
    );
}
```

### Layout 

``` bash
php app/console backbone:install AcmeDemoBundle
```

Running `php app/console backbone:install` will create the following directory structure under `Resources/js/`:
  
``` bash
    routers/
    models/
    collections/
    templates/
    views/
```
    
It will also create a toplevel app.js file to setup namespacing and setup initial requires.
    
After this you need to install (publish) your assets

``` bash
php app/console assets:install
```

## Scaffolding 
BackboneBundle provides a simple generator to help you get started using backbone.js with Symfony2.
The generator will only create client side code (javascript).

``` bash
php app/console backbone:scaffold AcmeDemoBundle model
```
    
This generator creates a router, views, templates, model and collection to create a simple crud single page app

## Example Usage

