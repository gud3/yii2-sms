Sms sender
==========
The message sender. The package includes sending for service turbosms.

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
            'class' => 'common\components\Sms',
        ],
    ],
];
```

You can then send an sms in queue as follows:

```php
Yii::$app->sms->send('+380*******', 'This is text of test message');
```


