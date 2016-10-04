#!/bin/bash
if ( hostname | grep -E '^tsgt02lv$' > /dev/null)
then
    wget https://tsgt02lv/jobopportunity/wp-cron.php --no-check-certificate -O /dev/null
elif ( hostname | grep -E '^telma\.net$' > /dev/null)
then
    wget https://telma.net/wp-cron.php --no-check-certificate -O /dev/null
fi