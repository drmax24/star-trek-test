## Introduction
Hello. Thank you for the opportunity to solve this task. It was much simpler than I expected. I thought I will have to write a real language translator.
I can make this kind of tasks in 4 hours if we exclude tests and documentation.

## Installation
You will need to have php 7.1 to run this.

Repository: https://github.com/drmax24/star-trek-test

1. ```git clone https://github.com/drmax24/star-trek-test.git```

2. ```composer install```

If you don't have a composer you will need to install it first. Here are instructions:
https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx


## Running the application
### Basic example
```php artisan star-trek:get-character Uhura```  

Use quotes if you need to pass a name containing whitespaces.

### --strict-transliteration
>>Some letters are missing which means they are not translatable for this test purposes, then ignore the whole input.

If you want to get error on missing symbols use --strict-transliteration flag. You will get non 0 cli status:  
```php artisan star-trek:get-character --strict-transliteration "Pavel Chekov"```

Will delete unknown characters before processing  
```php artisan star-trek:get-character "Pavel Chekov"```

### --debug-stapi
Use this flag to get whole character in the result. Used this for testing  

## Unit tests
I wrote a test that checks several CLI calls.  
Run:  
```./vendor/bin/phpunit```   
To execute it.

Test file path:   
```tests/Feature/GetCharacterTest.php```


## Code structure
Code that handles CLI call
```app/Console/Commands/GetCharacterCommand.php```

KlingonTranslation and Stapi have separate Service classes to solve their specific tasks.
```app/Services/KlingonTranslationService.php```
```app/Services/StapiService.php```

## PS:
The task was interresting! Among other things it also checks attention and an ability to understand the problem correctly I suppose.