#!/bin/bash
# Created For Users With No SUDO Access!
user=$(whoami)
mkdir ~/steamcmd
cd ~/steamcmd
wget https://steamcdn-a.akamaihd.net/client/installer/steamcmd_linux.tar.gz
tar -xf steamcmd_linux.tar.gz
rm -Rf steamcmd_linux.tar.gz
cd ~/steamcmd
./steamcmd.sh +login anonymous +force_install_dir /home/$user/cstrike/ +app_update 90 +app_update 90 +app_update 90 +quit
clear
ls -la /home/`whoami`/cstrike/
echo "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*"
echo "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*"
echo "Counter Strike 1.6 Is Done."
echo "Now Installing Amxmod, dproto, metamod."
echo "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*"
echo "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*"
cd /home/`whoami`/cstrike/cstrike
