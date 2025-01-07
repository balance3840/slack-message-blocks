<?php

namespace SlackMessage;

use GuzzleHttp\Client;
use SlackMessage\Elements\Button;
use SlackMessage\Elements\ChannelSelect;
use SlackMessage\Elements\Checkboxes;
use SlackMessage\Elements\ConversationSelect;
use SlackMessage\Elements\DatePicker;
use SlackMessage\Elements\RadioButtons;
use SlackMessage\Elements\TimePicker;
use SlackMessage\Elements\MultiConversationsSelect;
use SlackMessage\Elements\MultiUsersSelect;
use SlackMessage\Elements\UserSelect;
use SlackMessage\Elements\Select;
use SlackMessage\Enums\ButtonStyle;
use SlackMessage\Enums\InputTriggerAction;

/**
 * Class Message
 *
 * This class is responsible for creating and sending Slack messages.
 *
 * @package SlackMessage
 *
 * @method self text(string $content) Adds a plain text section to the message.
 * @method self markdown(string $content) Adds a markdown section to the message.
 * @method self header(string $content) Adds a header section to the message.
 * @method self userSelect(string $label, string $placeholder, string $actionId, ?string $initialUser = null) Adds a user select element to the message.
 * @method self multiUsersSelect(string $label, string $placeholder, string $actionId) Adds a multi-users select element to the message.
 * @method self select(string $label, string $placeholder, string $actionId, callable $callback) Adds a select element to the message.
 * @method self multiSelect(string $label, string $placeholder, string $actionId, callable $callback) Adds a multi-select element to the message.
 * @method self overflow(string $label, string $actionId, callable $callback) Adds an overflow menu element to the message.
 * @method self datePicker(string $label, string $placeholder, string $actionId, ?string $initialDate = null) Adds a date picker element to the message.
 * @method self timePicker(string $label, string $placeholder, string $actionId, ?string $initialTime = null) Adds a time picker element to the message.
 * @method self textBlock(callable $callback) Adds a custom text block to the message.
 * @method self divider() Adds a divider block to the message.
 * @method self conversationSelect(string $label, string $placeholder, string $actionId, ?string $initialConversation = null, array $include = [], bool $excludeBotUsers = false, bool $excludeExternalSharedChannels = false) Adds a conversation select element to the message.
 * @method self channelSelect(string $label, string $placeholder, string $actionId, ?string $initialChannel = null) Adds a channel select element to the message.
 * @method self multiConversationSelect(string $label, string $placeholder, string $actionId) Adds a multi-conversation select element to the message.
 * @method self button(string $label, string $placeholder, string $value, string $actionId, ?ButtonStyle $style = ButtonStyle::DEFAULT) Adds a button element to the message.
 * @method self linkButton(string $label, string $placeholder, string $value, string $url, string $actionId) Adds a link button element to the message.
 * @method self sectionImage(string $text, string $url, string $altText) Adds an image to a section block in the message.
 * @method self checkboxes(string $label, string $actionId, callable $callback) Adds a checkboxes element to the message.
 * @method self radioButtons(string $label, string $actionId, callable $callback) Adds a radio buttons element to the message.
 * @method self context(callable $callback) Adds a context block to the message.
 * @method self image(string $url, string $altText, ?string $title = null) Adds an image block to the message.
 * @method self action(callable $callback) Adds an action block to the message.
 * @method self textInput(string $label, ?bool $multiLine = false, ?string $actionId = null, ?InputTriggerAction $triggerActionOn = InputTriggerAction::ON_ENTER_PRESSED) Adds a text input element to the message.
 * @method self multiUsersSelectInput(string $label, string $placeholder, string $actionId) Adds a multi-users select input element to the message.
 * @method self selectInput(string $label, string $placeholder, string $actionId, callable $callback) Adds a select input element to the message.
 * @method self multiSelectInput(string $label, string $placeholder, string $actionId, callable $callback) Adds a multi-select input element to the message.
 * @method self datePickerInput(string $label, string $placeholder, string $actionId, ?string $initialDate = null) Adds a date picker input element to the message.
 * @method self checkboxesInput(string $label, string $actionId, callable $callback) Adds a checkboxes input element to the message.
 * @method self radioButtonsInput(string $label, string $actionId, callable $callback) Adds a radio buttons input element to the message.
 * @method self timePickerInput(string $label, string $placeholder, string $actionId, ?string $initialTime = null) Adds a time picker input element to the message.
 * @method array toArray() Returns the message blocks as an array.
 * @method bool send() Sends the message to the configured webhook URL.
 */
