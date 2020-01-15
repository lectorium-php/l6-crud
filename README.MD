#Lectorium project  
  
## Installation  
- setup composer deps:  
```
composer install
```
- setup fixtures:
```
bin/console hautelook:fixtures:load
```
- setup test db fixtures:
```
bin/console t:f:l -e test -f
```