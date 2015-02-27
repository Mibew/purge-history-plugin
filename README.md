# Mibew Purge History plugin

It cleans up outdated dialogs.


## Installation

1. Get the archive with the plugin sources. You can download them from the [official site](https://mibew.org/plugins) or build the plugin from sources.

2. Untar/unzip the plugin's archive.

3. Put files of the plugins to the `<Mibew root>/plugins`  folder.

4. (optional) Add plugins configs to "plugins" structure in "`<Mibew root>`/configs/config.yml". If the "plugins" stucture looks like `plugins: []` it will become:
    ```yaml
    plugins:
        "Mibew:PurgeHistory": # Plugin's configurations are described below
            timeout: 172800
    ```

5. Navigate to "`<Mibew Base URL>`/operator/plugin" page and enable the plugin.

**Important**: The plugin uses cron tasks to perform cleaning so you need to make sure the Mibew's cron is and working.


## Plugin's configurations

The plugin can be configured with values in "`<Mibew root>`/configs/config.yml" file.

### config.timeout

Type: `Integer`

Default: `172800`

Time in seconds after which a dialog is considered outdated. The default value is 172800 seconds which is equal to two days.


## Build from sources

There are several actions one should do before use the latest version of the plugin from the repository:

1. Obtain a copy of the repository using `git clone`, download button, or another way.
2. Install [node.js](http://nodejs.org/) and [npm](https://www.npmjs.org/).
3. Install [Gulp](http://gulpjs.com/).
4. Install npm dependencies using `npm install`.
5. Run Gulp to build the sources using `gulp default`.

Finally `.tar.gz` and `.zip` archives of the ready-to-use Plugin will be available in `release` directory.


## License

[Apache License 2.0](http://www.apache.org/licenses/LICENSE-2.0.html)
