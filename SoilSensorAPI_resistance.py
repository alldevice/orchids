#!/usr/bin/env python3
#http://abyz.me.uk/rpi/pigpio/python.html
#import math
#import numpy as np

import datetime
import pigpio
import time
import sys, getopt

#The normal way to start pigpio is as a daemon (during system start):
#in rc.local put "sudo pigpiod" 

pi = pigpio.pi('localhost', 4444) # connect to local Pi
#p_range = range(0, 10000, 1)

#example cmd: SoilSensorAPI_resistance.py -s 17 -p  18
def main(argv):
   sense_pin = ''
   pwm_pin = ''
   try:
      opts, args = getopt.getopt(argv,"h:s:p:",["sense_pin=","pwm_pin="])
   except getopt.GetoptError:
      print ('SoilSensorAPI.py -s <GPIO_1> -p <GPIO_2>')
      sys.exit(2)
   for opt, arg in opts:
      if opt == '-h':
         print ('SoilSensorAPI.py -s <GPIO_1> -p <GPIO_2>')
         sys.exit()
      elif opt in ("-s", "--sense_pin"):
         sense_pin = int(arg)
      elif opt in ("-p", "--pwm_pin"):
         pwm_pin = int(arg)

   step_num = 500 # number of steps
		 
   # to define direction electricity current 
   dir = open("/home/pi/orchids/sense.fl", "r")
   di = dir.readlines() # array string from file rasp.fl
   direct = int(di[0])
   dir.close()		 
 
   if direct == 0:
      dir = open("/home/pi/orchids/sense.fl", "w")
      dir.write('1')
      dir.close()
      pi.set_mode(sense_pin, pigpio.INPUT)  # as input
      pi.set_PWM_frequency(pwm_pin, 8000)
      pi.set_PWM_range(pwm_pin, step_num)
      counter=0
      for i in range(0, step_num, 1):
         counter=counter+1
         pi.set_PWM_dutycycle(pwm_pin,i)
         time.sleep(0.002) #in seconds, suspends execution.	  
         if (pi.read(sense_pin)==1): # check for wire sensor break
            break  
   else:
      dir = open("/home/pi/orchids/sense.fl", "w")
      dir.write('0')
      dir.close()
      #reverse between pins
      pi.set_mode(pwm_pin, pigpio.INPUT)  # pin as input
      pi.set_PWM_frequency(sense_pin, 8000)
      pi.set_PWM_range(sense_pin, step_num) # 
      counter=0
      for i in range(0, step_num, 1):
         counter=counter+1
         pi.set_PWM_dutycycle(sense_pin,i) #
         time.sleep(0.002) #in seconds, suspends execution.	  	  
         if (pi.read(pwm_pin)==1): # check for wire sensor break
            break 

   #print(pi.get_PWM_frequency(sense_pin))
			
   pi.set_mode(sense_pin, pigpio.OUTPUT) # pin as output
   pi.write(sense_pin, 0) # set pin to low
   pi.set_mode(pwm_pin, pigpio.OUTPUT) # pin as output
   pi.write(pwm_pin, 0) # set pin to low
   time.sleep(0.1) #in seconds, suspends execution.   

   print (counter)
   pi.stop()  
   

if __name__ == "__main__":
   main(sys.argv[1:])
