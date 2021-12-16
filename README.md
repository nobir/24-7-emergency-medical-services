# Web Technologies (24/7 Emergency Medical Services)
---

## Group Information
1. Nobir Hossain Samuel ([Github](https://github.com/nobir))
2. Md Mohibor Rahman Rahat ([Github](https://github.com/mohibor))
3. Munem Al Shahrair Sojib ([Github](https://github.com/SHAHRAIRSOJIB))
4. Khuko Moni ([Github](https://github.com/khukomoni))
---

## Supervisor
- Rashidul Hasan Nabil (Sir)


## Technologies
---
### **Markup/Pogramming Language**
- [**HTML** w3schools](https://www.w3schools.com/html/)
- [**CSS** w3schools](https://www.w3schools.com/css/)
- [**Javascript** w3schools](https://www.w3schools.com/js/)
- [**PHP v8.1** w3schools](https://www.w3schools.com/php/)
- [**PHP v8.1** Official](https://www.php.net/manual/en/)
- [**MySQL** w3schools](https://www.w3schools.com/sql/)
### **Library/Framework**
- [**jQuery v3.6.0**](https://jquery.com/) - Javascript
- [**Bootstrap v5.1.3**](https://getbootstrap.com/) - CSS/Javascript
- [**Bootstrap Icons v1.7.0**](https://icons.getbootstrap.com/) - Icons
- [**Darkreader v4.9.40**](https://darkreader.org/) - Javascript

### **Tools**
- [**XAMPP v3.3.0**](https://www.apachefriends.org/index.html) - Local Sever
---

## Installation
1. Create a folder in the `htdocs` folder. Lets say the the folder name is `Project`. Example given in the below
   ```
   C:/xampp/htdocs/Project/
   ```
2. Then pull this project in the `Project` directory
3. If the project is in deeply nested for example `~/xampp/htdocs/WebTech/Final/Project` then  the `APP_NAME` in the `Config.php` file is needed to be configured. Example below.

   Change `$level` vairable value from `0` to `2` to get the parent directory. Because the project is nested 2 level after `WebTech` (created folder) folder.

   ```php
   $level = 2;
   ```
   OR
   ```php
   "APP_NAME" => "WebTech/Final/Project"
   ```

## N.B.
- If the project is not nested after create root folder(`Project`) then step 3 is not needed.
- The `Config.php` file can be found in the `models` directory in the project.