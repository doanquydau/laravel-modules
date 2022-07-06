# Laravel-Modules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nwidart/laravel-modules.svg?style=flat-square)](https://packagist.org/packages/nwidart/laravel-modules)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/nWidart/laravel-modules/master.svg?style=flat-square)](https://travis-ci.org/nWidart/laravel-modules)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nWidart/laravel-modules.svg?maxAge=86400&style=flat-square)](https://scrutinizer-ci.com/g/nWidart/laravel-modules/?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/nWidart/laravel-modules.svg?style=flat-square)](https://scrutinizer-ci.com/g/nWidart/laravel-modules)
[![Total Downloads](https://img.shields.io/packagist/dt/nwidart/laravel-modules.svg?style=flat-square)](https://packagist.org/packages/nwidart/laravel-modules)

| **Laravel**  |  **laravel-modules** |
|---|---|
| 9.0  | ^9.0 |

`chicky/laravel-modules` is a Laravel package which created to manage your large Laravel app using modules, mostly just use to support Gamota Landing System. Module is like a Laravel package, it has some views, controllers or models. This package is supported and tested in Laravel 9.

## Install

To install through Composer, by run the following command:

``` bash
composer require chicky/laravel-modules
```

The package will automatically register a service provider and alias.

Optionally, publish the package's configuration file by running:

``` bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

### Autoloading

By default, the module classes are not loaded automatically. You can autoload your modules using `psr-4`. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/",
      "Database\\Factories\\": "database/factories/",
      "Database\\Seeders\\": "database/seeders/"
  }

}
```

**Tip: don't forget to run `composer dump-autoload` afterwards.**

## Documentation

Basic documentation on [https://docs.laravelmodules.com/](https://docs.laravelmodules.com/).

## Gamota Components Document

#### Requirements

- Add variables in env file (support for Landing API): 
  ```
    PURCHASE_LIST_GAME_SECRET_KEY=
    PURCHASE_SECRET_KEY=
    PURCHASE_GET_ROLE_SECRET_KEY=
    PAY_AUTH_SECRET_KEY=
    GAME_API_KEY=
    APPOTA_API_KEY=
    TELEGRAM_API_KEY=
    SENDGIFT_VERIFY_TOKEN=
  ```
- Install `Passport`
  ```
    php artisan migrate
    php artisan passport:install
  ```

#### 1. Create Module

- Have 2 ways to create a module:

##### Way 1:

Create module with default
- Step 1: ``` php artisan module:make <Module Name> --support="gamota" ```
- Step 2: ``` php artisan make:gamota-component birthday --components="item,item_log" ```. 
> Components: item, item_log, role, payment, config.

##### Way 2 (recommend):

Create module with components
- Step 1: ``` php artisan module:make <Module Name> --components="item,item_log,config,share,payment,role" --support="gamota" ```
> Components: item, item_log, role, payment, config.

Parameter `--support="gamota"` to generate module controller support Gamota Landing APIs

##### Run Migrate
- Don't forget `php artisan module:migrate <Module Name>`

#### 2. Add Module to Sidebar in CMS

Insert this code `@include('trianvip::partials.sidebar.trianvip')` in file: `resources/views/partials/sidebar.blade.php`

#### 3. Create Send Gift Console
- Run `php artisan module:make-sendgift-command <Module Name>`.
- Add below code to Module Service Provider
    ```
    $this->commands([
        SendGiftCommand::class,
    ]);
    ```
- Run command `php artisan module_name:send-gift`. Example: `php artisan birthday:send-gift`
> List Laravel command: `php artisan list`

#### 4. Landing API docs

+ Base URL: https://trutien.gamota.net
+ Dev Base URL: https://dev-trutien.gamota.net

[Login](#login)
 - [Login Normal](#login-normal)
 - [Login Google](#login-google)
 - [Login Facebook](#login-facebook)
 
[Server & Role](#server-and-role)
- [List Server](#list-server)
- [List Role](#list-role)

[Attend](#attend)
- [Attend](#attend)

[Role Info](#role-info)
- [Get Role Info](#get-role-info)

[Spin](#spin)
- [Spin](#spin)

[Rule](#rule)
- [Get Rule](#get-rule)

[History](#history)
- [List Histories](#list-histories)

[Rank](#rank)
- [List Rank](#list-rank)

[Share]()
- [Post Share](#post-share)
- [Get total share](#get-total-share)

### Login
#### Login Normal
1. URL: `api/<module_name>/login`
2. Method: `POST`
3. Params: 
 - `username`: String
 - `password`: String
5. response: JSON

    ```json
    {
        "error": int,
        "message": "string",
        "data": {
            "appota_userid": 2618078,
            "appota_username": "Xuanxuxu",
             "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNjE4MDc4IiwiaWF0IjoxNjU1Nzk0Mzk0LCJhcHBvdGFfdXNlcmlkIjoiMjYxODA3OCIsImFwcG90YV91c2VybmFtZSI6Ilh1YW54dXh1IiwiZXhwIjoxNjU1ODA1MTk0fQ.NlgsXksofRR_tGfodO-CRWkv_tJXsXvYDRuPyNu08Dc",
            "expired": 1655805194
        }
    }
    ```

#### Login Google
1. URL: `api/<module_name>/login`
2. Method: `POST`
3. Params: 
 - `google_token`: String
5. response: JSON

    ```json
    {
        "error": int,
        "message": "string",
        "data": {
            "appota_userid": 2618078,
            "appota_username": "Xuanxuxu",
             "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNjE4MDc4IiwiaWF0IjoxNjU1Nzk0Mzk0LCJhcHBvdGFfdXNlcmlkIjoiMjYxODA3OCIsImFwcG90YV91c2VybmFtZSI6Ilh1YW54dXh1IiwiZXhwIjoxNjU1ODA1MTk0fQ.NlgsXksofRR_tGfodO-CRWkv_tJXsXvYDRuPyNu08Dc",
            "expired": 1655805194
        }
    }
    ```

#### Login Facebook
1. URL: `api/<module_name>/login`
2. Method: `POST`
3. Params: 
 - `facebook_token`: String
5. response: JSON

    ```json
    {
        "error": int,
        "message": "string",
        "data": {
            "appota_userid": 2618078,
            "appota_username": "Xuanxuxu",
             "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIyNjE4MDc4IiwiaWF0IjoxNjU1Nzk0Mzk0LCJhcHBvdGFfdXNlcmlkIjoiMjYxODA3OCIsImFwcG90YV91c2VybmFtZSI6Ilh1YW54dXh1IiwiZXhwIjoxNjU1ODA1MTk0fQ.NlgsXksofRR_tGfodO-CRWkv_tJXsXvYDRuPyNu08Dc",
            "expired": 1655805194
        }
    }
    ```

### Server and Role
#### List Server
1. URL: `api/<module_name>/list-server`
2. Authorization: null
3. Method: `GET`
4. Params: 
 - `username`: String
 - `password`: String
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": {
            "23001": "Bích Dao",
            "23092": "Cửu Ngạn",
            "23102": "Đại Bằng",
        }
    }
    ```

#### List Role
1. URL: `api/<module_name>/list-role`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `GET`
4. Params: 
 - `server_id`: Int
5. response: JSON

    ```json
    {
        "error": int,
        "message": "string"
        "data": {
            "6474205939321801742": "Rufuif",
            "6484620513460142559": "Xxtyu",
            "6486872313273780784": "xuanxuxu",
            "6490531487971060786": "heoheo",
            "6491375912901154073": "chipchip"
        }
    }
    ```

### Attend
#### Attend
1. URL: `api/<module_name>/attend`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `POST`
4. Params: 
 - `role_id`: String
 - `role_name`: String
 - `server_id`: String
 - `server_name`: String
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
    }
    ```
### Role Info
#### Get Role Info
1. URL: `api/<module_name>/get-role-info`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `GET`
4. Params: 
 - `role_id`: String
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": {
            "spin_total": 100,
            "spin_received": 20,
            "spin_available": 80,
            "detail": [
                "role_id": "6490250012994306385",
                "role_name": "BăngČTuyết",
                "server_name": "Đằng Vân",
                "spin_total": "100"
            ]
        }
    }
    ```

### Spin
#### Spin
1. URL: `api/<module_name>/spin`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `POST`
4. Params: 
 - `role_id`: String
 - `server_id`: String
 - `type`: Integer | Enum (1, 3, 6)
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": {
            "spin_total": 100,
            "spin_received": 20,
            "spin_available": 80,
            "detail": [
                {
                    "gift_title": "Quà ingame ",
                    "gift_id": 1,
                    "position": 1
                },
                {
                    "gift_title": "Quà ingame ",
                    "gift_id": 1,
                    "position": 1
                },
                {
                    "gift_title": "Áo Tru Tiên",
                    "gift_id": 2,
                    "position": 2
                }
            ]
        }
    }
    ```

### Rule
#### Get Rule
1. URL: `api/<module_name>/rule`
2. Authorization: None
3. Method: `GET`
4. Params: 
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": "<p>Rule Text<p>"
    }
    ```

### History
#### List History
1. URL: `api/<module_name>/histories`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `GET`
4. Params: 
 - `role_id`: String
 - `type`: String - Type: spin
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": [
            {
                "gift_id": 1,
                "gift_type": "spin",
                "gift_title": "Quà ingame",
                "role_name": "BăngČTuyết",
                "server_name": "Đằng Vân",
                "created_at": "2022-06-20 17:56:30",
                "detail": {
                    "title": "Quà ingame",
                    "image": "https://trutien.gamota.com/wp-content/uploads/2021/03/giang-tu-tinh-hon.png\r\n"
                }
            },
            ...
        ]
    }
    ```

### Rank
#### List Rank
1. URL: `api/<module_name>/api/ranks`
2. Authorization: None
3. Method: `GET`
4. Params:
5. response: JSON

    ```json
    {
        "error": 0,
        "message": "",
        "data": [
            {
                "role_name": "BăngČTuyết",
                "server_name": "Đằng Vân",
                "counted_rows": 14,
                "appota_userid": 2618078,
                "appota_username": "caongocthu1995"
            },
            ...
        ]
    }
    ```

### Share
#### Post Share
1. URL: `api/<module_name>/share`
2. Headers: `Authorization: Bearer <access_token>`
3. Method: `POST`
4. Params:
   - role_id: integer | required
5. response: JSON

    ```json
    {
        "error": integer,
        "message": string
    }
    ```

#### Get Total Share
1. URL: `api/<module_name>/total-share`
2. Authorization: None
3. Method: `GET`
4. Params:
5. response: JSON

    ```json
    {
        "error": integer,
        "message": string,
        "data": 1
    }
    ```

### For Developer
- Run `docker-compose up`
- Run `docker exec -it api-gamota-landing_php-fpm_1 bash` to access to server.
- Run `chown -R 1000:1000 Modules/` to set permission for Module folder.
