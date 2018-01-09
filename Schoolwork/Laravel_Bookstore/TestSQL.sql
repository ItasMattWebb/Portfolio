CREATE USER 'bookuser'@'localhost' IDENTIFIED BY 'bookpass';
GRANT ALL PRIVILEGES 
   ON `bookdb`.* 
   TO 'bookuser'@'%';
Flush Privileges;