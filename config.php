<?php
/** For guides on how to configure project-clover installation, */ 
/** visit: https://github.com/popoway/project-clover            */

# Specify the app version.
define("PC_VER", "2.1.0");

# Specify the runtime environment: staging, production
define( 'PC_ENV', 'staging' );

# Define Site URL
if (PC_ENV == "staging") {
  define( 'PC_SITEURL', 'https://staging.clover.yeshan.ming.fyi' );
}
elseif (PC_ENV == "production") {
  define( 'PC_SITEURL', 'https://clover.yeshan.ming.fyi' );
}

# Define CDN URL
define( 'PC_CDNURL', 'https://static.popoway.me/ajax/libs' );

# MySQL settings - You can get this info from your web host
/** The name of the database for project-clover */
define( 'DB_NAME', 'project_clover' );
/** MySQL database username */
define( 'DB_USER', 'project_clover_user' );
/** MySQL database password */
define( 'DB_PASSWORD', 'password' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

# Database prefix is placed in front of your database tables. 
# Change it if you are intalling multiple project-clover installations
# within the same database. Keep security in mind if you choose to do this.
$table_prefix = 'pc_'; // Only numbers, letters, and underscores please!
