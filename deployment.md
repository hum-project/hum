# Deployment
The API backend is located on a subdomain. But before 
deploying there are a couple of tasks that needs to be 
done.

## Prepare Symfony for deployment
### Clone project
Clone the project to a local project.
`` git clone https://github.com/hum-project/hum.git ``

### Adjust configurations
Adjust environment variable in .env to be dev:
``
APP_ENV=prod
``

Adjust .env.local to hold the correct SMTP credentials: 
``
MAILER_DSN=smtp://mail@example.com:password@protocol-host.example.com:1234
``

Then run composer in the project folder:  
```
composer install --no-dev --optimize-autoloader
```

*Since we have symfony/dotenv dependency as a required dependency 
there's no need for modifying it's require. We will be able 
to use .env.local on production.*

#### Edit composer.json
Add instructions for Symfony of which directory to treat as the index directory: 
```
"extra": {
        "public-dir": "httpd.www"
}
```
#### Edit index.php
Since the code base is split up, we need to instruct Symfony of where it can find its instructions. Add the following to the top of the index.php-file: 
```
require dirname(__DIR__).'/httpd.private/config/bootstrap.php';
```

### Create .htaccess 
The purpose of editing .htaccess and provide it to the host server is so it can interpret routes in a smooth manner. That way each request can omit the [domain]/index.php/[subdomain]: 

```
<IfModule mod_rewrite.c>
    Options +FollowSymlinks
    RewriteEngine On

    # Explicitly disable rewriting for front controllers
    RewriteRule ^index_dev.php - [L]
    RewriteRule ^index.php - [L]

    RewriteCond %{REQUEST_FILENAME} !-f

    RewriteRule ^(.*)$ /index.php [QSA,L]
</IfModule>
```

## Prod database
### Initial task
If no database exists, create it: At the host create 
a MariaDB database. Remember the credentials.

### Configure .env.local
Add the database credentials to the .env.local file.
```
DATABASE_URL=mysql://[db-name]:[db-password]@[domain].mysql/[db-name]$
```

### Add Schema to database
**Prerequisite:** 
* Project is in production. 
* SSH is set up with host.

The database needs to be modified for the entities. 
SSH in to prodction with PuTTY. Then use Doctrine scripts:
```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Move Project to Production
**Prerequisite:** 
* SSH protocol.
* SFTP application: *FileZilla*. 

Use SFTP and move the project to production. 


Move files to different filepaths. 
origin | destination
--- | ---
/public/* | httpd.www/
/composer.json | httpd.www/
/.htaccess | httpd.www/
/.env | httpd.private/
/bin | httpd.private/
/config | httpd.private/
/src | httpd.private/
/vendor | httpd.private/
/templates | httpd.private/
/var | httpd.private/
