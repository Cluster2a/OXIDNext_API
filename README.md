#Otto Fischer OXID EE 6.2
## Glossar
- [Branches](#Branches)
- [Builds](#Builds)
- [Deployments](#Deployments)
- [Environment](#Environment)
  - [Installation](#Installation)
  - [Services](#Services)
  - [Authentication](#Authentication)
  - [Information](#Information)
  - [Makefile](#Makefile)
    - [init](#init)
    - [grunt](#grunt)
    - [db-import](#db-import)
    - [up](#up)
    - [down](#down)
    - [bash](#bash)
    - [clear-cache](#clear-cache)
    - [composer-update](#composer-update)
    - [composer-dump-autoload](#composer-dump-autoload)
    - [create-migration](#create-migration)
    - [console-module-install](#console-module-install)
    - [console-apply-configuration](#console-apply-configuration)
- [Checkin](#Checkin)
  - [Feature](#Feature)
  - [Hotfix](#Hotfix)
- [StyleGuide](#StyleGuide)

## Branches
- master -> production
- staging -> staging
- test -> test

| Environment | Build status |
  | ------ | ------ |
| Staging (staging) | [![Build status](https://dev.azure.com/esyon/Otto%20Fischer/_apis/build/status/OXID%20staging%20nightly%20build?branchName=master)](https://dev.azure.com/esyon/erfal_oxid/_apis/build/status/OXID%20staging%20nightly%20build?branchName=master) |
| Test (test) | [![Build status](https://dev.azure.com/esyon/Otto%20Fischer/_apis/build/status/OXID%20staging%20nightly%20build?branchName=production)](https://dev.azure.com/esyon/erfal_oxid/_apis/build/status/OXID%20staging%20nightly%20build?branchName=production) |
| Master (master) | [![Build status](https://dev.azure.com/esyon/Otto%20Fischer/_apis/build/status/OXID%20staging%20nightly%20build?branchName=production)](https://dev.azure.com/esyon/erfal_oxid/_apis/build/status/OXID%20staging%20nightly%20build?branchName=production) |

## Builds
Builds will be created automatically by triggers.
The build pipeline can be adjusted by editing the azure-pipelines.yaml.<br>
<b>Attention: Changes are only allowed by employees of ESYON!</b>

## Deployments
Deployments will be managed within Releases by employees of ESYON.

## Environment
This is an OXID EE 6.2 development / staging / production environment collection using Docker with the following services:
- PHP-FPM (php7.4-fpm-alpine3.13)
- Apache (httpd:2.4.46-alpine)
- MariaDB (bitnami/mariadb:10.4)
- Grunt (alpine:3.13)

### Installation
- install the [development toolkit](https://dev.azure.com/esyon/DockerEnvironments/_git/MainDevelopment)
- clone the otto fischer environment
```sh
git clone https://dev.azure.com/esyon/Otto%20Fischer/_git/OXID_V6_EE_AKS OttoFischer
```
- add the following host entries:

```sh
# otto fischer
127.0.0.1       ottofischer.localhost.local
```

- run the main [development toolkit](https://dev.azure.com/esyon/DockerEnvironments/_git/MainDevelopment)
- run the otto fischer development environment
```sh
cd OttoFischer
docker-compose up
``` 
- the building process might take a while - wait for the finish message
- on initial run import the database and setup oxid
```sh
make db-import
make init
``` 

### Services
| Service | URL |
| ------ | ------ |
| Apache | http://ottofischer.localhost.local |
| FastCGI Process Manager | fcgi://php-fpm-ottofischer-development:9000 |
| MariaDB | tcp://mariadb-ottofischer-development:3306 |

### Authentication
| Service | Auth information |
 | ------ | ------ |
| OXID EE 6.2 | username: admin@localhost.local<br/>password: qL0sj6eKM84buzmzrkiG |
| MariaDB | server: mariadb-ottofischer-development<br/>username: dev<br/>password: dev<br/>database: database |

### Information
This docker environment collection contains the environment for the following systems:
- development
- test
- staging
- production

| Folder | Description |
  | ------ | ------ |
| database | demo database dump for development environment |
| docker/oxid/<PROVISION_CONTEXT>/deployment | compositions for azure pipeline |
| docker/oxid/<PROVISION_CONTEXT>/apache | apache & configurations |
| docker/oxid/<PROVISION_CONTEXT>/grunt | grunt cli container |
| docker/oxid/<PROVISION_CONTEXT>/php-fpm | container for php-fpm |
| docker/oxid/<PROVISION_CONTEXT>/mariadb | container for MariaDB |
| docker/oxid/<PROVISION_CONTEXT>/etc | environment files & custom files for ssh & cron |
| devOps | all devOps related files <br><b>Should only modified by ESYON employees!</b> |
| devOps/<PROVISION_CONTEXT>/azure-pipelines.yaml | sets up azure pipeline<br><b>Should only modified by ESYON employees!</b> |
| devOps/<PROVISION_CONTEXT>/docker-compose.yml | responsible for building services<br><b>Should only modified by ESYON employees!</b> |
| devOps/<PROVISION_CONTEXT>/helm | Helm template for deployment to K8s<br><b>Should only modified by ESYON employees!</b> |
| app/oxid | oxid sources |

Be careful changing the environment - it will be deployed to any system (test / staging / production).<br>
<b>Attention: Modifying content within the devOps folder is only allowed by an employee of ESYON!</b>

### Makefile
    Every useful command can be run via makefile.
    Note: Please uncomment the grunt taksk if grunt is supposed to be enabled and change the path to the directory.
#### init
    Run setup of oxid (composer update, create directories and so on).
#### grunt
    Runs the grunt tak for the template.
    Attention: Grunt will no longe be processed during the build task. Please execute grunt befor each checkin and also checkinthe generated ressources.
#### db-import
    Imports the database if database is empty.
#### up
    Runs docker-compose up.
#### down
    Runs docker-compose stop.
#### bash
    Executes bash (sh) within the container.
#### clear-cache
    Clears OXID cache.
#### composer-update
    Runs composer update.
#### composer-dump-autoload
    Runs composer-dump-autoload.
#### create-migration
    Creates a new doctrine migration.
#### console-module-install
    Install a module (oe-console oe:module:install-configuration) by user input of the module folder.
#### console-apply-configuration
    Runs oe-console oe:module:apply-configuration.


## Checkin
    Each project is under version control (VSC).
### Feature
- always create a Feature-Branch, based on the current master:
  `Features/R<RELEASE-NO>/OF-<JIRA-TICKET-NO>_describingText`
  <br>`<RELEASE-NO>` - according to JIRA solution (1.3): `Features/R1.3/OF-123_PriceModule`
  ```
  # be sure you are on the master branch
  git checkout master
  # always pull the latest code base
  git pull
  # create a new feature branch
  git checkout -b Features/R<RELEASE-NO>/OF-<JIRA-TICKET-NO>_describingText
  ```
- run the grunt process
  ```
  make grunt
  ```
- add changes to VCS and push your code
  ```
  # add all related files
  git add -A
  # commit using a clear comment
  git commit -m "OF-<JIRA-TICKET-NO>: describingText
  # push all changes
  git push
  ```
- create merge request into test
  
- assign merge request to someone
- the PR is delivered during automatically after merge
### Hotfix
- always create a Hotfix-Branch, based on the master: `Hotfix/OF-<JIRA-TICKET-NO>_describingText`
  ```
  # be sure you are on the master branch
  git checkout master
  # always pull the latest code base
  git pull
  # create a new feature branch
  git checkout -b Hotfix/OF-<JIRA-TICKET-NO>_describingText
  ```
- run the grunt process
  ```
  make grunt
  ```
- add changes to VCS and push your code
  ```
  # add all related files
  git add -A
  # commit using a clear comment
  git commit -m "OF-<JIRA-TICKET-NO>: describingText
  # push all changes
  git push
  ```
- create merge request into test
- assign merge request to someone
- the PR is delivered during automatically after merge


## StyleGuide
- please refer to the [style guides & coding conventions](https://confluence.esyon.de/display/DEVOPS/OXID) of ESYON
- set up PHPStorm to PHP 7.4 interpreter
- use PSR1/PSR2 coding style - always format your code!
- use unix line endings (LF)
- use utf8 file encoding
- local coding checks:
- PHPCPD - https://github.com/sebastianbergmann/phpcpd
- PHPMD - https://phpmd.org/
- PHPCS - https://github.com/FriendsOfPHP/PHP-CS-Fixer
- run local unit tests before checkin