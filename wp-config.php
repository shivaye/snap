<?php

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the

 * installation. You don't have to use the web site, you can

 * copy this file to "wp-config.php" and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * MySQL settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://codex.wordpress.org/Editing_wp-config.php

 *

 * @package WordPress

 */



// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'mixmobile');



/** MySQL database username */

define('DB_USER', 'root');



/** MySQL database password */

define('DB_PASSWORD', '');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8mb4');



/** The Database Collate type. Don't change this if in doubt. */

define('DB_COLLATE', '');



/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         '8%|n3{=D^ga&j^SAdg4:m&?/A@+9(4][*nag>}Z;&1mS-ShpAai,%T2:<:%L<PG)');

define('SECURE_AUTH_KEY',  '.Pw$4vgXM?rEofYe}IebTeHYr QBh:HWFR`ykpamN+Uhc%^9)&Et]^~<Fa7/d)=w');

define('LOGGED_IN_KEY',    'SD0,isDY)lE39er$@U=j|Ecy<x*Wv#)./E%H[wdOaEc|mK1-RRvW&2v3mJz&Fx]l');

define('NONCE_KEY',        'X!UNk 5z^cQva9&wgblXD0lA(cqz=;cYCk=]<&?B@{I,kgBUQN(YR}w0}jJu5^1R');

define('AUTH_SALT',        'm:z*hY=3360X,~x05]({hd-6$(!W8>r,+4&QFbt8SL#@NR9;&`,>Ls}=4tf>Tk67');

define('SECURE_AUTH_SALT', 'I+r,;8~#@}HpnHJV06+1+]t[eD$X41$GREyOMRh.ykuhV,*kdgt-jT|^DO+?vqR~');

define('LOGGED_IN_SALT',   '[+^-5zujM>kp##WmYq=8.yP/@QlV}qnqA*T,8pJ&k#XhfDe8JvNuS[33ytCnjmVN');

define('NONCE_SALT',       'nJ[~c*][ecu%K?RH9GE6?AB4p>g@-P[s9{JN3>hnm2:Sk%BR^h*D4Ui ]RkGjyHe');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress 

 */

define('WP_DEBUG', false);
define('ALLOW_UNFILTERED_UPLOADS', true);
define('WP_MEMORY_LIMIT', '2560M');
define( 'WP_AUTO_UPDATE_CORE', false );

 
/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

set_time_limit(300);

