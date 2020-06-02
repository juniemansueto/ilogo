# Overriding files

## Overriding BREAD Views

You can override any of the BREAD views for a **single** BREAD by creating a new folder in `resources/views/vendor/logoinc/slug-name` where _slug-name_ is the _slug_ that you have assigned for that table. There are 4 files that you can override:

* browse.blade.php
* edit-add.blade.php
* read.blade.php
* order.blade.php

Alternatively you can override the views for **all** BREADs by creating any of the above files under `resources/views/vendor/logoinc/bread`

## Using custom Controllers
#### Overriding submit button:
You can override the submit button without the need to override the whole `edit-add.blade.php` by extending the `submit-buttons` section:  
```blade
@extends('logoinc::bread.edit-add')
@section('submit-buttons')
    @parent
    <button type="submit" class="btn btn-primary save">Save And Publish</button>
@endsection
```

### Using custom Controllers

You can override the controller for a single BREAD by creating a controller which extends Logoincs controller, for example:

```php
<?php

namespace App\Http\Controllers;

class LogoincCategoriesController extends \ILOGO\Logoinc\Http\Controllers\LogoincBaseController
{
    //...
}
```

After that go to the BREAD-settings and fill in the Controller Name with your fully-qualified class-name:

![](../.gitbook/assets/bread_controller.png)

You can now override all methods from the [LogoincBaseController](https://github.com/the-logoinc/logoinc/blob/1.1/src/Http/Controllers/LogoincBaseController.php)

## Overriding Logoincs Controllers

If you want to override any of Logoincs core controllers you first have to change your config file `config/logoinc.php`:

```php
/*
|--------------------------------------------------------------------------
| Controllers config
|--------------------------------------------------------------------------
|
| Here you can specify logoinc controller settings
|
*/

'controllers' => [
    'namespace' => 'App\\Http\\Controllers\\Logoinc',
],
```

Then run `php artisan logoinc:controllers`, Logoinc will now use the child controllers which will be created at `App/Http/Controllers/Logoinc`

## Overriding Logoinc-Models

You are also able to override Logoincs models if you need to.  
To do so, you need to add the following to your AppServiceProviders register method:

```php
Logoinc::useModel($name, $object);
```

Where **name** is the class-name of the model and **object** the fully-qualified name of your custom model. For example:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use ILOGO\Logoinc\Facades\Logoinc;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Logoinc::useModel('DataRow', \App\DataRow::class);
    }
    // ...
}
```

The next step is to create your model and make it extend the original model. In case of `DataRow`:

```php
<?php

namespace App;

class DataRow extends \ILOGO\Logoinc\Models\DataRow
{
    // ...
}
```

