apache:
  lookup:
    server: apache2
    service: apache2
    default_charset: 'UTF-8'

  name_virtual_hosts:
    - interface: '*'
      port: 80
    - interface: '*'
      port: 443

  modules:
    enabled:
      - ldap
      - ssl
      - rewrite
      - mpm_prefork
      - php7.0
    disabled:
      - mpm_event

  register-site:
    app:
      name: 'app'
      path: 'salt://apache/templates/app.conf'
      state: 'enabled'
      template: true
      defaults:
        some_var: "need to be passwed becuse of a bug in state :)"

  keepalive: 'On'
