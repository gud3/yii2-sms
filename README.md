Sms sender
==========
The message sender. The package includes sending for service turbosms, smsapi.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist gud3/yii2-sms "*"
```

or add

```
"gud3/yii2-sms": "*"
```

to the require section of your `composer.json` file.


Usage
-----

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'sms' => [
            'class' => 'gud3\sms\Client',
            'serivce' => 'TurboSms' or 'SMSAPI'
            'name' => 'Display name',
            'login' => 'You login in Sms service',
            'password' => 'You password',
        ],
    ],
];
```

You can then send an sms in queue as follows:

```php
Yii::$app->sms->send('+**********', 'This is text of test message'); // Send message

Yii::$app->sms->getStatus();        // return status send
Yii::$app->sms->getTransactionId(); // return transaction id
Yii::$app->sms->getError();         // if status === false return Text Error
```


