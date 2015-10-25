#!/bin/bash
#
# Initial Setup
# Run under web root
# 
# arg0 execute command
# arg1 first paremter
DIRNAME=$(dirname `readlink -f -- $0`)
# Read conf vars                                                            
source $DIRNAME/setup.conf

#############################
#    Config
#############################
#easyRsaPath="/tmp/easyrsa"
openVpnPath="$DIRNAME/../../module/Lib/src/Openvpn"
easyRsaPath="$openVpnPath/Bin"

#############################
#    Install easy-rsa
#############################
function remove_easyrsa(){
    if rpm -qa | grep -qw easy-rsa; then
        sudo yum -y remove easy-rsa
        echo "Easy RSA Package removed"
    fi
}

function remove_config(){
    echo "Remove easy RSA key libs to $easyRsaPath"
    rm -rf "$easyRsaPath"
}

function main(){
    printf "\n---------- REMOVEING EASY-RSA ----------\n" 
    remove_easyrsa
    remove_config
}

# Init main function
main

