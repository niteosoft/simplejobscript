WEBSITES TOOLS
##############

CRONJOBS
-------
automatic scripts maintaining the website

-how to create cronjob in cPanel / general hosting?

Follow a general guide for example from http://support.hostgator.com/articles/cpanel/how-do-i-create-and-delete-a-cron-job

-how to create cronjob on unix like systems?

A) INSTALL IT - sudo apt-get install cron

B) OPEN CRONTAB - crontab -e

C) SCHEDULE YOUR JOB and log - code example for weekly newsletter running at midnight: 
(0 0 * * 1 cd /var/www/yourproject/_tools && php cron_weekly_newsletter.php > logs/cron_weekly_newsletter.log /dev/null 2>&1)

-how to create cronjob in Windows?

A) Under Windows cron is called 'Scheduled Tasks'. It's located in the Control Panel. You can set several scripts to run at specified times in the control panel. Use the wizard to define the scheduled times. Be sure that PHP is callable in your PATH.


TRANSLATIONS
------------

-how to create new translation?

A) Open _tools/translations/src and create a folder / files structure with your language code. Copy paste the English example

B) Then proceed to the import steps below



-how to import existing translation?

A) Open "_tools/translations_in_db.php" file, comment out the "die()" security command  + add your language code (eg. "de")

B) Then open in your browser the following URL: "https://yourwebsite.com/_tools/translations/translations_in_db.php"

After these steps your language will be imported. Now you need to activate it.

C) To activate the language, open "_config/config.envs.php" and change the language of the job board:

eg:

'lang_code' => 'de',



