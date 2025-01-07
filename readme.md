# Slack Message Blocks

 Slack Message Blocks is a PHP package designed to simplify the process of creating and sending rich, interactive messages to Slack. This package provides a fluent interface for building various Slack message elements, including buttons, select menus, date pickers, and more.

## Features

- **Fluent Interface**: Easily chain methods to build complex Slack messages.
- **Rich Elements**: Support for buttons, select menus, checkboxes, radio buttons, date pickers, time pickers, and more.
- **Customizable**: Configure elements with placeholders, initial values, and additional options.
- **Webhook Integration**: Send messages directly to Slack using webhooks.

## Installation

Install the package via Composer:

```bash
composer require ramiroestrella/slack-message-blocks
```

## Usage

### Creating a Message

```php
use SlackMessage\Message;
use SlackMessage\Enums\ButtonStyle;

$webhookUrl = 'https://hooks.slack.com/services/your/webhook/url';

$message = (new Message($webhookUrl))
    ->header('Daily Standup')
    ->text('Please provide your updates:')
    ->button('Submit', 'submit_value', 'submit_action', ButtonStyle::PRIMARY)
    ->send();

if ($message) {
    echo "Message sent successfully!";
} else {
    echo "Failed to send message.";
}
```

### Adding Elements

You can add various elements to your message:

```php
$message = (new Message($webhookUrl))
    ->header('Daily Standup')
    ->text('Please provide your updates:')
    ->datePicker('Select a date', 'date_picker_action')
    ->timePicker('Select a time', 'time_picker_action')
    ->userSelect('Select a user', 'Select a user', 'user_select_action')
    ->checkboxes('Select options', 'checkboxes_action', function($checkboxOption) {
        $checkboxOption->option('Option 1', 'value1')
                       ->option('Option 2', 'value2');
    })
    ->send();
```

## Documentation

For detailed documentation on all available methods and options, please refer to the source code and doc comments.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
