#!/bin/bash
apt-get update; apt-get upgrade -y
apt-get install lib32gcc1 -y
useradd -m steam
sudo -iu steam
mkdir ~/steamcmd
cd ~/steamcmd
wget https://steamcdn-a.akamaihd.net/client/installer/steamcmd_linux.tar.gz
tar -xf steamcmd_linux.tar.gz
rm -Rf steamcmd_linux.tar.gz
cd ~/steamcmd
./steamcmd.sh
login anonymous
force_install_dir /home/steam/cstrike/
app_update 90
app_update 90
app_update 90
quit
exit
clear
