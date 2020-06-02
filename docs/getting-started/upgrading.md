# Upgrading

## Upgrading 1.2 to 1.3

{% hint style="info" %}
Please take a look at our [prerequisites](../getting-started/prerequisites.md) before upgrading!
{% endhint %}

### Update your Composer.json

To update to the latest version inside of your composer.json file make sure to update the version of Logoinc inside the require declaration inside of your composer.json to:

`ilogo/logoinc": "1.3.*`

And then run `composer update`

### Changes to LogoincAuth
The `LogoincAuth` singleton was introduced in Logoinc 1.2 and returned an instance of the guard.  
In Logoinc 1.3 this singleton was renamed to `LogoincGuard` and now returns the name of the guard as a string.
Read more on custom guards [here](../customization/custom-guard.md)

## Update Configuration
The `logoinc.php` configuration file had a few changes.  

```
'user' => [
    'namespace' => null,
],
```
was removed. The user-model which will be used in the `logoinc:admin` command is now determined based on the [guard](../customization/custom-guard.md).

### Troubleshooting

Be sure to ask us on our slack channel if you are experiencing any issues and we will try and assist. Thanks.
