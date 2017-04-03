mysql:
  global:
    client-server:
      default_character_set: utf8
  clients:
    mysql:
      default_character_set: utf8
    mysqldump:
      default_character_set: utf8
  library:
    client:
      default_character_set: utf8

  database:
    - {{ salt['environ.get']('APP_DB_DATABASE') }}

  user:
    {{ salt['environ.get']('APP_DB_USERNAME') }}:
      password: {{ salt['environ.get']('APP_DB_PASSWORD') }}
      host: localhost
      databases:
        - database: {{ salt['environ.get']('APP_DB_DATABASE') }}
          grants: ['all privileges']
