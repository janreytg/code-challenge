
# PHP test

## 1. Installation (A or B)
  A. Dockerize 
  - Install docker desktop
  - RUN docker compose / docker-compose up -d --build in repository root
  - RUN docker exec -it customer-ws-app sh (remote the container), then run COMPOSER INTALL
  - RUN php artisan doctrine:schema:update --force
  - RUN php artisan app:customer-importer

  B. Native Laravel
  - RUN composer install
  - RUN php artisan doctrine:schema:update --force
  - RUN php artisan app:customer-importer
  - RUN php artisan serve

## 2. Expectations
  **Data Importer**
  - Fetch and store a minimum of 100 users from this data provider: https://randomuser.me/api. See official documentation for fetching multiple users API Documentation
  - The user data retrieved from the data provider must be stored in a SQL Type database and must be called customers table.
  - Only import customers that have the Australian nationality, Refer to API Documentation.
    ### This can be edited in .env AU, PH, FR, etc. in DATA_IMPORTER_DEFAULT_FILTER=AU
  - The importer service should be constructed in a way that it can be used in any part of the Application -Services or Controllers such as API controllers, Command, Job, etc.
    ### DataImporter is created in service
  - The importer should be designed so the data provider could be replaced later with minimal impact on the codebase.
  - Create a console command to be able to execute the importer.
    ### RUN php artisan app:customer-importer

  **Note**
  - The database MUST only store the information that is needed for this task.
    ### only fields that are in response are collected.
  - The customer’s clear password from the 3rd party API MUST be hashed using the md5 algorithm. DO NOT use the already hashed value from the API.
    ### encrypted md5 in buildData() method
  - Importer logic MUST be reusable in different parts of the application without any code changes in the importer itself.
    ### configs are editable in .env all with prefix DATA_IMPORTER_*
  - Tests MUST make sure to not request the real third party API.
    ### used Mocked
  - Tests MUST validate response structure.
    ### check json structure
  - Tests MUST have both positive and negative outcomes.
  - Config files MUST be utilized for values that might change in case of requirements changes
    ### configs are editable in .env all with prefix DATA_IMPORTER_*
  - Code logic MUST be decoupled following single responsibility principle
  - Code MUST only contain necessary files or classes. Boilerplate code must be removed.
  - Code MUST be submitted in a GitHub repository
    ### done!

## 3. Execution

  **API:**
  - GET: {{host}}/api/v1/customers/
  - GET: {{host}}/api/v1/customers/{{customerId}}
    
  **PHPUnit Testing (TDD)**
  
    - RUN php artisan test
