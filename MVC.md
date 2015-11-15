# Introduction #

Samstyle PHP Framework is one of a kind framework that isolates the 3 parts of the [Model-view-controller](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) architectural pattern, yet allowing them to integrate onto each other in a powerful way.

In addition to the MVC architect, we have also added 2 other components to the framework. They are Engine and Core.

The Engine is found at "`inc/head.inc.php`" - a file which every page in the application will be including - where it runs and processes all other files to be included, the headers to be set, MySQL connection and so on.

As for Core, it will be the library of functions and features that are provided in the include folder ("`inc`"). They are `library.inc.php` (contains all pre-defined functions), `cache.inc.php` (provides server-side caching), `dao.inc.php` (provides additional support for DAO persistence functions) and `template.inc.php` (template rendering).

## Model ##

The model as defined in the MVC architecture, is the part where data are processed and manipulated. In Samstyle PHP Framework, we use the idea of [Data Access Object (DAO)](http://en.wikipedia.org/wiki/Data_access_object) or persistence methods to [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete) data from database.

The framework consists of the "dao" folder, which inside should be containing files with persistence fucntions. Files should be named as `*.dao.php` e.g. `settings.dao.php`, `users.dao.php`. All persistence functions in the same file should have a prefix: e.g. In the file `settings.dao.php`, all functions should be prefixed with "`settings_`" like "`settings_Get()`".

At any part of the View and Data controller, you may call the persistence functions as `.dao.php` files are included via `config.inc.php`. If you add a new `.dao.php` file, you will need to update `config.inc.php`.

## View ##

Samstyle PHP Framework features a template management system, which allows you to define templates to every page of the application. You can also define a default template via the configuration file `config.inc.php`.

Templates are in the "templates" folder, where only HTML files are found. You may have multiple template HTML files in the folder. Special tags such as `<$approot$>` are found in these template HTML files. These tags will be replaced with actual data when rendered by `inc/template.inc.php` before writing to output buffer.

For more information about the Templates and tags that can be used, please see [TemplatesDocumentation](http://code.google.com/p/samstyle-php-framework/wiki/TemplatesDocumentation).

This template rendering system removes most repeating/redundant HTML codes from your application PHP pages which makes things clearer and cleaner.

## Control - View Controller and Data Controller ##

The controllers in Samstyle PHP Framework is split into two. One is the view controller, which is responsible for the page content output, and the other is Data Controller, which handles POST data, GET data and other requests. Both controllers works very closely with each other.

### View Controller ###

View Controllers are found on every view page of the application. They are used to control what information is written to the output buffer, which then is shown to the front end where the user can see.

The view controller works closely with View aspect of the MVC - templates. Minimal HTML codes may also be seen at the view controller.

### Data Controller ###

Data Controllers handles POST, GET and other requests and does the appropriate changes to the database. The main data controller can be found at `action.php`, where most CRUD functionality is found. Data Controller may also handle AJAX/AHAH requests and return them the appropriate response (XML or JSON).

Data controllers is seen working very close with the Model aspect of the MVC - DAO and persistence functions. Some data manipulation may also be seen here.