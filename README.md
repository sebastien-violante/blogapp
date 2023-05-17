# Project - Blogapp - Symfony 6

## Presentation

**  Blogapp aims to be a platform for exchanging talents and skills without any funding. Its goal is to put two peopBlogapp is a demonstration site that only aims to be a showcase for its designer. Nevertheless, anyone can register and use it, in compliance with the general conditions mentioned. Blogapp is a demonstration site that only aims to be a showcase for its designer. Nevertheless, anyone can register and use it, in compliance with the general conditions mentioned.

**  The site is developed in symfony 6 and PHP 8.1, with some additional libraries (including webpack and other js packages)
 
## Getting Started

### Prerequisites

1. Check composer is installed

### Install

1. Clone this project
2. Run `composer install`
3. Create a file `.env.local` in root (you can make a copy of `.env` file)
4. Configure your database in `.env.local`
5. Configure an SMTP server
6. Create an environment variable `MAIL_BLOG`. It'll the address used to send a mail to the administrator when someone uses the contact form and also used to answer the user. Create another environment variable `MAIL_ADMIN`
which will be the one of the administrator. 


### Working

After having created an database, and indicated its parameters in the `.env.local` :
1. Run the command `symfony console d:d:d --force` and then `symfony console d:d:c` to check if the database is correctly linked
2. Run the command `symfony console d:m:m`
3. Run `symfony server:start` to launch your local php web server


## Versioning

 the Bêta version 1.0 has been deployed in may,2023

## Author

- Sébastien Violante


Remember :

Package for fixtures :
composer require espero-soft/faker

Package to format dates :
composer require espero-soft/dateformat:dev-master

Package to create slug :
composer require cocur/slugify

Symfony package to validate form inputs
composer require symfony/validator

Library Select2, use to choice multiple categories in forms
https://select2.org/

Library to format textarea fileds in forms
https://cdn.ckeditor.com/

Library to display a readmore
https://cdnjs.com/libraries/Readmore.js/2.0.2

Package to use the Twig sort by field
composer require snilius/twig-sort-by-field

Package to custom error pages
composer require symfony/twig-pack

Package to use SMTP mailer Sendgrid
composer require symfony/sendgrid-mailer
composer require sendgrid/sendgrid

