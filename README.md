[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e7dda513-1373-4096-abbd-58f012fabffb/big.png)](https://insight.sensiolabs.com/projects/e7dda513-1373-4096-abbd-58f012fabffb)
#Symfony base mail server with administration

## Installation

* clone project
* composer install -o
* configure db connection
* Build db connection via doctrine commands
* Create First user
```
php app/console fos:user:create admin admin admin
php app/console fos:user:promote admin ROLE_ADMIN
```
* Install assets
```
php app/console assets:install --symlink
```

## Access 
* Run embed php server
```
php app/console server:run
```

* access via http://127.0.0.1:8000

## Example
### example api send-mail

* /api/send-mail (POST)

### Header
```
header  
    apikey: {apikey of the user}, 
    Content-Type: application/json
```
### Body
```
body
{
  
    "config"     : $mailConfig->getName().'321',
    "user"       : $user->getEmail(),
    "title"      : "Hello test",
    "recipients" : ["test@mailsersymfony.gt"],
    "lang"       : "fr",
    "view"       : "test",
    "reportTo"   : "report@mailsersymfony.gt"
}
```
### example api send-body-mail

* /send-body-mail (POST)

### Header
```
header  
    apikey: {apikey of the user}, 
    Content-Type: application/json
```
### Body
```
body
{
    "config"     : $mailConfig->getName().'321',
    "user"       : $user->getEmail(),
    "title"      : "Hello test",
    "recipients" : ["dest@mail.com", "dest1@mail.com"],
    "lang"       : "fr",
    "reportTo"   : "report@mailsersymfony.gt",
    "message": "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
}
```
