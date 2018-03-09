# Le bon angle

### Github app ###
 
```
https://github.com/HugoSudefou/lebonangleapp
```

## Install ##

```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
 ```
 
 ### Commands ###
 
 ```
 php bin/console doctrine:database:drop --force
 php bin/console server:start
 php bin/console doctrine:fixtures:load --no-interaction
 php bin/console cache:clear [--env=prod]
 ```
 
 ### Json Web Token ###
 
 Generate SSH keys
 ```
 mkdir -p var/jwt
 openssl genrsa -out var/jwt/private.pem -aes256 4096
 openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
 ```
 Don't forget to set 'jwt_key_pass_phrase' in parameters.yml