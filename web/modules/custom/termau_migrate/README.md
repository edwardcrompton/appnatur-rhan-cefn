# Running migrations

## Editing migrations

When an edit has been made to a migration yml file in the migrations folder,
migrations must be reimported by clearing the cache:

`lando drush cr`

To view available migrations:

`lando drush migrate:status`

To run a migration:

`lando drush migrate:import species_en`

To rollback a migration:

`lando drush migrate:rollback species_en`

The migrations have dependencies on each other. All migrations in a group can
be run in order of dependencies with this:

`lando drush migrate:import --group=species`

## Troubleshooting

If a migration does not show up when running `lando drush migrate:status` then
check that all plugins exist and the modules that supply them are enabled. If
the source plugin is missing, the migration will be filtered out from the list.
