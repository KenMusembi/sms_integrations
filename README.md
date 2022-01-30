# Mojagate SMS API Integration

This is a Laravel integration with the Mojagate SMS API.

## Prerequisite
PHP 8.1.0
Laravel 8.81.0
Composer 2.2.5

## Installation
To start, clone the repository and go the project folder
`git clone https://github.com/KenMusembi/sms_integrations.git`

`cd mojagate`

install composer and all the prooject dependancies
 `composer install` 

generate the laravel key
`php artisan key:generate`

copy env file and setup DB and custom mojagate credentials
`.env.example` to `.env`

run npm for the node packages
`npm`, `npm run dev`

run migrations
`php artisan migrate`

start the application!
`php artisan serve`

go to http://127.0.0.1:8000/register and register as a new user, you will see a table of message transactions, there will be none, so let us send our first message.

## Login to use the send sms api
use a api platform (like postman, here is a link to the collection https://www.getpostman.com/collections/a902c0d1e954d5f726c5), 
go to http://127.0.0.1:8000/api/V1/login in the body, put the credentials in json format:
email:kenmusembi21@gmaill.com
password:12345678

send as post request with the data
```bash
{
    "email":"kenmusembi21@gmail.com",
    "password":"12345678"
}
```

send as a post api and you will get a token which we will use in the next step, so save it.

## Send SMS API
then go to http://127.0.0.1:8000/api/V1/sendsms, which is also a post api.

add the token given in the previous step as Bearer {token} and then indicate the recipient and message in the body segment, like so:
```bash
{
    "recipient":"254748050434",
    "message":"Hello, This is a test SMS"
}
```

You will get a 201 response with a success message!
