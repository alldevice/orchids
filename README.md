# orchids
many species files


Sudo service networking restart when WiFi connection is lost:
  - curl https://raw.githubusercontent.com/alldevice/orchids/master/check_network.sh > /home/pi/check_network.sh | sudo mv /home/pi/check_network.sh /usr/local/bin 
  - crontab -e
  - Append the following entry: */1 * * * * sudo /usr/local/bin/check_network.sh
 (at every minute)
 Task: List all your cron jobs:
# crontab -l
# crontab -u username -l

To remove or erase all crontab jobs use the following command:
# Delete the current cron jobs #
crontab -r

## Delete job for specific user. Must be run as root user ##
crontab -r -u username
