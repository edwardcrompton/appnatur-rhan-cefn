# Running migrations

## Editing migrations

When an edit has been made to a migration yml file in the migrations folder,
migrations must be reimported by clearing the cache:

`lando drush cr`

If migrations are placed in the config/install folder they need to be imported
into config before changes take effect:

`lando drush cim --partial --source=/app/web/modules/custom/termau_migrate/config/install`

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

## Development

This module requires a custom composer package edwardcrompton/porthtermau in
order to integrate with the Porth Termau API. To make the development workflow
as efficient as possible, this packaged is symlinked from a local directory into
the vendor folder as described [here](https://medium.com/pvtl/local-composer-package-development-47ac5c0e5bb4).

This means that the package can be edited directly in the vendor folder. To
commit changes, cd to the local source directory of the package and commit the
changes.
