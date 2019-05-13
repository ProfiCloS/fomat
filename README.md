# Install with composer
```sh
$ composer require proficlos/format
```

# Static filter usage
```php
use ProfiCloS\Format;

echo Format::currency(1206.45, Format::CURRENCY_USD);
// ... etc
```

# Latte filters
Register in your neon config
```yml
services:
	filters: ProfiCloS\LatteFilterService
	nette.latteFactory:
		setup:
			- addFilter(format, [ @filters, format ])	
```

Then you can use all formatters in latte
```smarty
{$price|format:currency}

{$quantity|format:number}
```
