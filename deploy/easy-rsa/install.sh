#!/bin/bash
#
# Run as apache user
# Example: su -s /bin/sh apache -c "./install.sh"
# 1) Make sure Openvpn dir have permission for apache to create dir
# 2) sudo ./install
# 2) su -s /bin/sh apache -c "./install"

# Initial Setup
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
#    Check requirement
#############################
function check_require(){
    if [ ! -d "$openVpnPath" ]; then
        echo "Can't find Openvpn module dir"
        exit 1
    fi
    EPEL=`yum repolist epel | grep epel`
    if [ -z "$EPEL" ]; then
        echo "EPEL repo is not install, EPEL installing started"
        sudo yum -y install epel-release
    fi
}

#############################
#    Install easy-rsa
#############################
function install_easyrsa(){
    if ! rpm -qa | grep -qw easy-rsa; then
        sudo yum -y install easy-rsa
        echo "Easy RSA Package installed"
    fi
}

#############################
#    Key & Cert 
#############################
function config_easyras(){
    echo "Copy easy RSA key libs to $easyRsaPath"

    mkdir -p "$easyRsaPath/keys" 
    # copy easy-ras bin file to /etc/openvpn/ for generate ras keys
    cp -rf /usr/share/easy-rsa/2.0/* $easyRsaPath

    # copy easy-rsa var template 
    yes | cp $DIRNAME/template/vars $easyRsaPath/vars

    # Edit easy-ras default value for generate keys in /etc/openvpn/easy-rsa/var 
    if [ -e "$easyRsaPath/vars" ]; then
        sed -i "s/%key-country%/$keyCountry/g" "$easyRsaPath/vars"
        sed -i "s/%key-province%/$keyProvince/g" "$easyRsaPath/vars"
        sed -i "s/%key-city%/$keyCity/g" "$easyRsaPath/vars"
        sed -i "s/%key-org%/$keyOrg/g" "$easyRsaPath/vars"
        sed -i "s/%key-email%/$keyEmail/g" "$easyRsaPath/vars"
        sed -i "s/%key-ou%/$keyOu/g" "$easyRsaPath/vars"
        sed -i "s/%key-name%/$keyName/g" "$easyRsaPath/vars"
        echo "Done! Config Easy RAS" 
    fi   

    # Prepare Generate Easy RAS Env & default Easy RAS values
    cd $easyRsaPath 
    source ./vars
    yes | source ./clean-all

    # Copy Ca keys template
    # We don't need to copy ca.key private we only need ca.crt
    yes | cp $DIRNAME/keys/ca.crt $easyRsaPath/keys/
    yes | cp $DIRNAME/keys/ca.key $easyRsaPath/keys/
    source ./vars
    echo "Done! Copy ca keys to [$easyRsaPath/keys/]" 
}

function main(){
    printf "\n---------- CONFIGING EASY-RSA ----------\n" 
    check_require
    install_easyrsa
    config_easyras
}

# Init main function
main

