http://www.phpunit.cn/manual/current/zh_cn/installation.html#installation.composer
https://phpunit.de/manual/current/en/installation.html#installation.phar

```
$ wget https://phar.phpunit.de/phpunit-6.5.phar
$ chmod +x phpunit-6.5.phar
$ sudo mv phpunit-6.5.phar /usr/local/bin/phpunit
$ phpunit --version
```

### 执行
```
[www@localhost phpunit]$ phpunit --bootstrap src/Email.php tests/EmailTest
PHPUnit 6.5.7 by Sebastian Bergmann and contributors.

..E                                                                 3 / 3 (100%)

Time: 73 ms, Memory: 10.00MB

There was 1 error:

1) EmailTest::testCanBeUsedAsString
InvalidArgumentException: "user@example" is not a valid email address

/windows/www/mytest/function/phpunit/src/Email.php:28
/windows/www/mytest/function/phpunit/src/Email.php:10
/windows/www/mytest/function/phpunit/src/Email.php:17
/windows/www/mytest/function/phpunit/tests/EmailTest.php:30

ERRORS!
Tests: 3, Assertions: 2, Errors: 1.

```
