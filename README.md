#Gibbon Mobile

This package is aimed at provision of resposive design for mobiles and tablets for core features of the Gibbon Education programme.

###Version
0.0.0 Development

###Installation
Installation is most easily done using composer.  Install composer on your PHP server is relatively easy with [comprehensive instructions](https://getcomposer.org/doc/00-intro.md) available.

Create your directory on your server to hold the Gibbon Mobile Project, then changege to that directory.  The directory should NOT be inside your Gibbon installation.  So you may have a directory structure like:

* var
    * www
        * html
        * gibbon
        
 then you would add another directory called 'mobile' to the www directory.  The thi case the Gibbon Document Root is __/var/www/gibbon__  and the Gibbon Mobile directory would be __/var/www/mobile__ and the Gibbon Mobile document root would be __/var/www/mobile/public__

* var
    * www
        * html
        * gibbon
        * mobile
        
Change to your new directory and run the composer require command.  This will install the package for you.

```
cd /var/www/mobile

composer require crayner/gibbon-mobile
```

