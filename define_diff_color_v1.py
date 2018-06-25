# firstly run environment : workon cv

import numpy as np
import cv2
import imutils
import glob


greenLower = (40, 50, 50)
greenUpper = (80, 255, 100)

#yellowLower = (25, 50, 100)
#yellowUpper = (39, 255, 255)

#read list files in dir
list = glob.glob("/mnt/hgfs/D/YandexDisk/work/iot/soft/opencv/photo_db_1/*.jpg")
print(len(list))

for filename in list:
    #print(filename)
    # Load image
    img = cv2.imread(filename,1)
    #imCopy = img.copy()
    img = imutils.resize(img, width=300)
    sample_1 = img[70:150, 10:100]
    #blurred = cv2.GaussianBlur(img, (11, 11), 0)
    median = cv2.medianBlur(img,9) # https://docs.opencv.org/3.1.0/d4/d13/tutorial_py_filtering.html
    med_sam_1 = cv2.medianBlur(sample_1,9)
    img[70:150, 10:100] = med_sam_1
    hsv = cv2.cvtColor(median, cv2.COLOR_BGR2HSV)
    mask_plants = cv2.inRange(hsv, greenLower, greenUpper)
    image, contours, hierarchy =  cv2.findContours(mask_plants,cv2.RETR_TREE,cv2.CHAIN_APPROX_SIMPLE)
    cv2.drawContours(img,contours,-1,(0,255,0),2)
    # average color in rectangle domain (bgr)
    avg_curtain_per_row = np.average(med_sam_1, axis=0)
    avg_curtain = np.average(avg_curtain_per_row, axis=0)
    print('color_curtain:')
    # convert 1D array to 3D, then convert it to HSV and take the first element 
    # this will be same as shown in the above figure [65, 229, 158]
    hsv_curtain = cv2.cvtColor( np.uint8([[avg_curtain]] ), cv2.COLOR_BGR2HSV)[0][0]
    print(hsv_curtain)
    # make mask for contour plants
    # find the average color of an object
    mean_val = cv2.mean(img,mask = mask_plants)
    print('color_plant:')
    #print(mean_val[0:3])
    hsv_plant = cv2.cvtColor( np.uint8([[mean_val[0:3]]] ), cv2.COLOR_BGR2HSV)[0][0]
    print(hsv_plant)
    print('difference:')
    print(hsv_plant - hsv_curtain)

    cv2.rectangle(img,(10,70),(100,150),(0,255,255),2)
    cv2.imshow('img',img)
    cv2.waitKey(0)
    cv2.destroyAllWindows()
    
    
    
    
    
    
    
    
