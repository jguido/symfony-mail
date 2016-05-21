### clone project

### composer install -o

### configure db connection
```
php app/console fos:user:create admin admin admin
php app/console fos:user:promote admin ROLE_ADMIN

php app/console assets:install --symlink

php app/console server:run
```

### access via http://127.0.0.1:8000

### example api send-mail

#### /api/send-mail (POST)

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
