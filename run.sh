#!/bin/bash

while getopts ":a:" opt; do
    case $opt in
        visitOnly)
            echo "visit only"
            ;;
        \?)
            echo "Invalid option: -$OPTARG" >&2
            exit 1
            ;;
        :)
            echo "Option -$OPTARG requires an argument." >&2
            exit 1
            ;;
    easc
done    