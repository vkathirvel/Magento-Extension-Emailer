# Easy Emailer Class for Magento Developers

Magento developers! Are you looking for an easy class / function to send emails through Magento's transactional email system? This Magento emailer class will come handy.

[![Donate](https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YNKF9CGE3V5HJ)

## 1. Installation

1. Get the Magento Connect extension key and install it through Magento Connect (recommended)
2. Download the app folder from GitHub and upload it to your Magento root folder

### PLEASE NOTE

* **Backup Magento's files and database.** It is best practice to backup the database and files, just in case something goes wrong and you need to rollback. Always try the module on a development site and deploy to a live site only after you have fully tested it.

* **Disable Compilation.** Magento's compilation feature is wonderful! However, it needs to be switched off before installing new modules. If you forget to do so, use the command line to recompile. http://www.kathirvel.com/magento-compile-clear-enable-and-disable-compilation-via-ssh/

* **Getting a 404 error.** As with the installation of all Magento modules, please clear the cache folders before and after module installation. Log out of the Admin area and log back in. Please also flush your CSS and JS caches.

This module has been tested and big fixed to the best possible extent. Let us know if you come across any problems or issues and we will endeavour to fix it in an upcoming release.

## 2. Usage

The function / helper to send transactional emails can be called from anywhere within Magento. You can even use this function in your custom modules.

```php
$emailData = array(
    'senderName' => 'Store Owner Name',
    'senderEmail' => 'StoreOwnerEmail@email.com',
    'recipientName' => 'Visitor Name',
    'recipientEmail' => 'VisitorEmail@email.com',
    'replyTo' => 'StoreOwnerEmailReplyTo@email.com',
    'cc' => 'StoreOwnerEmailCc@email.com',
    'bcc' => 'StoreOwnerEmailBcc@email.com',
    'subject' => 'Information Request',
    'variables' => array('visitor_name' => 'John Doe', 'visitor_email' => 'john.doe@gmail.com', 'message' => 'A long paragraph'),
    'attachments' => array(
        array('content' => 'Some text', 'mime' => 'text/plain', 'filename' => 'Attachment.txt')
    ),
    'templateId' => 1
);

Mage::helper('emailer')->sendmail($emailData);
```

The above Magento email helper function returns TRUE if the email is sent OK or throws an exception if the email didn't go through OK.

### Defaults

You do not have to provide all the array keys. Following are the default values

* 'senderName' => 'REQUIRED'
* 'senderEmail' => 'REQUIRED'
* 'recipientName' => 'Defaults to recipientEmail'
* 'recipientEmail' => 'REQUIRED'
* 'replyTo' => 'Defaults to NULL'
* 'cc' => 'Defaults to NULL' // multiple emails - array('John Doe 1' => 'user1@email.com', 'John Doe 2' => 'user2@email.com')
* 'bcc' => 'Defaults to NULL' // multiple emails - array('user1@email.com', 'user2@email.com')
* 'subject' => 'Defaults to NULL' // subject from the transactional email template will be used
* 'variables' => 'Defaults to NULL' // array - called as {{ var array_key }} within the email template. Use {{ var array.array_key }} for multi dimensional arrays
* 'attachments' => 'Defaults to NULL'
* 'templateId' => 'Defaults to Magento's core contact form template' // number - provide the ID of the transactional email template from System >> Transactional Emails

### Compatibility / Known Issues

* This emailer class has been tested to use standard PHP sendmail, ASchroder SMTP Pro and ebizmarts Mandrill
* CC emails do not work (BCC works) when using ebizmarts Mandrill