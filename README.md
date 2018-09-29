test string

### Please check out our [contribution guide](CONTRIBUTING.md) before commiting to this project!  
## Code Styling:  
You should follow the Codeigniter 4 Coding Style Guide: https://www.codeigniter.com/user_guide/general/styleguide.html  
Every:  
- Class  
- Function (Method)  
  
Classes should be commented with the following template:
```
/**
 * Class Name
 *
 * @package     Package Name
 * @subpackage  Subpackage
 * @description Description
 * @category    Category
 * @author      Author Name
 */
 ``` 
Functions should be commented with the following template:  
```
/**
 * Description what this function does
 *
 * @param       string  $str    Input string
 * @return      string
 */
```
Variables which aren’t self explainationatory should be commented like this:  
```
/**
 * Contains all data of the user
 *
 * @var array
 */

$data = array(); 
```
## Code Optimization:  
The Code should be speed optimized with an optimized load time faster than 250ms on first (uncached) load on localhost. The script should also allocate max. 5MB Ram per page on loading (with PHP 7 and MariaDB).  
We don’t want any external ressources to be loaded on our website. Therefore its necessary to include any JavaScripts (minified versions), Fonts and other snippets. The only exception is the Google Tracking Code.  
Caching has to be used where possible and usefull.

## Code compliance and readiness
The code must be ready for CDN(Caching rules, http tag readiness), PHP7, Nginx and CI4(PHP7), MariaDB

## Language translation files
The translation files have to be kept clean, unused tags have to be eliminated to avoid unnecessary translation efford.
The translation files must be clearly assigned to the respective page(s).

## Code security
The in CI implemented security checks especially the injection prevention have to be ensured and will be a major part of the code audit.
    
## Test your changes:
You can test the changes on our dev server (which update itself on commit).  
* http://marketplace.oprocon.eu/  
  
Please use the development enviroment in 'index.php':  
`define('ENVIRONMENT', 'development');`  
Otherwise the script won't connect with the right database settings.  
For local testing you can change it back. (Please note that there is a seperate 'developement' folder in the 'config' folder! You have to use that config files if you want to change it on the server.)  
  
## Some Ressources
If u write markdown please check this page first:  
* http://git.oprocon.eu/help/markdown/markdown
  
  
  
  
## How to access the database  (updated 06/2017)
* http://oprocon.eu/phpmyadmin/  
Login: m_marketplace  
Password: QdR7mn34T  
Database: m_marketplace 
