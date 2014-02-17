#!/bin/sh

BASEDIR=$(dirname $0)

DEBUG_LOG=$BASEDIR/debug.log

mkdir $BASEDIR/archive_debug_log

SIZE=`stat -c %s $DEBUG_LOG`

if [ $SIZE -gt 104857600 ]; then
    # 如果大小超過100MB
    zip -rqm9 $BASEDIR/archive_debug_log/debug.log-$(date +%F).zip $BASEDIR/debug.log
    touch $BASEDIR/debug.log
fi
