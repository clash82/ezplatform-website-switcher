# eZ Platform Website Switcher

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9580ba75-88cc-4949-a78a-e4422566cefa/big.png)](https://insight.sensiolabs.com/projects/9580ba75-88cc-4949-a78a-e4422566cefa)

With this bundle, you can suggest to the user to visit your website in another language. This bundle uses the main language of the browser in order to redirect to the correct site.

![screenshot](https://cloud.githubusercontent.com/assets/3033038/14352389/91adbf3e-fcd4-11e5-9a9c-90b1554228b5.png)

## Requirements

- Symfony v2.6 or later
- eZ Publish 5.4 / eZ Platform 1.x or later

## Installation

This package is available via Composer, so the instructions below are similar to how you install any other open source Symfony Bundle.

Run the following command in a terminal, from your Symfony installation root (pick most recent release):
```bash
composer require clash82/ezplatform-website-switcher
```

Enable the bundle in `app/AppKernel.php` file:

```php
$bundles = array(
    // existing bundles
    new Clash82\EzPlatformWebsiteSwitcherBundle\Clash82EzPlatformWebsiteSwitcherBundle()
);
```

Add external assets to your bundle:

- CSS:
```
bundles/clash82ezplatformwebsiteswitcher/css/website_switcher.css
components/flag-icon-css/css/flag-icon.min.css
```

- JS:
```
bundles/clash82ezplatformwebsiteswitcher/js/website_switcher.js
```

If you are installing bundle via `composer require` you must also copy assets to your project `web` directory. You can do this by calling Symfony built-in command from the project root directory:

```bash
php app/console assets:install --symlink
```

## Configuration

This is an example of required settings (config.yml):

```yaml
ez_website_switcher:
    # name to be used to store banner status
    cookie_name: websiteSwitcherStatus

    # how many days banner should be hidden when user disables the banner?
    days: 365
```

Supported languages are detected from your eZ Publish / eZ Platform installation.

## Usage

Insert the following `{{ show_website_switcher_banner() }}` helper somewhere in your header template close after body opening tag.

The following optional parameters can be set as an argument in an array format (overrides default settings and parameters from `config.yml` file):

Parameter     | Default value                                  | Description
------------- | ---------------------------------------------- | -----------
cookieName    | websiteSwitcherStatus                          | Sets your own status cookie name
days          | 365                                            | Says how many days website switcher banner should be hidden when user disables the banner

Example of usage in standard eZ Publish / eZ Platform application:

```twig
{{ show_website_switcher_banner() }}
```

or

```twig
{{ show_website_switcher_banner({
   cookieName: 'myCookie',
   days: 7
}) }}
```
