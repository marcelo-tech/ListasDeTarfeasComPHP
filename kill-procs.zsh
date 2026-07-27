for pid in $(ps | grep -E 'firefox|gecko|jetbrainsd|idea' | awk '{print $1}');
do
kill -9 $pid
done
