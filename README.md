# Project - Blogapp - Symfony 6

## Presentation

**  Blogapp is a demonstration site that only aims to be a showcase for its designer. Nevertheless, anyone can register and use it, in compliance with the general conditions mentioned.

** The following features are offered according to the user's profile :

    Unregistered user: 
    - consult articles by index or by category (from the navigation bar or on the display page of each article), 
    - search for one or more articles by keyword in the field provided for this purpose in the navigation bar,
    - comment on an article via its display page, 
    - contact the site administrator via a form,
    - consult the general conditions of use of the site.

    Registered user (author) :
    - all the features of the previous profile, except reacting to an article he/she has written himself/herself,
    - write an article,
    - access the list of his articles,
    - modify and delete each of his articles,
    - complete and modify his profile,
    - register, log in and log out of the site,

    Site administrator:
    - all the features of the previous profile,
    - access the list of categories, add and delete a category,
    - access the list of messages left via the form and reply to the message by sending an email.

**  The site is developed in symfony 6 and PHP 8.1, with some additional libraries (including webpack and other js packages)

** To developp this app, I've followed the course made by Espero AKPOLI and avaliable notably on Udemy platform. I've also added several features. Thank's for your further comments !
 
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


Remember (just for further developments)

Package for fixtures :
composer require espero-soft/faker

Package to format dates :
composer require espero-soft/dateformat:dev-master

Package to create slug :
composer require cocur/slugify

Symfony package to validate form inputs :
composer require symfony/validator

Library Select2, use to choice multiple categories in forms :
https://select2.org/

Library to format textarea fields in forms :
https://cdn.ckeditor.com/

Library to display a readmore :
https://cdnjs.com/libraries/Readmore.js/2.0.2

Package to use the Twig sort by field :
composer require snilius/twig-sort-by-field

Package to custom error pages :
composer require symfony/twig-pack

Package to use SMTP mailer Sendgrid :
composer require symfony/sendgrid-mailer
composer require sendgrid/sendgrid

