

<h1 align="center"> 
🔲 Click-Journey 🔳
</h1>
</p>
<p align="center"> 
  <a href="https://github.com/deltahmed/Click-Journey">
    <img src="https://img.shields.io/github/contributors/deltahmed/Click-Journey.svg?style=for-the-badge" alt="Contributors" /> </a>
  <a href="https://github.com/deltahmed/Click-Journey">
    <img alt="Issues" src="https://img.shields.io/github/issues/deltahmed/Click-Journey?style=for-the-badge">
    </a>
  <a href="https://github.com/deltahmed/Click-Journey">
    <img alt="Forks" src="https://img.shields.io/github/forks/deltahmed/Click-Journey.svg?style=for-the-badge"></a>
  <a href="https://github.com/deltahmed/Click-Journey">
    <img alt="Stars" src="https://img.shields.io/github/stars/deltahmed/Click-Journey.svg?style=for-the-badge"></a>
  <a href="https://raw.githubusercontent.com/deltahmed/Click-Journey/master/LICENSE">
    <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="License" /> </a>
</p>


## Table of Contents

* [About The Project](#about-the-project)
  * [Built With](#built-with)
* [Installation and usage](#installation-and-usage)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation-and-usage)
  * [Usage](#usage)
* [Contributors](#contributors)
* [License](#license)

## About The Project

**Click-Journey: Beyond Survival** is a travel agency website specializing in pre-configured trips. The goal is to offer an immersive and ergonomic interface allowing users to explore and book trips while customizing certain options (accommodation, activities, transportation, etc.).

### Built With

![HTML5](https://img.shields.io/badge/-HTML5-05122A?style=for-the-badge&logo=html5)
![CSS3](https://img.shields.io/badge/-CSS3-05122A?style=for-the-badge&logo=css3)
![PHP](https://img.shields.io/badge/-PHP-05122A?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/-MySQL-05122A?style=for-the-badge&logo=mysql)


## Installation and usage

### Prerequisites
+ XAMPP installed on your machine or a similar alternative
+ PHP and MySQL (MariaDB) included in XAMPP (**THE LAST VERSION**)
    + Version details :
      + PHP : 8.2.12
      + Server : 10.4.32-MariaDB
      + DataBase Name : `clickjourney`
      + XAMPP Control Panel v3.3.0

### Installation

1. **Download and install XAMPP**
    + Download XAMPP from the official website and install it.
    + Open the XAMPP control panel and start Apache and MySQL.

2. **Database configuration**
    + Open your browser and go to `http://localhost/phpmyadmin/`.
    + Create a new database named `clickjourney`.
    + Import the `database/clickjourney.sql` file (provided in the project) by going to the Import tab in phpMyAdmin.

3. **Project setup**
    + Place your project in the htdocs directory of XAMPP  (`C:\xampp\htdocs\Click-journeY`).
    + Check and modify the database connection settings in the `includes/config.php` file if necessary (if your database is not named `clickjourney`)

### Usage
1. **Starting the server**
    + Start Apache and MySQL via the XAMPP control panel.
    + Open a browser and go to http://localhost/Click-journeY/.

2. **Main Features**

    + User registration and login

    + Session management with PHP

    + Displaying data from the database

    + Other project-specific features

3.  **Frequent errors**
    + If a database connection error occurs, check `includes/config.php`.
    + Ensure MySQL is running in XAMPP.
    + Check file permissions if access issues arise.

4.  **Test accounts**
    
    Here are some accounts to test the site's features without signing up.

    | Email                         | Password                                  | role  |
    | ----------------------------- | ----------------------------------------- | ----- |
    | contact.ahmed.delta@gmail.com | ClickJourney3,14159265358979323846264@#&$ | admin |
    | remi.soule@exemple.com        | C2%OIOIOIoioioi                           | user  |
    | abdelwaheb.azifrr@exemple.com | &&&92!$#!ElMorjen@@FAVEEEEEE              | user  |
    | sergy.manchouc@exemple.com    | Chapka30000Sergy!@                        | admin |
    | ayane.lmhani@exemple.com      | MotDePasseSécurisé123!!!                  | user  |
    | anas.chapati@exemple.com      | bsissaELchapati@&!!!2025                  | user  |


## Contributors

<a href="https://github.com/deltahmed/Click-journeY/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=deltahmed/Click-journeY" />
</a>


## License

[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](https://raw.githubusercontent.com/deltahmed/Click-Journey/master/LICENSE)


