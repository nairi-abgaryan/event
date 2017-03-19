{% if salt['environ.get']('APP_ENVIRONMENT') == 'local' %}

xdebug-install:
  pkg:
    - installed
    - names:
      - php-xdebug
    - skip_verify: True


{% endif %}