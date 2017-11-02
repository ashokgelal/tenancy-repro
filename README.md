## Tenancy Bug Repro

Steps:
1. `composer install`
2. `bash vessel init`
3. `./vessel start`
4. Set proper privileges for user homestead (either using Sequel Pro or command line). For this project you can just grant all Global Privileges and all Scheme Privileges.
5. `./vessel artisan tenancy:install` to run the migrations
6. Create a new tenant using command line: `./vessel artisan tenant:create test` 