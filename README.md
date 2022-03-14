# PHP Sandbox
Provides a local tool that allows testing PHP features without any 
restrictions on filesystem, system or network functions that 
online tools such as https://sandbox.onlinephpfunctions.com/ have. 

# Disclaimer
The script is not meant to be ran on a server. This is **not a safe 
sandbox**, you should not run code that you do not trust, the goal 
of this tool is to run PHP snippets to test the features and 
behaviour of PHP.

# Setup

## Apache
Clone this repository in your Apache `www` directory then add the following 
lines to your `httpd-vhosts.conf`. If you're on windows leave it this way
and if you're on linux, replace ${INSTALL_DIR} with the path to the folder 
that contains the `www` folder (usually `/var`) :
```apacheconf
<VirtualHost *:80>  
  ServerName sandbox
  DocumentRoot "${INSTALL_DIR}/www/sandbox/"  
  DirectoryIndex /index.php  

  <Directory "${INSTALL_DIR}/www/sandbox/">  
    Options Indexes FollowSymLinks Includes  
    AllowOverride None  
    Order Allow,Deny  
    Allow from All  
    FallbackResource /public/index.php  
    Require all granted  
  </Directory>  
</VirtualHost>
```

Restart your Apache services and run the following command to load dependencies :
```shell
composer install
```