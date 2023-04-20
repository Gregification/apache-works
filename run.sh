#!/bin/bash

param=(
	[showCmd]=0			#-v	[switch]
	[stop]=0			#-s	[switch]
	[restart]=0			#-r	[switch]
	[help]=0			#-h	[switch]
	[runFlags]="-dit --rm"		#-f	[param]
	[contName]="apachefiddle"	#-c	[param]
	[imgName]="httpd:2.4"		#-i	[param]
)

while getopts ":h:v:s:r:h:f:c:i:" opt; do
    case $opt in
		h)
			echo "see /run.ps1 for more details
			[flags]
				[switches]
					-h	: show help text
					-s	: stop existing container
					-r	: restart and run container
					-v	: show command used
				[paramters]
					-f	: flags to include in command
					-c	: name of the container
					-i	: name of the image"; >&2
			;;
        v)
			echo "-v was triggered" >&2;
			#param.showCmd = 1
			;;
        \?)
            	echo "Invalid option: -$OPTARG" >&2
            	exit 1
            	;;
        :)
            	echo "Option -$OPTARG requires an argument." >&2
	    	exit 1
	    	;;
	esac
done    
