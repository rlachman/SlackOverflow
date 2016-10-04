# ODUCS418F16

Fall 2016 ODU CS 418/518
========
This GitHub repository will be the basis for submitting assignments for the Fall 2016 CS418/518 course - Web Programming at Old Dominion University

Instructor: Dr. Justin F. Brunelle [mail](mailto:jfbrunel@odu.edu)

<a href='http://www.cs.odu.edu/~jbrunelle/cs518/'>Course homepage</a>

## Student Project Repositories 
Below are links to students' project repositories for the class based on their submission in <a href="http://www.cs.odu.edu/~jbrunelle/cs518/assignments/assignment1.html">assignment 1</a>. 

* [cs_name](https://github.com/USERNAME) 



## Some useful demo day information

### To be run for each student:

```sh
$ docker run -it -p 80:80 -e MYSQL_PASS="M0n@rch$" -v `pwd`:/app jbrunelle/lamptest
```

### In the instance that the database creation SQL is not provided
 
```sql
CREATE DATABASE IF NOT EXISTS `TheDatabase` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TheDatabase`;
```


### Enable PHP error reporting

```php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
```
