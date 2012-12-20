#!/bin/sh
####################################################################
###
### script name: makeHTK.sh
### modified by: Ken MacLean
### email: contact@voxforge.org
### Date: 2006.08.10
### Command: ./makeHTK.sh
### Version: 0.1
###        
### Copyright (C) 2006 Ken MacLean
###
### This program is free software; you can redistribute it and/or
### modify it under the terms of the GNU General Public License
### as published by the Free Software Foundation; either version 2
### of the License, or (at your option) any later version.
###
### This program is distributed in the hope that it will be useful,
### but WITHOUT ANY WARRANTY; without even the implied warranty of
### MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
### GNU General Public License for more details.
###
####################################################################
# change this to your home directory path!!!
export HBIN='/home/thenoz/htk-3.2.1'
export HTKCF='-ansi -Wall -Wno-switch -g -O2 -DOSS_AUDIO'
export HTKLF='-L/usr/X11R6/lib'
export HTKCC='gcc'
export Arch=LINUX
export Objcopy="echo"
export PRILF='-x'
export CPU=linux
export SHRLF='-shared'
export LIBEXT='so'

cd ./HTKLib
make clean
make 

cd ../HTKTools
make clean
make

cd ../HLMLib
make clean
make

cd ../HLMTools
make clean
make

echo '***HTK make completed***'
