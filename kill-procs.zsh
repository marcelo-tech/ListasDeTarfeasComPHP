for pid in $(ps | grep -E 'firefox|gecko' | awk '{print $1}');
do
kill -9 $pid
done
