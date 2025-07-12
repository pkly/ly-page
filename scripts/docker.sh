#!/bin/bash

DIR="$(cd "$(dirname "$0")" && pwd)"

if ! command -v docker compose &> /dev/null
then
  echo "docker not found, please install it before running this file."
  exit 1
fi

echo ''
echo '                        ##         .'
echo '                  ## ## ##        =='
echo '               ## ## ## ##       ==='
echo '           /"""""""""""""""""\___/ ==="'
echo '      ~~~ {~~ ~~~~ ~~~ ~~~~ ~~~ ~ /  ===- ~~~'
echo '           \______ o           __/'
echo '             \    \         __/'
echo '              \____\_______/'
echo '                                           '
echo "             |          |                     "
echo "          __ |  __   __ | _  __   _            "
echo "         /  \\| /  \\ /   |/  / _\\ |      "
echo "         \\__/| \\__/ \\__ |\\_ \\__  |   "
echo "                                           "
echo 'Building docker containers...'

cd $DIR/../docker/dev

docker compose -p lypage build
if [ $? != 0 ]; then
  echo "Build failed, cannot bring containers online."
  exit 1
fi

docker compose -p lypage up