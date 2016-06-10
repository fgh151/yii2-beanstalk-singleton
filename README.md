Yii2 beanstalk singleton trait
==============================
Trait for only one instance of beanstalk worker

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist fgh151/yii2-beanstalk-singleton "*"
```

or add

```
"fgh151/yii2-beanstalk-singleton": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, add trait to beanstalk controller

```php

class TestController extends udokmeci\yii2beanstalk\BeanstalkController
{
    use fgh151\beanstalk\Singleton;
    
}

```

Now you have additional commands:

```bash
./yii test/status
```
it will print pid of current process or "Not active" if worker not run

```bash
./yii test/halt
```
it will halt current worker