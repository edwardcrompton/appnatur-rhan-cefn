# Running migrations

## Editing migrations

When an edit has been made to a migration yml file in the migrations folder,
migrations must be reimported by clearing the cache:

`lando drush cr`

If migrations are placed in the config/install folder they need to be imported
into config before changes take effect:

`lando drush cim --partial --source=/app/web/modules/custom/species_migrate/config/install`

To view available migrations:

`lando drush migrate:status`

## Troubleshooting

If a migration does not show up when running `lando drush migrate:status` then
check that all plugins exist and the modules that supply them are enabled. If
the source plugin is missing, the migration will be filtered out from the list.
