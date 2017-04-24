Sms sender
==========

The message sender. The package includes sending for service TurboSMS, SmsAPI.

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
            'sender' => 'Display name',
            'service' => [
                'class' => 'gud3\sms\Services\SmsApi', // or TurboSms
                'login' => '***',
                'password' => '***',
            ],
        ],
    ],
];
```

You can then send an sms in queue as follows:

```php
Yii::$app->sms->send('+**********', 'This is text of test message');
Yii::$app->sms->send(['+**********', '+**********'], 'This is text of test message');
```


