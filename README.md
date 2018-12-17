#Gibbon Mobile

This package is aimed at provision of resposive design for mobiles and tablets for core features of the Gibbon Education programme.

###Version 0.0.01

_**This package is currently in development, and changes made until release may not be backwards compatible.**_

###Installation
####Server Requirements
1.  Apache 2.2/2.4 or Nginx 1.12+
2.  PHP 7.1 or above (with PDO, gettext, CURL. Recommended to turn display_errors off.)
3.  MySQL 5+ or MariaDB 10+ (collation set to utf8_general_ci)
4.  Gibbon 17.0.00+
5.  As you are dealing with sensitive data over an open communication system, I recomment that all communication to Gibbon and Gibbon Mobile be made using https communication protocol (SSL).  This will require a yearly cost for an appropriate security certificate or two.  Speak to your server provider or your ICT support people for how to do this important step. 

####Installation using Composer
Installation is most easily done using composer.  Install composer on your PHP server is relatively easy with [comprehensive Composer instructions](https://getcomposer.org/doc/00-intro.md) available.

Create your directory on your server to hold the Gibbon Mobile Project, then changege to that directory.  The directory should NOT be inside your Gibbon installation.  So you may have a directory structure like:

* var
    * www
        * html
        * gibbon
        
 then you would add another directory called 'mobile' to the www directory.  The thi case the Gibbon Document Root is __/var/www/gibbon__  and the Gibbon Mobile directory would be __/var/www/mobile__ and the Gibbon Mobile document root would be __/var/www/mobile/public__  
The package comes with a .htaccess file in the public directory, so your virtualhost configuration should point your Gibbon Mobile domain name to to the document root of the mobile installation.

* var
    * www
        * html
        * gibbon
        * mobile
        
If your school runs the gibbon software with the school website, then in this example the following would be appropriate expectation of the final result:

| Domain Type          | Host URL                    | Document Root          |
|----------------------|-----------------------------|------------------------|
| School Domain        | http://www.myschool.edu/    | /var/www/html          |
| Gibbon Domain        | http://gibbon.myschool.edu/ | /var/www/gibbon        |
| Gibbon Mobile Domain | http://mobile.myschool.edu/ | /var/www/mobile/public |

Change to your new directory and run the composer require command.  This will install the package for you, complete with all dependencies.

```
cd /var/www

composer create-project crayner/gibbon-mobile <your-mobile-directory> ^0.0.* --stability dev
composer create-project crayner/gibbon-mobile mobile ^0.0.* --stability dev
```
On an apache system, create your sub-domain for Gibbon Mobile by pointing to the mobile document root and you should be ready to go.  If you are using Apache 2.4, ensure that you edit the .htaccess file as per the instructions within the .htaccess file.  If you are using other server technology, then the [Symfony Server Setup Document](https://symfony.com/doc/current/setup/web_server_configuration.html) will be helpful.

The composer installation runs a number of scripts using best guess algorithms to mide