# processor-last-file

[![Build Status](https://travis-ci.org/keboola/processor-last-file.svg?branch=master)](https://travis-ci.org/keboola/processor-last-file)
[![Docker Repository on Quay](https://quay.io/repository/keboola/processor-last-file/status "Docker Repository on Quay")](https://quay.io/repository/keboola/processor-last-file)

Last File processor. Selects last file from `/data/files/in` with a given tag and deletes all other files. Manifest file is kept.
 
## Development
 
Clone this repository and init the workspace with following commands:

- `docker-compose build`

### TDD 

 - Edit the code
 - Run `docker-compose run --rm processor-last-file-tests` or you can filter tests running `docker-compose run --rm processor-last-file-tests php vendor/bin/phpunit --filter testName`
 - Repeat
 
# Integration
 - Build is started after push on [Travis CI](https://travis-ci.org/keboola/processor-last-file)
 - [Build steps](https://github.com/keboola/processor-last-file/blob/master/.travis.yml)
   - build image
   - execute tests against new image
   - publish image to [quay.io](https://quay.io/repository/keboola/processor-last-file). Only if release is tagged
   
# Usage

## Sample configuration

```
{  
    "definition": {
        "component": "keboola.processor.last-file"
    },
    "parameters": {
        "tag": "myTag" 
    }
}
```

## Parameters

### tag

Download files with the given tag. 
