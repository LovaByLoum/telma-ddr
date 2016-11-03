#!/bin/bash
if ( hostname | grep -E '^tsgt02lv$' > /dev/null)
then
    wget https://tsgt02lv/jobopportunity/wp-cron.php --no-check-certificate -O /dev/null
elif ( hostname | grep -E '^telma\.net$' > /dev/null)
then
    wget https://telma.net/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( hostname | grep -E '^tapq237lv$' > /dev/null )
then
    wget https://telma.net/axianpreprod/wp-cron.php --no-check-certificate -O /dev/null
elif ( hostname | grep -E '^recrutement\.axian-group\.com$' > /dev/null)
then
    wget  https://recrutement.axian-group.com/wp-cron.php --no-check-certificate -O /dev/null
elif ( hostname | grep -E '^TAPP242LV$' > /dev/null )
then
    wget  https://recrutement.axian-group.com/wp-cron.php --no-check-certificate -O /dev/null
fi