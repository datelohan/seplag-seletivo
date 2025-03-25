# docker/php/entrypoint.sh
#!/bin/sh
set -e

# Definir UID e GID corretos
USER_ID=${CURRENT_UID:-1000}
GROUP_ID=${CURRENT_UID:-1000}

# Alterar permissões do diretório de trabalho
chown -R $USER_ID:$GROUP_ID /var/www/html

# Executar comando original
exec "$@"