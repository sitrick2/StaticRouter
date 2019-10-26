## StaticRouter Library

A simple raw PHP router using PHP 7.2.

## Installation

Fill this in.

## Usage

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
StaticRouter::get('/patients/{patient_id}', '\Namespace\Path\PatientsController@update');
```

###### DELETE
```
StaticRouter::get('/patients/{patient_id}', '\Namespace\Path\PatientsController@delete');
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
TestServer folder and run the following command:
```
php -S 127.0.0.1:8000
```
(Note: The test requests connect to "localhost:8000", so this could potentially be different if your localhost value is not default.)
