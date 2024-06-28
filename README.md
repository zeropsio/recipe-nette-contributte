# Zerops x Nette + Contributte

[Nette Contributte](https://github.com/contributte/webapp-skeleton) is a web application skeleton based on Nette Framework, Doctrine and Contributte libraries.
[Zerops](https://zerops.io) recipe for Contributte skeleton includes session and cache stored in Redis, and PostgreSQL DB with doctrine migrations.

![nette](https://raw.githubusercontent.com/zeropsio/recipe-shared-assets/main/covers/svg/cover-nette.svg)

<br/>

## Deploy on Zerops
You can either click the deploy button to deploy directly on Zerops, or manually copy the [import yaml](https://github.com/zeropsio/recipe-contributte/blob/main/zerops-project-import.yml) to the import dialog in the Zerops app.

[![Deploy on Zerops](https://raw.githubusercontent.com/zeropsio/recipe-shared-assets/main/deploy-button/green/deploy-button.svg)](https://app.zerops.io/recipe/nette)

<br/>

## Recipe features

- Nette running on a load balanced **Zerops PHP + Nginx** service
- Zerops **PostgreSQL 16** service as database
- Zerops KeyDB (**Redis**) service for session and cache
- Proper setup for Nettrine **cache**, **optimization**, and **database migrations**
- Logs set up to use **syslog** and accessible through Zerops GUI
- Utilization of Zerops built-in **environment variables** system
- [Mailpit](https://github.com/axllent/mailpit) as **SMTP mock server**
- [AdminerEvo](https://www.adminerevo.org) for **quick database management** tool

<br/>

## Production vs. development

Base of the recipe is ready for production, the difference comes down to:

- Use highly available version of the PostgreSQL database (change `mode` from `NON_HA` to `HA` in recipe YAML, `db` service section)
- Use at least two containers for Nette service to achieve high reliability and resilience (add `minContainers: 2` in recipe YAML, `app` service section)
- Use production-ready third-party SMTP server instead of Mailpit (change `parameters.smtp` variables in `./config/app/parameters.neon` file)
- Disable public access to Adminer or remove it altogether (remove service `adminer` from recipe YAML)
- Set `NETTE_DEBUG` to `0` and `NETTE_ENV` to `prod` in `envSecrets`, `app` section of import YAML
- Create `admin` user manually through `create-user` console command (in dev mode this is handled by fixtures) and
  - remove following line from `zerops.yml`:
    - `- zsc execOnce ${appVersionId}-fixtures -- php /var/www/bin/console doctrine:fixtures:load --no-interaction`
  - add `--no-dev` to the following line in `zerops.yml`:
    - `- composer install --optimize-autoloader`

<br/>

## Changes made over the default installation

If you want to modify your existing Nette app to efficiently run on Zerops, these are the general steps we took:

- Add [zerops.yml](https://github.com/zeropsio/recipe-contributte/blob/main/zerops.yml) to your repository, our example includes idempotent migrations, caching, and optimized build process
- Add `$configurator->addDynamicParameters(['env' => getenv()]);` to your [./app/Bootstrap.php](https://github.com/zeropsio/recipe-contributte/blob/main/app/Bootstrap.php:25) file to use env variables in your neon configuration files
- Add [contributte/redis](https://github.com/contributte/redis) to your composer.json to store sessions in Redis
  - configure it according to our [./config/env/base.neon](https://github.com/zeropsio/recipe-contributte/blob/main/config/env/base.neon#L55) file
- Add [contributte/monolog](https://github.com/contributte/monolog) to your composer.json to log into the syslog
  - utilize the following handler: `Monolog\Handler\SyslogHandler(app)` (see our [./config/ext/contributte.neon](https://github.com/MichalSalon/recipe-contributte/blob/main/config/ext/contributte.neon#L31))

<br/>
<br/>

Need help setting your project up? Join [Zerops Discord community](https://discord.com/invite/WDvCZ54).
