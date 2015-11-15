# Introduction #

On this documentation, we're going to talk about Database support and connection in Samstyle PHP framework. It's easy and scalable to config and deploy.

# Database support #

Currently we only support MySQL due to the fact that MySQL is an open source database and many are using it. In addition, it's a database that most hosting companies would normally have.

# Connection #

To configure your connection, you can open `inc/config.inc.php` with your editor. Look for the following line in the variable `$_SITE`:<br />
`'mysql_info' => array('s'=>'localhost','u'=>'root','p'=>'password','udb'=>'dbapp','connection'=>null)`

The array goes like Server/Host, Username, Password, Default Database, Connection.

What you probably need to change will be the Username, Password and Default Database.

Once that is done, you can simply call SQL queries to your MySQL database from your Samstyle PHP Framework applications.

NOTE: `connection` is the reference to the connection resource created by `mysql_connect()`. There is no need to change the value as it will be handled by the framework.

To speed things up, we use `mysql_connect()` instead of the persistent connection `mysql_pconnect()`.

# Data Access Objects (DAO) #

In Samstyle, we support DAOs and other persistence methods to be used. In fact we recommend that you follow the format of `dao/settings.dao.php`, and call the appropriate functions when needed at your Data Controller.

Classes or libraries of DAO methods are to be placed in the `dao` folder. Then you will need to edit the `$includes` variable of `inc/config.inc.php` to include the dao classes/libraries.