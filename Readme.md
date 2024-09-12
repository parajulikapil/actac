# ACTAC Development Environment

## Documentation
* CodeIgniter: https://www.codeigniter.com/userguide3

## Prerequisites
* Install PHP version >= 5.6
* Install composer
* Install MAMP or XAMPP or WAMP or LAMP as per your operating system. Take note you can use other services rather than APACHE for example: NGINX or LiteSpeed
* Database MYSQL

# Steps to run project
```Shell
1) Copy this project to your htdocs file (Check on your MAMP or XAMPP or WAMP or LAMP whichever your are using). If you are using Nginx or Litespeed please check their official documentation.
```
```Shell
1) Update database.php file to configure your database
```
* `Step 1` Go to `application > config > database.php` file and
* `Step 2`  Update following details as per your database configuration
<div style="margin-left: 7rem; margin-bottom: 1rem">
	<span style="color: red;">'hostname'='',</span><br />
	<span style="color: red;">'username'='',</span><br />
	<span style="color: red;">'password'='',</span><br />
	<span style="color: red;">'database'='',</span>
</div>

```Shell
2) Update migration_enabled to "TRUE" for migration, if it is set to "FALSE".

Run "php index.php migrate" to run migration
```

```Shell
4) Now run below command to run codeigniter:
"php -S localhost:<YOUR_PREFERED_PORT>" Example: php -S localhost:8000
```

## Challenges Faced while completing this project
* First challenged faced to run the project, it was showing error message into multiple classes. Error sample is shown below:\
	`Message: Creation of dynamic property CI_Router::$uri is deprecated`\
	Solved by adding `#[\AllowDynamicProperties]` on each classes wherever I encountered this issue.
* Second challenged I faced on routing. We create a controller and added function. After registering it into routes.php, I was expecting to work but unfortunately i was getting `404 error message`. Solved this issue by adding `.htaccess` file into root folder.
* Other challenges like Migrartion, Database was solved by checking it's official documentation. Their was no major challenges faced while developing, only few things but was solved by checking it's official documentation.

