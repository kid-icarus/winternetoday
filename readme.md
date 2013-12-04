## Getting started

The actual app loads from /public/. It requires mcrypt, which you can install (on Ubuntu 12.04) with <code>apt-get php5-mycrypt</code>.

1. In /app/config/, copy tweet.template.php to tweet.php and fill in values.
2. In /app/config/, copy database.template.php to database.php and fill in values.
3. Run $</code>php artisan migrate</code> from the root directory.
