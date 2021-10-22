# Splash WordPress Utility Classes

Basic utility classes for wordpress custom fields and meta box.
Perfect when you don't want to use a big plugin like ```Advanced Custom Fields```

## Splash Fields

### Usage
Add a field like so:
```php
/**
 * Render text field
 * @var  string $id
 * @var  string $title
 * @var  array  $options *Optional
 * 
 */
$fields = new Splash_Fields();

$fields->text('splash_audio_player_text', 'Audio Player Text');
```
## Splash Meta Box
