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
cd /home/`whoami`/cstrike/
wget https://raw.githubusercontent.com/systemroot/in-host/master/files/dproto.cfg
cd /home/`whoami`/cstrike/cstrike/
wget https://raw.githubusercontent.com/systemroot/in-host/master/files/dproto.cfg
wget https://raw.githubusercontent.com/systemroot/in-host/master/files/liblist.gam
wget https://github.com/systemroot/in-host/raw/master/files/addons.zip
unzip addons.zip
rm -Rf addons.zip
rm -Rf ~/Steam/
rm -Rf ~/steamcmd/
{
echo "./hlds_run -game cstrike +ip 0.0.0.0 +port 27024 +maxplayers 32 +map de_dust2 -pingboost 2 -autoupdate -insecure -console +log on +mp_logecho 1"
} > "~/start.sh"
chmod +x ~/start.sh
./start.sh

