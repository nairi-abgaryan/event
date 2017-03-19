get-composer:
  cmd.run:
    - name: "CURL=`which curl`; $CURL -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer"
    - unless: test -f /usr/local/bin/composer
    - cwd: /root/
    - order: last

composer-install:
  cmd.run:
    - name: composer install --no-interaction
    - cwd: {{ salt['environ.get']('APP_WORKING_DIR') }}
    - runas: {{ salt['environ.get']('APP_SYSTEM_USER') }}
    - require:
      - cmd: get-composer
    - order: last

run-migrations:
  cmd.run:
      - name: php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
      - cwd: {{ salt['environ.get']('APP_WORKING_DIR') }}
      - runas: {{ salt['environ.get']('APP_SYSTEM_USER') }}
      - require:
        - cmd: get-composer
      - order: last