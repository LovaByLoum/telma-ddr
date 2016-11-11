#!/bin/bash
if ( echo $HOSTNAME | egrep -i '^tsgt02lv$' > /dev/null)
then
    wget https://tsgt02lv/jobopportunity/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^telma\.net$' > /dev/null)
then
    wget https://$HOSTNAME/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^www\.telma\.net$' > /dev/null )
then
    wget https://$HOSTNAME/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^telma\.net$' > /dev/null )
then
    wget https://$HOSTNAME/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^tapq237lv$' > /dev/null )
then
    wget https://$HOSTNAME/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^TAPP242LV$' > /dev/null )
then
    wget https://$HOSTNAME/wp-cron.php --no-check-certificate -O /dev/null
elif ( echo $HOSTNAME | egrep -i '^recrutement\.axian-group\.com$' > /dev/null )
then
    wget https://$HOSTNAME/wp-cron.php --no-check-certificate -O /dev/null
fi
