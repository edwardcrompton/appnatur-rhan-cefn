# Running migrations

## Editing migrations

When an edit has been made to a migration yml file in the migrations folder,
migrations must be reimported with the following command:

`lando drush cim --partial --source=/app/web/modules/custom/termau_migrate/migrations`

It seems to be necessary to clear the cache after reimporting the migration:

`lando drush cr`

To view available migrations:

`lando drush migrate:status`

To run a migration:

`lando drush migrate:import`

To rollback a migration:

`lando drush migrate:rollback`
