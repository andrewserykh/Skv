@set dbname=skv

@title %OS%: “áâ ­®¢ª  web á¥à¢¥à   %dbname%

@echo *** “‘’€‚Š€ ˆ €‘’‰Š€ ‘…‚…€ ***
@if not exist "C:\xampp\apache_start.bat" echo !!! XAMPP … “‘’€‚‹…, „‹†…ˆ… …‚‡Œ† !!!

@if not exist %dbname%.sql echo !!! ”€‰‹ „€›• %dbname%.sql ’‘“’‘’‚“…’ !!!
@if exist %dbname%.sql echo *** ‘‡„€ˆ… €‡› „€›• %dbname%...
@if exist %dbname%.sql C:\xampp\mysql\bin\mysql --user="root" --password="" --execute="CREATE DATABASE %dbname%;"

@if exist %dbname%.sql echo *** ˆŒ’ „€›• %dbname%...
@if exist %dbname%.sql C:\xampp\mysql\bin\mysql -u root   %dbname% <%dbname%.sql

@echo *** „€‚‹…ˆ… ‡€ˆ‘ˆ ‚ hosts
@echo. >>"C:\Windows\System32\drivers\etc\hosts"
@echo 127.0.0.1	skv >>"C:\Windows\System32\drivers\etc\hosts"
@echo ??? ‚…Š€ „€‚‹…‰ ‡€ˆ‘ˆ (¥á«¨ ¢á¥ ¢¥à­®, § ªàëâì ¡«®ª­®â)
@notepad "C:\Windows\System32\drivers\etc\hosts"

@echo *** „€‚‹…ˆ… ‡€ˆ‘ˆ ‚ vhosts
@if exist vhosts.txt copy "vhosts.txt" "C:\xampp\apache\conf\extra\"
@if not exist vhosts.txt echo !!! ”€‰‹ Š”ˆƒ“€–ˆˆ vhosts.txt ‘“’‘’‚“…’ !!!
@cd "C:\xampp\apache\conf\extra\"
@if exist "C:\xampp\apache\conf\extra\vhosts.txt" copy "C:\xampp\apache\conf\extra\httpd-vhosts.conf"+"vhosts.txt"
@del "C:\xampp\apache\conf\extra\vhosts.txt"
@echo ??? ‚…Š€ „€‚‹…‰ ‡€ˆ‘ˆ (¥á«¨ ¢á¥ ¢¥à­®, § ªàëâì ¡«®ª­®â)
@notepad "C:\xampp\apache\conf\extra\httpd-vhosts.conf"

@echo *** ’…“…’‘Ÿ ……‡€“‘Š Apache ˆ MySQL
@echo --- “‘’€‚Š€ ˆ €‘’‰Š€ ‘…‚…€ ‡€Š—…€.
