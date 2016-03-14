#!/bin/bash
#
# Run as apache user
# Example: su -s /bin/sh apache -c "./install.sh"
# 1) su -s /bin/sh apache -c "./install.sh"

# Initial Setup
# arg0 execute command
# arg1 first paremter
DIRNAME=$(dirname `readlink -f -- $0`)
# Read conf vars                                                            
#source $DIRNAME/setup.conf

#############################
#    Config
#############################
composerPath="$DIRNAME/../../composer.phar"


#############################
#    Install phpseclib from composer
#############################
function install_phpseclib(){
    php "$composerPath" update phpseclib/phpseclib
}

#############################
#    Check requirement
#############################
function check_require(){
    if [ ! -f "$composerPath" ]; then
        echo "Can't find composer.phar file"
        exit 1
    fi
}


function main(){
    printf "\n---------- CONFIGING PHPSECLIB ----------\n" 
    check_require
    install_phpseclib
}

# Init main function
main

