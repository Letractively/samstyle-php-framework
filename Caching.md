# Introduction #
In Samstyle PHP Framework, we provide a  set of functions for caching of contents. Caching is important as part of web development as it speeds up the loading. We don't need to load fresh content each time we load it. Therefore we load once, and save the result.

# Requirements #

You will need to set permissions to allow PHP to delete, create, read write to the `cache` folder in the application root.

# Functions #

Caching functions are found in the include only file `inc/cache.inc.php`.

| **Function** | **arguments** | **description** |
|:-------------|:--------------|:----------------|
| cache\_retrieve | $id, $time    | retrieves the cache data from the file of the $id and returns an array |
| cache\_query | $id, $time    | returns a boolean whether the cache is available |
| cache\_clearout | $time         | deletes all cache files older than $time - useful for maintenance |
| cache\_save  | $id, $data    | saves $data into cache. $data is an array |

$id is an identifier of any string, which you can use to retrieve and save the cache. $time is the time in seconds.

# Notes #
When saving the data, the data is actually converted into a JSON string and then stored into the file. When retrieving, the JSON string is then converted back into a PHP array.