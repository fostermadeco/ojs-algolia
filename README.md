# ojs-algolia
Plugin integrating OJS and Algolia

## Server requirements
- PHP Packages:
    - mbstring
    - curl

- Composer

## Installation
- Download the zip for this repository, place it into `plugin/generic` and extract it using the command below:
  `unzip ojs-algolia-master.zip && mv ojs-algolia-master algolia && rm -f ojs-algolia-master.zip`
- In the plugin directory, run `composer install`
- In Settings > Website > Plugins, activate the plugin
- From within the plugin's settings add the name of your index and copy the Application ID (App ID),
  Search API Key (Search Only Key) and Write API Key (Admin Key)