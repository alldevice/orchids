#!/bin/bash

OUT_IP_1=google.com
	#OUT_IP_1=$(route | grep default | awk '{print $2}') # с таким вариантом ВСЁ помирает 
x=`ping -c1 $OUT_IP_1 2>&1 | grep -e unknown -e Unreachable -e '0 received'`
if [ ! "$x" = "" ]; then
        echo "It's down!! Attempting to restart."
        sudo service networking restart
        echo "network restarted $(date)" >> /home/pi/log_restart_network.log
fi


OUT_IP_2=25.86.120.215 # adress for check
x=`ping -c1 $OUT_IP_2 2>&1 | grep -e unknown -e Unreachable -e '0 received'`
if [ ! "$x" = "" ]; then
                sudo /etc/init.d/logmein-hamachi restart
                echo "hamachi restarted $(date)" >> /home/pi/log_restart_hamachi.log
fi
