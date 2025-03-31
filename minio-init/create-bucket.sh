#!/bin/sh

# Configure o alias do MinIO
mc alias set local http://localhost:9000 ${MINIO_ROOT_USER} ${MINIO_ROOT_PASSWORD}

# Crie o bucket chamado "seplag" se ele não existir
mc ls local/seplag || mc mb local/seplag

# Torne o bucket público
mc anonymous set public local/seplag
