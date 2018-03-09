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