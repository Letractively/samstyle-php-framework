<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Binary Digit (bit) Worker/Helper
*  Created by: Sam Yong | Date/Time: 12:25pm 19th July 2009 GMT+8
*
**************************************************** */


class bit{

/*   Because of a bug in PHP we need this init function,
 *   it's a workaround for the bug. If you want to know if
 *   this bug has been fixed, check bugs.php.net, bugid: 3176
 *   So, best is to use this simple init every time you
 *   create a new bitfield variable. */

function init(&$bf){$bf = ($bf| 0);}

/* Return true or false, depending on if the bit is set */
function query_bit($bf,$bit){return ($bitfield&$bit);}

/* Force a specific bit(pattern) to ON */
function set_bit(&$bitfield,$bit){$bitfield |= $bit;}

/* Force a specific bit(pattern) to be OFF */
function remove_bit(&$bitfield,$bit){$bitfield &= ~$bit;}

/* Toggle a bit(pattern), so bits that are on are turned off, and bits that are off are turned on. */
function toggle_bit(&$bitfield,$bit){$bitfield ^= $bit;}

}


?>
