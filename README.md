# SensioEvents - Demo Application

This application is meant to be used as a base for SensioLabs Symfony trainings.

## Installation

1. Clone this repository
2. Create a `.env.local` file with the following content:
   1. `DATABASE_URL="<the DSN matching your database>"`
   2. `CONF_API_KEY="zcRmw9ZWDwtq5N5RQMhgJEdpBP+2aQB/IR2oN5IJ3JYaLqHbaQh41yeC"`
3. Run the following commands:
   1. `symfony composer install`
   2. `symfony console doctrine:database:create`
   3. `symfony console doctrine:migrations:migrate -n`
   4. `symfony console doctrine:fixtures:load -n`
4. You should be able to browse the application by running `symfony serve -d`

_Note: do not use the `-d` option in the last command if you are using Windows_

## Application scope

This applications emulates a volunteering platform to help conference organizers find staff.
It allows:
* User registration/login
* Conference CRUD operations
* Completing Conference database with results from an external API
* Volunteering on conferences
* Generic contact form for the website administration

Some test users are defined in the fixtures. Do not hesitate to look into the `src/DataFixtures/UserFixtures.php` file
for their credentials in order to use them on the application.
