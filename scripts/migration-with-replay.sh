#!/bin/bash

DIR="$(cd "$(dirname "$0")" && pwd)"

echo "Replaying and generating migrations"

rm -rf $DIR/../var/cache
$DIR/../bin/console doctrine:database:drop --if-exists --force
$DIR/../bin/console doctrine:database:create
$DIR/../bin/console doctrine:migrations:migrate --no-interaction
$DIR/../bin/console doctrine:schema:validate

if [ $? -eq 0 ]; then
  echo "No changes found in migrations, no actions are required"
else
  echo "Generating migrations"
  $DIR/../bin/console make:migration
  echo "Please modify and commit the migration file"
fi