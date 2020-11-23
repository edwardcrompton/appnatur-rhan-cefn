# App Natur Rhan Cefn

This is a headless Drupal environment for the Llên Natur nature app in
development.

The system uses the Drupal migrate API to fetch data from Bangor University's
Porth Termau (http://termau.cymru/) and collates it ready for ingestion by a
mobile app.

## Development setup

### Composer packages

The migration process requires a composer package edwardcrompton/porthtermau
which is also in development. To aid development workflow, it is better to have
this package checked out locally and for composer to load it from the local
version rather than to pull it in from packagist. This is done by adding a 
'path' repository to the _root_ composer.json file. See https://fetzi.dev/developing-composer-packages-locally/.

Note that the repository must be defined in the root composer.json file, not
the one in the termau_migrate module where the edwardcrompton/porthtermau
dependency is defined. See https://getcomposer.org/doc/articles/troubleshooting.md#i-have-a-dependency-which-contains-a-repositories-definition-in-its-composer-json-but-it-seems-to-be-ignored-

See this in the repositories section of ./composer.json:

```
{
    "type": "path",
    "url": "./packages/porthtermau",
    "options": {
        "symlink": true
    }
}
```

In order for this to work the edwardcrompton/porthtermau package needs to be
checked out to ./packages/porthtermau. ./packages is ignored in .gitignore. Any changes to the checked out package can be committed back to its own repository.

When Composer comes across the dependency on edwardcrompton/porthtermau in the
termau_migrate/composer.json file, it will load it from the local path defined
above instead of pulling it from Packagist.

When the package dependency is stable, this configuration can be removed and
the dependency can be checked out from Packagist in the normal way.

### API key

Porth Termau requires an API key available from Bangor University. Add this key
to your settings by putting this in settings.local.php:

```
$settings['termau_migrate_porth_termau_api_key'] = 'your key';
```

Replace _your key_ with the actual API key.

