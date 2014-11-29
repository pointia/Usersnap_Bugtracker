<img src="./usersnap_logo.png" />

# Usersnap Bugtracker
We've created a Usersnap Magento integration with some optional debug information.
It is installed as a Magento module without hacking Magento's core.

## INSTALLATION 

### A) Via Composer - Recommended
Add following code to the composer.json
<pre>
"require": {
        "usersnap/bugtracker": "*",
    },
</pre>

### B) Via Modman (https://github.com/colinmollenhour/modman)

<pre>
cd [magento root folder]
modman init
modman clone https://github.com/pointia/Usersnap_Bugtracker.git
</pre>

 - Make sure you've cleaned Magento's cache to enable the new module; hit refresh

### C) Via Magento Connect
Extension is not updated regularly. I recommend using modman.

<pre>
cd [magento root folder]
sudo ./mage install community Usersnap_Bugtracker
</pre>

### Protected Sites / Usersnap behind Firewall
If you are using a staging setup which is protected using BasicAuth (.htaccess), please grant the Usersnap servers (*.usersnap.com) acccess.

Configuration for Apache
<pre>
Order deny,allow
Deny from all

AuthType Basic
AuthName "Password protected"
Require valid-user
AuthUserFile /path/to/your/.htpasswd

Allow from .usersnap.com
Satisfy Any
</pre>
For further information visit <a href="https://usersnap.com/help/troubleshooting/protected" target="_blank">https://usersnap.com/help/troubleshooting/protected</a>




## FEATURES 
 - Easily report bugs with the Usersnap Bugtracker integration (for more info visit <a href="www.usersnap.com" target="_blank">www.usersnap.com</a>)
 - Connect with 20+ Systems ( E-Mail, Basecamp, Jira, asana, Trello, github, ...)
 - Customizable Feedback Widget (Enable, Tools, Button Text, Widget Position, Required Fields, Language, ...)
 - Useful Magento Debug Information
    - Written as Event Observer (Event: usersnap_debug_info, Object: "debug_info") thus you can write your own code and deactivate default info in the local.xml
    - Magento Version + Module Versions (Useful for different Environments)
    - Store Information
    - Controller Information
    - Cookie Information
    - Layout Handles
    - Design Information
    - Customer Information
    - Session Information (disabled by default)
    - Quote Information (incl. Quote Items, price, currency, address, ...)
    - Wishlist Information