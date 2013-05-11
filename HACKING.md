HOW TO HACK
===========

This file documents whatever necessary to aid development. If you want to know how to setup and deploy this application (which is a Ushahidi instance), this is not the right file, see `README.markdown` instead.

Running Development Instance
----------------------------

Use the command below, please also look into.`apache/config`:

    apache2 -f .apache/config -d . -e debug -X -k start

Or with custom port:

    PORT=<PORT>; FILE=$RANDOM; cat .apache/config | sed -e s/11180/$PORT/g > /tmp/$FILE; apache2 -f /tmp/$FILE -d . -e debug -X -k start

If you use PHP >=5.4, you should know this:

    php -S <BIND_IP>:<BIND_PORT>

