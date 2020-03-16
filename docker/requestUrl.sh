#!/bin/ash

export REQUEST_METHOD=$1
export REQUEST_URI=$2
export HTTP_X_MY_HEADER=$3   # TODO name header
export SCRIPT_FILENAME=/var/www/html/public/index.php
export REMOTE_ADDR=127.0.0.1
export HTTP_CONTENT_TYPE=application/json
# connect to fpm and discard all headers to just display the content
cgi-fcgi -bind -connect 127.0.0.1:9000 | awk '{while(getline && $0 != ""){}}1'
