#!/usr/bin/env bash

# todo: move to gists that can be pulled

# exit when any command fails
set -e

COMPOSER_FLAGS=${1:-""}

if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
else
    BRANCH="${TRAVIS_BRANCH}"
fi

PHP_VERSION=$(php --version)
PHP_VERSION=${PHP_VERSION:4:3}

# Allow for a php-composer image tag argument
PHP_COMPOSER_TAG=${2-$PHP_VERSION}
if [ ${#PHP_COMPOSER_TAG} -ge 1 ]; then
    PHP_COMPOSER_TAG="${PHP_COMPOSER_TAG}.0"
fi

# Create the image tag
TAG="$PHP_COMPOSER_TAG-$BRANCH"

# Add '--lowest' tag suffix when installing the lowest allowable versions
if [ -n "$COMPOSER_FLAGS" ]; then
    TAG="${TAG}-${COMPOSER_FLAGS:8}"
fi

# Export $TAG as a global variable, exposing to docker-compose.yml
export TAG

# Shut down running containers
docker-compose down -v --remove-orphans

# Build the image
echo "Building image: stephenneal/caching:${TAG}"
docker build -t stephenneal/caching:"${TAG}" \
    --build-arg php_composer_tag="${PHP_COMPOSER_TAG}" \
    --build-arg composer_flags="${COMPOSER_FLAGS}" \
     .

docker-compose up -d

docker logs -f caching

while true; do
    if [[ $(docker inspect -f '{{.State.Running}}' caching) != true ]]; then
        break
    else
        echo "'caching' container is still running... waiting 3 secs then checking again..."
        sleep 3
    fi
done

# Confirm it exited with code 0
if [[ $(docker inspect -f '{{.State.ExitCode}}' caching) == 0 ]]; then
    echo "Success: Tests Passed! - stephenneal/caching:${TAG}"
else
    echo "Error: Tests Failed! - stephenneal/caching:${TAG}"
    exit 1
fi

# Confirm the image exists
docker image inspect stephenneal/caching:"${TAG}" > /dev/null 2>&1
