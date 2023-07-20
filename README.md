# Fromagerie-Cauderan Checkpoint 4

## Presentation

Hello everyone,
here is my new project on the theme of developing a website for a cheese dairy.

It's symfony website-skeleton project with some additional library (webpack, fixtures)

* Github Action as Continuous Integration will be run when a branch with active pull request is updated on github.

## Getting Started

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn encore dev` to build assets
4. Run `composer require nelmio/security-bundle`
5. Run `yarn add js-cookie`
6. Run `yarn encore dev`
7. Run `composer require symfony/mailer`
8. Run `composer require vich/uploader-bundle`



### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command:

`git config --global core.autocrlf true`

The `.editorconfig` file in root directory do this for you. You probably need `EditorConfig` extension if your IDE is VSCode.

### Run locally with MySQL

1. Fill DATABASE_URL variable in .env.local file with
   `DATABASE_URL="mysql://root:password@database:3306/<choose_a_db_name>"`
2. Wait a moment, make migration, migration migrate, load fixtures.

## Built With

* [Symfony](https://github.com/symfony/symfony)

## Versioning


## Author
Liquidvision33 - EH

