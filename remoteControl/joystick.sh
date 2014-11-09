#!/bin/sh

while [ true ]
do
./readerj | tee array > /dev/null 2>&1
./readerf | tee button > /dev/null 2>&1
 button=`./readerb`

 case $button in
  1) xdotool type "j"  ;;
  2) xdotool type "g"  ;;
  3) xdotool type "y"  ;;
  4) xdotool type "h"  ;;
  5) xdotool type "a"  ;;
  6) xdotool type "s"  ;;
  7) xdotool type "d"  ;;
  8) xdotool type "f"  ;;
  9) xdotool key shift  ;;
  10)xdotool type " "  ;;
  11)xdotool key shift  ;;
  12)xdotool type " "  ;;
 esac

done
