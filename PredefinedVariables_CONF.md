Back to [PredefinedVariables](PredefinedVariables.md).

# Introduction #

This article documents the `$_CONF` predefined variable of the Samstyle PHP Framework.

# Reason for `$_CONF` #

In current web development context, we no longer work along. We bring in APIs such as Google Maps, Facebook Connect, OpenID and so on to enhance our users' experience on our website. However, there should be a place to consolidate all configuration information related to these 3rd party add-ons, such as API key.

Thus we have this `$_CONF` variable to serve this purpose.

# Example #

```
$_CONF['fb_api'] = array(
   'key'=>'39ab360839e0c5b858c69da01060e25',
   'secret'=>'39ab360839e0c5b858c69da01060e25'
);
```