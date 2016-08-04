#!/bin/bash
ip="$(dig +short myip.opendns.com @resolver1.opendns.com)"
yum update; yum upgrade -y
yum -y install vsftpd wget git yum-utils nano bind-utils curl build-essential libssl-dev openssl
systemctl start vsftpd
systemctl enable vsftpd
rm -Rf /etc/vsftpd/vsftpd.conf
cd /etc/vsftpd/
wget https://raw.githubusercontent.com/systemroot/in-host/master/etc/vsftpd/vsftpd.conf
service vsftpd restart
clear
echo "VSFTPD INSTALLATION IS DONE"
echo "We Will Ask You For An User"
echo "Just To Test If Is Working, You Can Cancel This With CTRL+C!"
echo "Please Write One Username: "
read username
adduser $username
echo "$username:changeme" | chpasswd
mkdir /home/$username/public_html
chown -R $username:$username /home/$username/public_html
clear
echo "It's Done. Now try to connect $ip:21"
echo "username : $username "
echo "password : changeme  "
echo "User Directory /home/$username/public_html"
