#!/usr/bin/env python

######################################################################
# CS418 Repo Puller
#
# This python script clones the class repository then clones each student's
#  repository, as specified in the files in the users/ directory, as supplied
#  by the students in assignment 1
#
#  Mat Kelly <mkelly@cs.odu.edu>
#################################################################

import subprocess
import os
from os import listdir
from os.path import isfile, join
import shutil
import time
import glob

classRepoURI = "https://github.com/jbrunelle/ODUCS418F16.git"
destinationPath = './ODUCS418cloned'
demosDir = "./demos"

# Remove any prior downloads of the class repository
if os.path.isdir(destinationPath):
    shutil.rmtree(destinationPath)
    print "Removed class repo directory"

if os.path.isdir(demosDir):
    shutil.rmtree(demosDir)
    "Removed demos repo directory"

# Acquire/refresh class repo
#print "accessing all files from "+str(classRepoURI)
try:
    subprocess.Popen(['git', 'clone', str(classRepoURI), destinationPath])
except:
    print "Directory already exists"
time.sleep(5)

# Get all files except that are not dot files
users = glob.glob(os.path.join(destinationPath+"/users",'*'))


for userFile in users:
  #print "starting userFile: "+userFile
    with open(userFile,"r") as fo:
        csUsername = os.path.basename(fo.name)
        csStudentRepoURI = fo.readline().strip()

        # Sanitize the repo URIs as submitted by students to use SSH
        csStudentRepoURI = csStudentRepoURI.replace("http://","https://")
        csStudentRepoURI = csStudentRepoURI.replace("https://github.com/","git@github.com:")
        print "Received git repo at location "+csStudentRepoURI

        # Add the .git suffix for consistency of students' repo URIs
        if ".git" not in csStudentRepoURI[-4:]:
            csStudentRepoURI+= ".git"

        print "Running git clone of "+csUsername+" "+str(csStudentRepoURI)+' ./demos/'+csUsername

        # Try to clone the student's repository with their CS username as the dir name
        try:
            clone = subprocess.Popen(['git', 'clone', str(csStudentRepoURI), './demos/'+csUsername],stdout=open(os.devnull, 'wb'))
            print "Cloning "+csStudentRepoURI+" to demos/"+csUsername+"/"
            clone.wait()
        except:
            print "Could not clone "+csUsername+"'s project repository"
