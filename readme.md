## StaticRouter Library

A simple raw PHP router using PHP 7.2.

## Installation
The package is installable via composer by running ```composer require sitrick2/static_router```

## Usage

On your routes file, import the package with the following use statements:

```
<?php

use StaticRouter\StaticRouter;
use StaticRouter\RequestResolver;

StaticRouter::get('/patients', '\Namespace\Path\PatientsController@index');
```

At the end of your routes file, call the Request Resolver's wrapUp() method;

```
StaticRouter::delete('/patients/1', '\Namespace\Path\PatientsController@index');

RequestResolver::wrapUp();
```

#### Defining Routes
Routes are defined statically and are formatted like so:

###### GET
```
StaticRouter::get('/patients/{patient_id}', '\Namespace\Path\PatientsController@get');
```

###### POST
```
StaticRouter::post('/patients', '\Namespace\Path\PatientsController@create');
```

###### PATCH
```
StaticRouter::patch('/patients/{patient_id}', '\Namespace\Path\PatientsController@update');
```

###### DELETE
```
StaticRouter::delete('/patients/{patient_id}', '\Namespace\Path\PatientsController@delete');
```
Where '{patient_id}' represents the $patient_id the PatientsController function will receive.

## What the Controllers Receive
Every controller method called by the Router receives a Request object as its first parameter. Following that,
controller methods will receive dynamic route parameters in the order defined in the route string. For example,
the following Route definition:
```
StaticRouter::get('/patients/{patient_id}/metrics/{metric_id}', '\Namespace\Path\PatientsMetricsController@get');
```

should define the PatientsMetricsController's get() method like so:
```
public function get(IRequest $request, $patient_id, $metric_id)
{
    ...
}
```

## Running The Test Server
The tests folder includes PHPUnit test files organized by Feature and Unit tests.
The Unit test folder can be run standalone, however because the Feature tests require making HTTP requests,
I've included a simple TestServer that can be run with the PHP Built-In Web Server. To run this, cd into the 
tests/TestServer folder and run the following in a terminal:
```
php -S 127.0.0.1:8000
```
(Note: The test requests connect to "localhost:8000", so this could potentially be different if your localhost value is not default.)

Once the server is active, you may run the project's local PHPUnit instance by executing the command ```vendor/bin/phpunit tests``` in the package's root directory.