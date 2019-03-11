### This is a Symfony JWT auth example implementation
#### Notes:
1) JWT authorisation implementation is primitive. With additional time efforts it can be extended with refresh token.
2) Tests implemented in a primitive way as well (1 test with HTTP response for 1 endpoint). No negative testing.
3) Migrations generated from entities - `php bin/console make:migration`
4) DB generated from migrations - `php bin/console doctrine:migrations:migrate`
5) Data can be generated from fixtures (and used for tests) - `php bin/console doctrine:fixtures:load`
6) Do not forget to specify `APP_DOMAIN` in .env.test
7) Do not forget to specify `DATABASE_URL` and `JWT_SECRET` in your local .env file

###### Minor notes:
1) Repository not covered with unit tests. Reason described here `https://symfony.com/doc/current/testing/doctrine.html`
2) `@codeCoverageIgnore` added to __construct methods to have more transparent code coverage statistic