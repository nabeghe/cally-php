# Cally (Callable Helper for PHP)

> Just a handy helper for callables and calling them!

<hr>

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/cally
```

<hr>

### Examples

#### Example - call:

An alternative to `call_user_func_array` where you can create an array callable
and place the arguments directly in the array.

```php
use Nabeghe\Cally\Cally;

class Math
{
    public static function multiple($number1, $number2)
    {
        return $number1 * $number2;
    }
}

$value = Cally::call([Math::class, 'multiple', 13], 14);

echo $value; // 182
```

#### Example - ob:

Execute a callable between `ob_start`, `ob_get_contents`, & `ob_end_clean`, and returns the final buffer.

```php
use Nabeghe\Cally\Cally;

$output = Cally::ob(function () {
    echo 'nabeghe/cally';
});

echo $output; // nabeghe/cally
```

#### Example - action:

Invokes a series of callbacks sequentially and in order.

```php
use Nabeghe\Cally\Cally;

Cally::action([
    function (&$number) {
        echo "Action 1 = $number\n";
        $number+=1;
    },
    function ($number) {
        echo "Action 2 = $number\n";
    },
], 13);

// Action 1 = 13
// Action 2 = 14
```

#### Example - filter:

Sequentially passes a value through a series of callbacks, updating it with each callback's output, and returns the final value.

```php
use Nabeghe\Cally\Cally;

$value = Cally::filter([
    function ($value, $number) {
        echo "Filter 1 = $value\n";
        $value+=$number;
        return $value;
    },
    function ($value, $number) {
        echo "Filter 2 = $value\n";
        $value*=$number;
        return $value;
    },
], 13, 14);

echo "Value    = $value\n";

// Filter 1 = 13
// Filter 2 = 27
// Value    = 378
```

<hr>

## 📖 License

Copyright (c) 2024 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.