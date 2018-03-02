shortlink
=========

* Clone this git repository

* Change to the project directory

* Configure your application in app/config/parameters.yml file.

* Insert the required tables to your database: ```php app/console doctrine:schema:update --force```

* Run your application:
    1. Execute the ```php app/console server:start``` command.
    2. Browse to the http://localhost:8000 URL.
