php_ppa:
  pkgrepo.managed:
    - humanname: PHP Repo
    - ppa: ondrej/php
    - keyid: E5267A6C
    - keyserver: keyserver.ubuntu.com

php-packages:
  pkg.installed:
    - names:
      - php7.1-cgi
      - php7.1-curl
      - php7.1-imap
      - php7.1-mysql
      - php7.1-intl
      - php7.1-ldap
      - php7.1-sqlite3
      - php7.1-gd
      - php7.1-mbstring
      - php7.1-xml
      - php-mysql
      - php7.0-mysql
      - php7.0-xml
      - php-xml