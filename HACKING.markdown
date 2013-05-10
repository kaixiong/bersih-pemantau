HOW TO HACK
===========

This file documents whatever necessary to aid development. If you want to know how to setup and deploy this application (which is a Ushahidi instance), this is not the right file, see `README.markdown` instead.

Running Development Instance
----------------------------

Use the command below, please also look into.`apache/config`:

    apache2 -k start -f .apache/config -d . -e debug -X

If you use PHP >=5.4:

    php -S <BIND_IP>:<BIND_PORT>

