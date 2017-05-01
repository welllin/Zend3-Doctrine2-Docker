## Introduction

A starter kit for zend-framework 3 with doctrine2

## First Pull

You need to create a file named `local.php` under `/config/autoload` directory, with the following content.

### Create a `local.php` file to tell Doctrine2 to connect to docker database container.
```php
<?php
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => 'database',
                    'port'     => '3306',
                    'dbname'   => 'api',
                    'user'     => 'developer',
                    'password' => 'developer'
                ]
            ],            
        ],        
    ],
];
```

### Create database schema

After you fired up the containers and working, you might see the following errors in home page.

`SQLSTATE[42S02]: Base table or view not found: 1146 Table 'api.post' doesn't exist`

It means that we have a database schema runing but our database doesn't have these tables yet. We need to run the following command to update our database.

`docker-compose exec zf vendor/bin/doctrine-module orm:schema-tool:update --dump-sql`

## Development mode


```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.

## Running Unit Tests

To run the supplied skeleton unit tests, you need to do one of the following:

- During initial project creation, select to install the MVC testing support.
- After initial project creation, install [zend-test](https://zendframework.github.io/zend-test/):

  ```bash
  $ composer require --dev zendframework/zend-test
  ```

Once testing support is present, you can run the tests using:

```bash
$ ./vendor/bin/phpunit
```

If you need to make local modifications for the PHPUnit test setup, copy
`phpunit.xml.dist` to `phpunit.xml` and edit the new file; the latter has
precedence over the former when running tests, and is ignored by version
control. (If you want to make the modifications permanent, edit the
`phpunit.xml.dist` file.)

## Using docker-compose

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

You might be prompted to ask which modules to install when executing the command, most likely you need to choose the second option - `config/modules.config.php`.
