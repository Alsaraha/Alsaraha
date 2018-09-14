if ! command -v figlet > /dev/null
then
	echo "Please install figlet"
	exit 1
fi
if [[ "$1" == "" ]]
then
	read -p 'type a text: ' txt
else
	txt="$1"
fi

if [[ ! $built ]]; then ARRAY=(█ ▓ ▒ ░ ─); c=0; array=();
	 readarray -t oarray < <(ls \
		 *.fl[cf] /usr/share/figlet/fonts/\
		 *.fl[cf] | tr -d "'" | xargs -I{} basename "{}" | sed 's/.fl[cf]//g'); for (( i=0; i<"${#oarray[@]}"; i++ )); do figlet -f "${oarray[i]}" '' 2> /dev/null && array[c++]="${oarray[i]}"; done; echo "${array[@]}" > /tmp/array.fvd; built=true; else array=(`cat /tmp/array.fvd`); fi; for (( i=0; i<"${#array[@]}"; i++ )); do t="${array[i]}"; echo $t; figlet -f "$t" "$txt"; read -s -n1 n </dev/tty; [[ "$n" == "k" ]] && ((i-=2)); [[ "$n" == "y" ]] && break; done; f="${array[i]}"; IFS=''; echo $txt; figlet -w 100 -w 1000 -f $f "$txt" | tee /tmp/f1 > /tmp/f0; cat /tmp/f0; j=1; sed 's/./&\n/g' /tmp/f0 | grep -vx '' | awk '!seen[$0]++' | while read line; do echo -e "What do you want to replace ($line) with?\n${ARRAY[\
*]}"; read j </dev/tty; [[ "$j" != "" ]] && x=$j; line=${line//|/\\|}; sed -i 's|'"${line//./\\.}"'|'"￼${x}￼"'|g' /tmp/f1; done; for (( i=1; i<=${#ARRAY[@]}; i++ )); do sed -i 's|'"￼${i}￼"'|'"${ARRAY[i-1]}"'|g' /tmp/f1; done; cat /tmp/f1 | awk '{l=length($0); for (i=0; i<l; i++) { k[i,NR]=substr($0, i, 1) } } END {for (j=0; j<l; j++) { for (i=0; i<12; i++) { printf k[j,i] } print ""; } }' | tac | rev
