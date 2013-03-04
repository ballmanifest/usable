<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'thecloud');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '2#dbP`94NNEbUy3{RpP-Al(<b@9weIkb=q;{T^;od|fL.N]{1V*mjvq.uf<(R>/0');
define('SECURE_AUTH_KEY',  'GMq5g9a.#Z-3MZC$-+p/821xx{8w!)`J|(@fu;OgPw5ZnV0aHla^YE$[c-C=-z(S');
define('LOGGED_IN_KEY',    'Vz5LjrPNX~/iOTr.0H|UX}tpp8 (o73_@4Q_(%+}@c1irsVP,m&v_/b9NIv$CqC1');
define('NONCE_KEY',        ',(?|k=4sfu_KM<eLZZ@/,J<UEo82&IQ_c*Q~A*OE_5[OO|F4|H6)os{uo<wt*trD');
define('AUTH_SALT',        'C%.2c-A1-R:,2yZoG1$#3j>H(?Kc?ap3tu+3m6k*T?m8aDFwV]>tq+)&M=Xi^)wL');
define('SECURE_AUTH_SALT', 'y|#XPZ@bjs*6@T+%,G2X8|:+p0l_bb|w[j)G7!lf(?:o*WA{%<|d+[$E7i.-YY=A');
define('LOGGED_IN_SALT',   '$-wa.R|z~f0-67uzi}vTr`C(+ $r.TOMtv=]cyW9.]EO: --|}tNENU1fK*@8~2k');
define('NONCE_SALT',       '{E<=J|fB0S|kvlh82A7Dj-=u~Ps@a}+&qTQ}ep,wedC*RIHxI~[9x|?NJ$g|_vo;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'fly_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
