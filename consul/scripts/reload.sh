#!/bin/bash

SERVICE_NAME=${SERVICE_NAME:-php}
CONSUL=${CONSUL:-consul}

preStart() {
    consul-template \
        -once \
        -dedup \
        -consul-addr consul:8500 \
        -template "/etc/tplService.ctmpl:/var/www/html/config/serviceCatalogs.php"
}

onChange() {
    consul-template \
        -once \
        -dedup \
        -consul-addr consul:8500 \
        -template "/etc/tplService.ctmpl:/var/www/html/config/serviceCatalogs.php"
}

help() {
    echo "Usage: ./reload.sh preStart  => first-run configuration for php service"
    echo "       ./reload.sh onChange  => [default] update php service catalogs config on consul cluster changes"
}

until
    cmd=$1
    if [ -z "$cmd" ]; then
        onChange
    fi
    shift 1
    $cmd "$@"
    [ "$?" -ne 127 ]
do
    onChange
    exit
done
