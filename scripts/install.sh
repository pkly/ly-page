#!/bin/bash

DIR="$(cd "$(dirname "$0")" && pwd)"

echo "Updating application"

$DIR/../bin/console doctrine:database:create --if-not-exists
$DIR/../bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing