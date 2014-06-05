About
=============
This module can enable HTTP-caching for specific controllers. It is intended for the usage behind an reverse proxy
like Squid or Varnish.

This module can not enable caching for assets like CSS-files or images (see section below).

Requirements
=============
OXID eShop 4.7 and above. All editions are supported.

Installation
=============
As Git Submodule (recommended)
-------------
Go to your shop root-directory and add a new submodule:

    git submodule add git://github.com/maximilian-walter/oxid-cache.git modules/mw/cache

Add the file "mw/vendormetadata.php" if it doesn't exist already with the following content:

    $sVendorMetadataVersion = '1.1';

Manual
-------------
Download the complete repository as ZIP-archive and extract it to the new directory "mw/cache" in the
modules-directory.

Add the file "mw/vendormetadata.php" if it doesn't exist already with the following content:

    $sVendorMetadataVersion = '1.1';

Usage
=============
Before you can use the editor you have to enable it in the backend. Go to "Extensions" -> "Modules" and enable "Cache".
You can configure all cacheable controllers and the TTL in seconds in the settings-tab of the module. Example:

    info => 3600
    start => 3600
    details => 3600
    alist => 3600
    vendorlist => 3600

Caching for Assets
=============
This module can not enable caching for assets like CSS-files or images. You have to enable it by yourself. If you use
Apache you can enable the mod_expires-module and enable caching in the server-configuration or an .htaccess like so:

    <IfModule mod_expires.c>
      ExpiresActive On

      <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css|swf)$">
        ExpiresDefault "access plus 1 month"
      </FilesMatch>
    </IfModule>

License
=============
The MIT License (MIT)

http://opensource.org/licenses/MIT