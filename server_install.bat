@set dbname=skv

@title %OS%: ��⠭���� web �ࢥ�  %dbname%

@echo *** ��������� � ��������� ������� ***
@if not exist "C:\xampp\apache_start.bat" echo !!! XAMPP �� ����������, ����������� ���������� !!!

@if not exist %dbname%.sql echo !!! ���� ������ %dbname%.sql ����������� !!!
@if exist %dbname%.sql echo *** �������� ���� ������ %dbname%...
@if exist %dbname%.sql C:\xampp\mysql\bin\mysql --user="root" --password="" --execute="CREATE DATABASE %dbname%;"

@if exist %dbname%.sql echo *** ������ ������ %dbname%...
@if exist %dbname%.sql C:\xampp\mysql\bin\mysql -u root   %dbname% <%dbname%.sql

@echo *** ���������� ������ � hosts
@echo. >>"C:\Windows\System32\drivers\etc\hosts"
@echo 127.0.0.1	skv >>"C:\Windows\System32\drivers\etc\hosts"
@echo ??? �������� ����������� ������ (�᫨ �� ��୮, ������� �������)
@notepad "C:\Windows\System32\drivers\etc\hosts"

@echo *** ���������� ������ � vhosts
@if exist vhosts.txt copy "vhosts.txt" "C:\xampp\apache\conf\extra\"
@if not exist vhosts.txt echo !!! ���� ������������ vhosts.txt ���������� !!!
@cd "C:\xampp\apache\conf\extra\"
@if exist "C:\xampp\apache\conf\extra\vhosts.txt" copy "C:\xampp\apache\conf\extra\httpd-vhosts.conf"+"vhosts.txt"
@del "C:\xampp\apache\conf\extra\vhosts.txt"
@echo ??? �������� ����������� ������ (�᫨ �� ��୮, ������� �������)
@notepad "C:\xampp\apache\conf\extra\httpd-vhosts.conf"

@echo *** ��������� ���������� Apache � MySQL
@echo --- ��������� � ��������� ������� ���������.
