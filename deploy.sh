#!/bin/bash
docker login -u="$QUAY_USERNAME" -p="$QUAY_PASSWORD" quay.io
docker tag keboola/processor-last-file quay.io/keboola/processor-last-file:$TRAVIS_TAG
docker tag keboola/processor-last-file quay.io/keboola/processor-last-file:latest
docker images
docker push quay.io/keboola/processor-last-file:$TRAVIS_TAG
docker push quay.io/keboola/processor-last-file:latest
