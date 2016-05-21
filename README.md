#Symfony base mail server with administration

## Installation

1. clone project
2. composer install -o
3. configure db connection
4. Build db connection via doctrine commands
5. Create First user
```
php app/console fos:user:create admin admin admin
php app/console fos:user:promote admin ROLE_ADMIN
```
6. Install assets
```
php app/console assets:install --symlink
```

## Access 
1. Run embed php server
```
php app/console server:run
```

2. access via http://127.0.0.1:8000

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
  "config": "config-name",   
  "from": "montest@yahoo.fr",   
  "title": "Hello test",   
  "to": ["dest@mail.com", "dest1@mail.com"],   
  "message": "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
}
```
