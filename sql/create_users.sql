# noinspection SqlResolveForFile

use viravira;


# Create Privilege statements
CREATE USER 'deletion'@'localhost' IDENTIFIED WITH mysql_native_password BY 'L&u06@BkL99u';
SELECT CONCAT("GRANT DELETE ON viravira.", TABLE_NAME, " TO 'deletion'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';
SELECT CONCAT("GRANT SELECT ON viravira.", TABLE_NAME, " TO 'deletion'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';

# Generated from statement above
GRANT DELETE ON viravira.excursion TO 'deletion'@'localhost';
GRANT DELETE ON viravira.excursion_description TO 'deletion'@'localhost';
GRANT DELETE ON viravira.excursion_detail TO 'deletion'@'localhost';
GRANT DELETE ON viravira.excursion_image TO 'deletion'@'localhost';
GRANT DELETE ON viravira.question TO 'deletion'@'localhost';
GRANT SELECT ON viravira.excursion TO 'deletion'@'localhost';
GRANT SELECT ON viravira.excursion_description TO 'deletion'@'localhost';
GRANT SELECT ON viravira.excursion_detail TO 'deletion'@'localhost';
GRANT SELECT ON viravira.excursion_image TO 'deletion'@'localhost';
GRANT SELECT ON viravira.question TO 'deletion'@'localhost';


# Create Privilege statements
CREATE USER 'insertion'@'localhost' IDENTIFIED WITH mysql_native_password BY 'FH75&iW**%oL';
SELECT CONCAT("GRANT INSERT ON viravira.", TABLE_NAME, " TO 'insertion'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';
SELECT CONCAT("GRANT SELECT ON viravira.", TABLE_NAME, " TO 'insertion'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';

# Generated from statement above
GRANT INSERT ON viravira.excursion TO 'insertion'@'localhost';
GRANT INSERT ON viravira.excursion_description TO 'insertion'@'localhost';
GRANT INSERT ON viravira.excursion_detail TO 'insertion'@'localhost';
GRANT INSERT ON viravira.excursion_image TO 'insertion'@'localhost';
GRANT INSERT ON viravira.question TO 'insertion'@'localhost';
GRANT SELECT ON viravira.excursion TO 'insertion'@'localhost';
GRANT SELECT ON viravira.excursion_description TO 'insertion'@'localhost';
GRANT SELECT ON viravira.excursion_detail TO 'insertion'@'localhost';
GRANT SELECT ON viravira.excursion_image TO 'insertion'@'localhost';
GRANT SELECT ON viravira.question TO 'insertion'@'localhost';


# Create Privilege statements
CREATE USER 'selection'@'localhost' IDENTIFIED WITH mysql_native_password BY '9Fb6%!T3hS$d';
SELECT CONCAT("GRANT SELECT ON viravira.", TABLE_NAME, " TO 'selection'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';

# Generated from statement above
GRANT SELECT ON viravira.excursion TO 'selection'@'localhost';
GRANT SELECT ON viravira.excursion_description TO 'selection'@'localhost';
GRANT SELECT ON viravira.excursion_detail TO 'selection'@'localhost';
GRANT SELECT ON viravira.excursion_image TO 'selection'@'localhost';
GRANT SELECT ON viravira.question TO 'selection'@'localhost';


# Create Privilege statements
CREATE USER 'update'@'localhost' IDENTIFIED WITH mysql_native_password BY '6SbQ*4sG#A6x';
SELECT CONCAT("GRANT UPDATE ON viravira.", TABLE_NAME, " TO 'update'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';
SELECT CONCAT("GRANT SELECT ON viravira.", TABLE_NAME, " TO 'update'@'localhost';")
FROM information_schema.TABLES
WHERE TABLE_SCHEMA LIKE 'viravira'
  AND TABLE_NAME NOT LIKE 'account';

# Generated from statement above
GRANT UPDATE ON viravira.excursion TO 'update'@'localhost';
GRANT UPDATE ON viravira.excursion_description TO 'update'@'localhost';
GRANT UPDATE ON viravira.excursion_detail TO 'update'@'localhost';
GRANT UPDATE ON viravira.excursion_image TO 'update'@'localhost';
GRANT UPDATE ON viravira.question TO 'update'@'localhost';
GRANT SELECT ON viravira.excursion TO 'update'@'localhost';
GRANT SELECT ON viravira.excursion_description TO 'update'@'localhost';
GRANT SELECT ON viravira.excursion_detail TO 'update'@'localhost';
GRANT SELECT ON viravira.excursion_image TO 'update'@'localhost';
GRANT SELECT ON viravira.question TO 'update'@'localhost';


CREATE USER 'auth'@'localhost' IDENTIFIED WITH mysql_native_password BY '^m3FrV2lqfll';
GRANT SELECT ON viravira.account TO 'auth'@'localhost';


FLUSH PRIVILEGES;


SHOW GRANTS FOR 'deletion'@'localhost';
SHOW GRANTS FOR 'insertion'@'localhost';
SHOW GRANTS FOR 'selection'@'localhost';
SHOW GRANTS FOR 'update'@'localhost';
SHOW GRANTS FOR 'auth'@'localhost';
