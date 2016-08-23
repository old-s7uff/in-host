#!/bin/bash
# Created For Users With No SUDO Access!
user=$(whoami)
ip=$(0.0.0.0)
port=$(27015)
players=$(32)
map=$(de_dust2)
pingb=$(2)
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
sleep 2
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
cat <<EOF > ~/start.sh
./hlds_run -game cstrike +ip $ip +port $port +maxplayers $players +map $map -pingboost $pingb -autoupdate
EOF
chmod +x ~/start.sh
~/./start.sh

