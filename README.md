## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.


## Running tests
1. Run in php container `vendor/bin/phpunit tests` to run tests

## Running application
1. Run in php container `bin/console support:ticket-report:generate` to run application with default input file
2. Or run in php container `bin/console support:ticket-report:generate path-to-file` to run application with your input file

## Comments
# Potentail improvements

1. `technicalReview` and `crashReport` confirm if there are proper translations
2. Probably we should add extra validation for input file
3. refactor a bit test to make assertions more readable
4. consider use behats

