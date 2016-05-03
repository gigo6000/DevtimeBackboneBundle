# Backbone Bundle 

[![Build Status](https://secure.travis-ci.org/gigo6000/DevtimeBackboneBundle.png?branch=master)](http://travis-ci.org/gigo6000/DevtimeBackboneBundle)
[![Latest Stable Version](https://poser.pugx.org/devtime/backbone-bundle/v/stable)](https://packagist.org/packages/devtime/backbone-bundle) 
[![Total Downloads](https://poser.pugx.org/devtime/backbone-bundle/downloads)](https://packagist.org/packages/devtime/backbone-bundle) 
[![License](https://poser.pugx.org/devtime/backbone-bundle/license)](https://packagist.org/packages/devtime/backbone-bundle)

Easily setup and use backbone.js with Symfony 2.1.1 and greater (it probably works in older versions but not tested)

Follow [@gigo6000 on Twitter](http://twitter.com/gigo6000). Tweet any questions or suggestions you have about the project.

## What you need 
This bundle requires Symfony 2.1.1 or greater (it probably works in older versions but not tested)

The latest versions of jquery, underscore.js and backbone.js are included. 
    
## Installation

### Step 1: Download DevtimeBackboneBundle using composer

Add DevtimeBackboneBundle in your composer.json:

```js
{
    "require": {
        "devtime/backbone-bundle": "dev-master"
    }
}
```

Now tell *composer to download the bundle by running the command:

``` bash
$ php composer.phar update devtime/backbone-bundle
```

Composer will install the bundle to your project's `vendor/devtime` directory.

* Note: If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

``` bash
curl -s https://getcomposer.org/installer | php
```

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

## Layout / Directory structure 

Create the basic directory structure for your backbone files. Remember that you only need to do this once!.

``` bash
php app/console backbone:install AcmeDemoBundle
```

This will create the following directory structure under `Resources/public/js/`:
  
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
And you should see all the files now under your web dir ready for your template!  `web/bundles/acmedemo/js/`

```jinja
// src/Acme/DemoBundle/Resources/views/layout.html.twig
        {% block javascripts %}
            <script src="{{ asset('bundles/acmedemo/js/jquery.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('bundles/acmedemo/js/underscore.js') }}" type="text/javascript"></script>
            <script src="{{ asset('bundles/acmedemo/js/backbone.js') }}" type="text/javascript"></script>
            <script src="{{ asset('bundles/acmedemo/js/app.js') }}" type="text/javascript"></script>
        {% endblock %}
```
After putting this in your template and reloading the page you should see a popup message saying: "Hellow from Backbone!"


## Scaffolding 
This bundle provides a simple generator to help you get started with your backbone.js classes. 
The generator will only create client side code (javascript).

``` bash
php app/console backbone:scaffold AcmeDemoBundle model
```
    
The scaffold generator creates skeleton router, view, model and collection classes

## Example Usage
``` bash
php app/console backbone:install AcmeDemoBundle
```
``` bash
Installing backbone for bundle "AcmeDemoBundle"
create /Resources/public/js/collections
create /Resources/public/js/models
create /Resources/public/js/routers
create /Resources/public/js/views
create /Resources/public/js/templates
create /Resources/public/js/backbone.js
create /Resources/public/js/underscore.js
create /Resources/public/js/app.js
create /Resources/public/js/jquery.min.js
```

``` bash
php app/console backbone:scaffold AcmeDemoBundle entry
```
``` bash
Generating backbone scaffold classes for bundle "AcmeDemoBundle"
create /Resources/public/js/models/entry.js
create /Resources/public/js/collections/entries.js
create /Resources/public/js/routers/entries_router.js
create /Resources/public/js/views/entries/entries_index.js
```

``` bash
php app/console assets:install
```

### Output dir structure
``` bash
src/Acme/DemoBundle/Resources/public/js/
|-- app.js
|-- backbone.js
|-- collections
|   `-- entries.js
|-- jquery.min.js
|-- models
|   `-- entry.js
|-- routers
|   `-- entries_router.js
|-- templates
|-- underscore.js
`-- views
    `-- entries
        `-- entries_index.js
```

### Install without javascript assets
``` bash
php app/console backbone:install DevtimeRafflerBundle --no-underscore --no-backbone --no-jquery
```

### Using another jquery version or CDN hosted jquery

If you want to use your own jquery lib, just remove the jquery line in your template:

``` 
<script src="{{ asset('/bundles/acmedemo/js/jquery.min.js') }}" type="text/javascript"></script>
``` 

And make sure the other lines are AFTER your jquery lib is included:

```jinja
{% block head %}
...
        {% block javascripts %}
            <script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
            <script src="{{ asset('/bundles/acmedemo/js/underscore.js') }}" type="text/javascript"></script>
            <script src="{{ asset('/bundles/acmedemo/js/backbone.js') }}" type="text/javascript"></script>
            <script src="{{ asset('/bundles/acmedemo/js/app.js') }}" type="text/javascript"></script>
        {% endblock %}
{% endblock %}
        
``` 

## Sample App

This simple app was created with this bundle: https://github.com/gigo6000/DevtimeRafflerBundle