class Message
{
    protected string $webhookUrl;
    /** @var array<mixed> $blocks*/
    protected array $blocks = [];

    public function __construct(string $webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    public function text(string $content): self
    {
        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'plain_text',
                'text' => $content,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function markdown(string $content): self
    {
        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $content
            ]
        ];

        return $this;
    }

    public function header(string $content): self
    {
        $this->blocks[] = [
            'type' => 'header',
            'text' => [
                'type' => 'plain_text',
                'text' => $content,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function userSelect(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialUser = null
    ): self {
        $userSelect = new UserSelect;

        $userSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialUser) {
            $userSelect->initialUser($initialUser);
        }

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $userSelect->toArray()
        ];

        return $this;
    }

    public function multiUsersSelect(string $label, string $placeholder, string $actionId): self
    {
        $multiUsersSelect = new MultiUsersSelect;

        $multiUsersSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $multiUsersSelect->toArray()
        ];

        return $this;
    }

    public function select(
        string $label,
        string $placeholder,
        string $actionId,
        callable $callback
    ): self {
        $selectOption = new SelectOption;
        $callback($selectOption);

        $select = new Select;

        $select
            ->placeholder($placeholder)
            ->options($selectOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $select->toArray()
        ];

        return $this;
    }

    public function multiSelect(
        string $label,
        string $placeholder,
        string $actionId,
        callable $callback
    ): self {
        $selectOption = new SelectOption;
        $callback($selectOption);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => [
                'type' => 'multi_static_select',
                'placeholder' => [
                    'type' => 'plain_text',
                    'text' => $placeholder,
                    'emoji' => true
                ],
                'options' => $selectOption->toArray(),
                'action_id' => $actionId
            ]
        ];

