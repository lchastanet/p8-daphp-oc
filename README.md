# p8-daphp-oc

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5eaff488c1c54f38ae8ed8275ac1783b)](https://app.codacy.com/gh/lchastanet/p8-daphp-oc?utm_source=github.com&utm_medium=referral&utm_content=lchastanet/p8-daphp-oc&utm_campaign=Badge_Grade_Settings) [![Maintainability](https://api.codeclimate.com/v1/badges/0eb2cba04dce0470dc9c/maintainability)](https://codeclimate.com/github/lchastanet/p8-daphp-oc/maintainability) [![codecov](https://codecov.io/gh/lchastanet/p8-daphp-oc/branch/dev/graph/badge.svg?token=66SPDIX6OV)](https://codecov.io/gh/lchastanet/p8-daphp-oc) [![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)

This project has been carried out with the aim of passing a diploma on the [OpenClassrooms.com](https://openclassrooms.com/) learning platform.


To install it you need to have [composer](https://getcomposer.org/) installed.

Then run

```shell
$ composer install
```

Then create or modify the **.env** file to connect to your mysql installation and setup the mail server

```shell
APP_ENV=dev
APP_SECRET=37475f44748fe184be7865821e6828d6
DATABASE_URL=mysql://username:password@127.0.0.1:3306/db_name
```

Then run the following command to create database

```shell
$ php bin/console doctrine:database:create
```

Then load the initial dataset into database

```shell
$ php bin/console doctrine:fixtures:load
```

And finally run the dev server to test app

- if you have installed the symfony cli tool :

```shell
$ symfony serve
```

- if you don't have installed the symfony cli tool :

```shell
$ php -S localhost:8000 -t public
```

(Optional) if you want to launch manually tests :

```shell
$ vendor/bin/phpunit
```