# Uživatelský systém

Vstupní test do firmy oXyShop.

Vytvořit databázi uživatelů.

Webový formulář pro registraci.

API pro registraci a zobrazení všech uživatelů.


## Použité technologie

* Apache 2.4.53
* PHP 7.4.28
* Symfony 5.2.14
* MariaDB 10.6.7
* Composer 2.2.10

## Instalace

* Nainstalovat Apache, PHP, Symfony, MariaDB, Composer.
* Naklonovat repozitář do zvolené složky.
* Nainstalovat symfony přes composer.
* Nakonfigurovat soubor .env.
* Nastavit databázi.
    * Vytvořit schéma
    * Pomocí Doctrine vytvořit tabulky
    * Importovat data (sqlData/user.sql)
* Zprovoznit na vybrané složce webserver.
* Otestovat, zda funguje webserver. Např. na adrese http://localhost:8000

## Užitečné příkazy
* symfony check:requirements
* git clone ...
* composer install
* CREATE SCHEMA oxyhomework DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci ;
* php bin/console doctrine:schema:update --force
* symfony server:start