        return $this;
    }

    public function overflow(
        string $label,
        string $actionId,
        callable $callback
    ): self {
        $overflowOption = new OverflowOption;
        $callback($overflowOption);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => [
                'type' => 'overflow',
                'options' => $overflowOption->toArray(),
                'action_id' => $actionId
            ]
        ];

        return $this;
    }

    public function datePicker(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialDate = null,
    ): self {
        $datePicker = new DatePicker;

        $datePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialDate) {
            $datePicker->initialDate($initialDate);
        }

        $block = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $datePicker->toArray()
        ];

        if ($initialDate) {
            $block['accessory']['initial_date'] = $initialDate;
        }

        $this->blocks[] = $block;

        return $this;
    }

    public function timePicker(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialTime = null,
    ): self {
        $timePicker = new TimePicker;

        $timePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialTime) {
            $timePicker->initialTime($initialTime);
        }

        $block = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $timePicker->toArray()
        ];

        $this->blocks[] = $block;

        return $this;
    }

    public function textBlock(callable $callback): self
    {
        $block = new TextBlock;
        $callback($block);

        $this->blocks[] = $block->toArray();

        return $this;
    }

    public function divider(): self
    {
        $this->blocks[] = [
            'type' => 'divider'
        ];

        return $this;
    }

    /**
     * @param string $label
     * @param string $placeholder
     * @param string $actionId
     * @param string|null $initialConversation
     * @param array<string> $include
     * @param bool $excludeBotUsers
     * @param bool $excludeExternalSharedChannels
     * @return self
     */
    public function conversationSelect(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialConversation = null,
        array $include = [],
        bool $excludeBotUsers = false,
        bool $excludeExternalSharedChannels = false
    ): self {
        $conversationSelect = new ConversationSelect;

        $conversationSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialConversation) {
            $conversationSelect->initialConversation($initialConversation);
        }

        $conversationSelect->filter($include, $excludeBotUsers, $excludeExternalSharedChannels);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $conversationSelect->toArray()
        ];

        return $this;
    }

    public function channelSelect(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialChannel = null
    ): self {
        $channelSelect = new ChannelSelect;

        $channelSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialChannel) {
            $channelSelect->initialChannel($initialChannel);
        }

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $channelSelect->toArray()
        ];

        return $this;
    }

    public function multiConversationSelect(string $label, string $placeholder, string $actionId): self
    {
        $multiConversationSelect = new MultiConversationsSelect;

        $multiConversationSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $multiConversationSelect->toArray()
        ];

        return $this;
    }

    public function button(
        string $label,
        string $placeholder,
        string $value,
        string $actionId,
        ?ButtonStyle $style = ButtonStyle::DEFAULT
    ): self {
        $button = new Button();

        $button
            ->text($placeholder)
            ->value($value)
            ->actionId($actionId)
            ->style($style);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $button->toArray()
        ];

        return $this;
    }

    public function linkButton(
        string $label,
        string $placeholder,
        string $value,
        string $url,
        string $actionId
    ): self {
        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => [
                'type' => 'button',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $placeholder,
                    'emoji' => true
                ],
                'value' => $value,
                'url' => $url,
                'action_id' => $actionId
            ]
        ];

        return $this;
    }

    public function sectionImage(
        string $text,
        string $url,
        string $altText,
    ): self {
        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $text
            ],
            'accessory' => [
                'type' => 'image',
                'image_url' => $url,
                'alt_text' => $altText
            ]
        ];

        return $this;
    }

    public function checkboxes(
        string $label,
        string $actionId,
        callable $callback
    ): self {
        $checkboxOption = new CheckboxOption;
        $callback($checkboxOption);

        $checkboxes = new Checkboxes;

        $checkboxes
            ->options($checkboxOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $checkboxes->toArray()
        ];

        return $this;
    }

    public function radioButtons(
        string $label,
        string $actionId,
        callable $callback
    ): self {
        $radioButtonOption = new RadioButtonOption;
        $callback($radioButtonOption);

        $radioButtons = new RadioButtons;

        $radioButtons
            ->options($radioButtonOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $label
            ],
            'accessory' => $radioButtons->toArray()
        ];

        return $this;
    }

    public function context(callable $callback): self
    {
        $element = new ContextElement;
        $callback($element);

        $this->blocks[] = [
            'type' => 'context',
            'elements' => $element->toArray()
        ];

        return $this;
    }

    public function image(
        string $url,
        string $altText,
        ?string $title = null
    ): self {
        $block = [
            'type' => 'image',
            'image_url' => $url,
            'alt_text' => $altText
        ];

        if ($title) {
            $block['title'] = [
                'type' => 'plain_text',
                'text' => $title,
                'emoji' => true
            ];
        }

        $this->blocks[] = $block;

        return $this;
    }

    public function action(callable $callback): self
    {
        $actionElement = new ActionElement;
        $callback($actionElement);

        $this->blocks[] = [
            'type' => 'actions',
            'elements' => $actionElement->toArray()
        ];

        return $this;
    }

    public function textInput(
        string $label,
        ?bool $multiLine = false,
        ?string $actionId = null,
        ?InputTriggerAction $triggerActionOn = InputTriggerAction::ON_ENTER_PRESSED
    ): self {
        $block = [
            'type' => 'input',
            'element' => [
                'type' => 'plain_text_input',
                'multiline' => $multiLine
            ],
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        if ($actionId) {
            $block['dispatch_action'] = true;

            $element = &$block['element'];

            $element['action_id'] = $actionId;
            $element['dispatch_action_config'] = [
                'trigger_actions_on' => [
                    $triggerActionOn->value
                ]
            ];
        }

        $this->blocks[] = $block;

        return $this;
    }

    public function multiUsersSelectInput(
        string $label,
        string $placeholder,
        string $actionId
    ): self {
        $multiUsersSelect = new MultiUsersSelect;

        $multiUsersSelect
            ->placeholder($placeholder)
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'input',
            'element' => $multiUsersSelect->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function selectInput(
        string $label,
        string $placeholder,
        string $actionId,
        callable $callback
    ): self {
        $selectOption = new SelectOption;
        $callback($selectOption);

        $select = new Select;

        $select
            ->placeholder($placeholder)
            ->options($selectOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'input',
            'element' => $select->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function multiSelectInput(
        string $label,
        string $placeholder,
        string $actionId,
        callable $callback
    ): self {
        $selectOption = new SelectOption;
        $callback($selectOption);

        $this->blocks[] = [
            'type' => 'input',
            'element' => [
                'type' => 'multi_static_select',
                'placeholder' => [
                    'type' => 'plain_text',
                    'text' => $placeholder,
                    'emoji' => true
                ],
                'options' => $selectOption->toArray(),
                'action_id' => $actionId
            ],
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function datePickerInput(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialDate = null,
    ): self {
        $datePicker = new DatePicker;

        $datePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialDate) {
            $datePicker->initialDate($initialDate);
        }

        $block = [
            'type' => 'input',
            'element' => $datePicker->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        if ($initialDate) {
            $block['element']['initial_date'] = $initialDate;
        }

        $this->blocks[] = $block;

        return $this;
    }

    public function checkboxesInput(
        string $label,
        string $actionId,
        callable $callback
    ): self {
        $checkboxOption = new CheckboxOption;
        $callback($checkboxOption);

        $checkboxes = new Checkboxes;

        $checkboxes
            ->options($checkboxOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'input',
            'element' => $checkboxes->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function radioButtonsInput(
        string $label,
        string $actionId,
        callable $callback
    ): self {
        $radioButtonOption = new RadioButtonOption;
        $callback($radioButtonOption);

        $radioButtons = new RadioButtons;

        $radioButtons
            ->options($radioButtonOption->toArray())
            ->actionId($actionId);

        $this->blocks[] = [
            'type' => 'input',
            'element' => $radioButtons->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        return $this;
    }

    public function timePickerInput(
        string $label,
        string $placeholder,
        string $actionId,
        ?string $initialTime = null,
    ): self {
        $timePicker = new TimePicker;

        $timePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialTime) {
            $timePicker->initialTime($initialTime);
        }

        $block = [
            'type' => 'input',
            'element' => $timePicker->toArray(),
            'label' => [
                'type' => 'plain_text',
                'text' => $label,
                'emoji' => true
            ]
        ];

        $this->blocks[] = $block;

        return $this;
    }

    public function richTextElements(callable $callback): self
    {
        $richTextElement = new RichTextElement;
        $callback($richTextElement);

        $this->blocks[] = [
            'type' => 'rich_text',
            'elements' => $richTextElement->toArray()
        ];

        return $this;
    }

    public function file(string $url, string $externalId): self
    {
        $this->blocks[] = [
            'type' => 'file',
            'external_id' => $externalId,
            'source' => $url
        ];

        return $this;
    }

    /** @return array<mixed> */
    public function toArray(): array
    {
        return $this->blocks;
    }

    public function send(): bool
    {
        $data = [
            'blocks' => $this->blocks
        ];

        $httpClient = new Client();

        $response = $httpClient->post($this->webhookUrl, [
            'form_params' => [
                'payload' => json_encode($data),
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return true;
        }

        return false;
    }
}
