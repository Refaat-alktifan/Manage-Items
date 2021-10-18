# to start the Application:
# run

`. ./start.sh`


run `composer run seed` if the database is empty


scripts:
```json
        "phpunit": [
            "vendor/bin/phpunit"
        ],
        "lint": [
            "vendor/bin/phpcs"
        ],
        "lint-fix": [
            "vendor/bin/phpcbf"
        ],
        "migrate": [
            "php artisan migrate"
        ],
        "migrate-status": [
            "php artisan migrate:status"
        ] ,
        "migrate-rollback": [
            "php artisan migrate:rollback"
        ],
        "seed": [
            "php artisan db:seed"
        ]
```
