# PHPfox Developers Build

## License
This build is intended for developers working with creating apps, modules, themes and language packages for [PHPfox](http://www.phpfox.com/).

We permit the usage of our developers build on a localhost web server without public access to the server.

For a commercial license, visit [PHPfox](http://www.phpfox.com/).

## Requirements
* PHP >= 5.4
* PHP GD
* PHP XML

## Install Instructions

Access your web server via SSH and clone it from Git (if you do not have git, skip this step and just download the ZIP).
```
git clone https://github.com/moxi9/phpfox.git .
```

Give **write** access to the following 2 folders.
```
chmod 0777 PF.Base/
```
```
chmod 0777 PF.Site/
```

Go into the directory...
```
cd PF.Base
```
then run
```
curl -sS https://getcomposer.org/installer | php
```

Now, that you have composer installed, install the products dependencies.
```
php composer.phar install
```

Once all the dependencies have been installed, open up your favorite web browser and fire up the web installer.

The first step will ask for your client details. As a techie, developing themes, apps or language packages you can assign enter **"techie"** (without quotes) for both the **License ID** and **License Key**

![phpfox_installer_-_2015-04-08_16 29 08](https://cloud.githubusercontent.com/assets/6339284/7047407/9daa9272-de0c-11e4-9b46-f58354063d5a.png)


Next, you will need to enter your database details.

![phpfox_installer_-_2015-04-08_16 28 50](https://cloud.githubusercontent.com/assets/6339284/7047425/bfa4a94e-de0c-11e4-8b91-461eff8eb932.png)


Once all the details have been entered correctly the install will setup the database tables and install all the required apps.

Your final step will be to setup your Admin account.

![phpfox_installer_-_2015-04-08_16 36 00](https://cloud.githubusercontent.com/assets/6339284/7047535/6863fefe-de0d-11e4-832f-0b1f4782e5b7.png)

Done!

Feel free to report any issues you find [here](https://github.com/moxi9/phpfox/issues).

