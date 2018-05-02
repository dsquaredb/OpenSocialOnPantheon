## ***NOTE: This is a work in progress and still has a few bugs I am actively working to solve.***

# OpenSocial on Pantheon

This repository can be used to set up a Composer-Managed OpenSocial Profile Drupal 8 site on [Pantheon](https://pantheon.io). This is an update of the [lquessenberry/OpenSocialOnPantheon](https://github.com/lquessenberry/OpenSocialOnPantheon) repository.

This repository does not set up CircleCI and does not require Terminus for initial setup.

## ***NOTE: ONLY WORKS FOR ENGLISH INSTALLATIONS AT THIS TIME***

Please refer to the official threads on Drupal.org for support requests and status of installation in other languages

* https://www.drupal.org/node/2826080#comment-11806379
* https://www.drupal.org/node/2832103

### Open Social Project

Read more about Open Social, the team and the process in Drupal.org featured case study and visit the dedicated project website on www.GetOpenSocial.com or follow @OpenSocialHQ on Twitter.

http://drupal.org/project/social

## Installation

This project can either be used as an upstream repository, or it can be set up manually.

### As an Upstream

Create a custom upstream for this project following the instructions in the [Pantheon Custom Upstream documentation](https://pantheon.io/docs/custom-upstream/). When you do this, Pantheon will automatically run composer install to populate the web and vendor directories each time you create a site.

### Manual Setup

Start off by creating a new Drupal 8 site through the Pantheon dashboard.  Then, on the site dashboard, click "install later" instead of installing Drupal. Set your site to git mode and then do the following from your local machine:
```
$ git clone https://github.com/dsquaredb/OpenSocialOnPantheon.git my-site
$ cd my-site
$ composer install
$ composer drupal-scaffold
$ git add -A .
$ git commit -m "web and vendor directory from composer install"
$ git remote set-url origin ssh://ID@ID.drush.in:2222/~/repository.git
$ git push --force origin master
```
Replace my-site with the name that you gave your Pantheon site, and replace ssh://ID@ID.drush.in:2222/~/repository.git with the URL from the middle of the SSH clone URL from the Connection Info popup dialog on your dashboard.

## Updating Your Site

When using this repository to manage your Drupal 8 site, you will no longer use the Pantheon dashboard to update your Drupal version. Instead, you will manage your updates using Composer. Updates can be applied either directly on Pantheon, by using Terminus, or on your local machine.

### Update with Terminus

Install [Terminus 0.13.4](https://github.com/pantheon-systems/terminus/releases/tag/0.13.4) and the [Terminus Composer plugin](https://github.com/rvtraveller/terminus-composer).  Then, to update your site, ensure it is in SFTP mode, and then run:
```
terminus composer update --site=sitename --env=dev
```
Other commands will work as well; for example, you may install new modules using `terminus composer require`.

### Update on your local machine

You may also place your site in Git mode, clone it locally, and then run composer commands from there.  Commit and push your files back up to Pantheon as usual.
