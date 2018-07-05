#!/usr/bin/env python3
#http://abyz.me.uk/rpi/pigpio/python.html
#import math
#import numpy as np

import datetime
import pigpio
from hcsr04sensor import sensor
import time
import sys, getopt

now = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

#The normal way to start pigpio is as a daemon (during system start):
#in rc.local put "sudo pigpiod" 

pi = pigpio.pi('localhost', 4444) # connect to local Pi
step_num = 400 # number step


def get_raw_distace(value):
    try:
        raw_measurement = value.raw_distance()
    except:
        return -1
    return raw_measurement


def main(argv):
   pulse_start = 0
   pulse_end = 0
   hole_depth = 33  # centimeters
   echo_pin = '' # pin number - BCM (ex.: BCM18 -> physical pin = 12, BCM12 -> physical pin = 32 )
   trig_pin = ''
   pump_pin = ''
   power = ''
   height_water = '' # in "cm"
   
   try:
      opts, args = getopt.getopt(argv,"h:e:t:p:w:v:",["echo_pin=","trig_pin=","pump_pin=","power=","height_water="])
   except getopt.GetoptError:
      print ('Pump_level_sensor_API.py -e <echo_pin> -t <trig_pin> -p <pump_pin> -w <power> -v <height_water>')
      sys.exit(2)
   for opt, arg in opts:
      if opt == '-h':
         print ('Pump_level_sensor_API.py -e <echo_pin> -t <trig_pin> -p <pump_pin> -w <power> -v <height_water>')
         sys.exit()
      elif opt in ("-e", "--echo_pin"):
         echo_pin = int(arg)
      elif opt in ("-t", "--trig_pin"):
         trig_pin = int(arg)
      elif opt in ("-p", "--pump_pin"):
         pump_pin = int(arg)
      elif opt in ("-w", "--power"):
         power = int(arg)
      elif opt in ("-v", "--height_water"):
         height_water = int(arg)

   pi.set_mode(trig_pin, pigpio.OUTPUT)  # as output
   pi.set_mode(echo_pin, pigpio.INPUT)  # as input
   pi.set_mode(pump_pin, pigpio.OUTPUT)  # as output (software PWM)
   pi.set_PWM_range(pump_pin, 100)
   pi.set_PWM_frequency(pump_pin, 1000)

   
   log = open("/home/pi/orchids/pump.log", "a+")
   
   # check depth
   value = sensor.Measurement(trig_pin,echo_pin,temperature=20,unit='metric',round_to=2)
    # Calculate the liquid depth, in centimeters, of a hole filled with liquid
   #raw_measurement = value.raw_distance()
   raw_measurement = get_raw_distace(value)
   liquid_depth = value.depth_metric(raw_measurement, hole_depth)
   print("Depth = {} centimeters".format(liquid_depth))
   #print(now)
   log.write(" \n Today: " + now)
   log.write(" \n First depth = {} centimeters".format(liquid_depth))
   liquid_depth_0 = liquid_depth
   liquid_depth_prev = liquid_depth
   if (liquid_depth_0 > 5):
     for i in range(0, step_num, 1):
       pi.set_PWM_dutycycle(pump_pin, power)	 
       value = sensor.Measurement(trig_pin,echo_pin,temperature=20,unit='metric',round_to=2)
       # Calculate the liquid depth, in centimeters, of a hole filled with liquid
       #raw_measurement = value.raw_distance()
       raw_measurement = get_raw_distace(value)
       liquid_depth = value.depth_metric(raw_measurement, hole_depth)
       if (liquid_depth > liquid_depth_prev + 0.5 or liquid_depth < liquid_depth_prev - 0.5 ): # for too fast changes
        liquid_depth = liquid_depth_prev - 0.1
       liquid_depth_prev = liquid_depth
       print("Depth = {} centimeters".format(liquid_depth))
       log.write(" \n Depth = {} centimeters".format(liquid_depth))
       if (liquid_depth < (liquid_depth_0 - height_water)):
         pi.set_PWM_dutycycle(pump_pin, 0) # turn off pump
         break         
   else:
     print("Too little water")
     log.write(" \n Too little water")
   pi.set_PWM_dutycycle(pump_pin, 0) # turn off pump FOR ENSURE!
   pi.stop()
   print("Success.".format(liquid_depth_0 - liquid_depth))
   log.write(" \n Success.".format(liquid_depth_0 - liquid_depth))
   log.write(" \n \n ------")
   log.close()

if __name__ == "__main__":
   main(sys.argv[1:])
