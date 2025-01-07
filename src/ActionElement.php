<?php

namespace SlackMessage;

use SlackMessage\Elements\Button;
use SlackMessage\Elements\ChannelSelect;
use SlackMessage\Elements\Checkboxes;
use SlackMessage\Elements\ConversationSelect;
use SlackMessage\Elements\DatePicker;
use SlackMessage\Elements\RadioButtons;
use SlackMessage\Elements\Select;
use SlackMessage\Elements\TimePicker;
use SlackMessage\Elements\UserSelect;
use SlackMessage\Enums\ButtonStyle;

/**
 * Class ActionElement
 *
 * This class is responsible for managing Slack action elements.
 *
 * @package SlackMessage
 *
 * @method self button(string $text, string $value, string $actionId, ?ButtonStyle $style = ButtonStyle::DEFAULT) Adds a button element to the action elements.
 * @method self checkboxes(string $actionId, callable $callback) Adds a checkboxes element to the action elements.
 * @method self datePicker(string $placeholder, string $actionId, ?string $initialDate = null) Adds a date picker element to the action elements.
 * @method self radioButtons(string $actionId, callable $callback) Adds a radio buttons element to the action elements.
 * @method self timePicker(string $placeholder, string $actionId, ?string $initialTime = null) Adds a time picker element to the action elements.
 * @method self conversationSelect(string $placeholder, string $actionId, ?string $initialConversation = null, array $include = [], bool $excludeBotUsers = false, bool $excludeExternalSharedChannels = false) Adds a conversation select element to the action elements.
 * @method self channelSelect(string $placeholder, string $actionId, ?string $initialChannel = null) Adds a channel select element to the action elements.
 * @method self userSelect(string $placeholder, string $actionId, ?string $initialUser = null) Adds a user select element to the action elements.
 * @method self select(string $actionId, callable $callback) Adds a select element to the action elements.
 * @method array toArray() Returns the elements array.
 */
class ActionElement
{
    /** 
     * @var array<mixed> $elements 
     * An array to store the action elements.
     */
    protected array $elements = [];

    /**
     * Adds a button element to the action elements.
     *
     * @param string $text The text to display on the button.
     * @param string $value The value to be sent when the button is clicked.
     * @param string $actionId The unique identifier for the action triggered by the button.
     * @param ?ButtonStyle $style The style of the button (optional).
     * @return self Returns the instance of the ActionElement for method chaining.
     */
    public function button(
        string $text,
        string $value,
        string $actionId,
        ?ButtonStyle $style = ButtonStyle::DEFAULT
    ): self {
        $button = new Button();

        $button
            ->text($text)
            ->value($value)
            ->actionId($actionId)
            ->style($style);

        $this->elements[] = $button->toArray();

        return $this;
    }

    /**
     * Adds a date picker element to the action elements.
     *
     * @param string $placeholder The placeholder text to display in the date picker.
     * @param string $actionId The unique identifier for the action triggered by the date picker.
     * @param ?string $initialDate The initial date to be selected in the date picker (optional).
     * @return self Returns the instance of the ActionElement for method chaining.
     */
    public function datePicker(
        string $placeholder,
        string $actionId,
        ?string $initialDate = null
    ): self {
        $datePicker = new DatePicker();

        $datePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialDate) {
            $datePicker->initialDate($initialDate);
        }

        $this->elements[] = $datePicker->toArray();

        return $this;
    }

    public function timePicker(
        string $placeholder,
        string $actionId,
        ?string $initialTime = null
    ): self {
        $timePicker = new TimePicker;

        $timePicker
            ->placeholder($placeholder)
            ->actionId($actionId);

        if ($initialTime) {
            $timePicker->initialTime($initialTime);
        }

        $this->elements[] = $timePicker->toArray();

        return $this;
    }

    public function checkboxes(
        string $actionId,
        callable $callback
    ): self {
        $checkboxOption = new CheckboxOption;
        $callback($checkboxOption);

        $checkboxes = new Checkboxes;

        $checkboxes
            ->options($checkboxOption->toArray())
            ->actionId($actionId);

        $this->elements[] = $checkboxes->toArray();

        return $this;
    }

    public function radioButtons(
        string $actionId,
        callable $callback
    ): self {
        $radioButtonOption = new RadioButtonOption;
        $callback($radioButtonOption);

        $radioButtons = new RadioButtons;

        $radioButtons
            ->options($radioButtonOption->toArray())
            ->actionId($actionId);

        $this->elements[] = $radioButtons->toArray();

        return $this;
    }

    /**
     * Adds a conversation select element to the action elements.
     *
     * @param string $placeholder The placeholder text to display in the conversation select.
     * @param string $actionId The unique identifier for the action triggered by the conversation select.
     * @param ?string $initialConversation The initial conversation to be selected in the conversation select (optional).
     * @param array<string> $include An array of types of conversations to include (optional).
     * @param bool $excludeBotUsers A boolean value to exclude bot users from the conversation select (optional).
     * @param bool $excludeExternalSharedChannels A boolean value to exclude external shared channels from the conversation select (optional).
     * @return self Returns the instance of the ActionElement for method chaining.
     */
    public function conversationSelect(
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

        $this->elements[] = $conversationSelect->toArray();

        return $this;
    }

    public function channelSelect(
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

        $this->elements[] = $channelSelect->toArray();

        return $this;
    }

    public function userSelect(
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

        $this->elements[] = $userSelect->toArray();

        return $this;
    }

    public function select(
        string $actionId,
        callable $callback
    ): self {
        $selectOption = new SelectOption;
        $callback($selectOption);

        $select = new Select;

        $select
            ->options($selectOption->toArray())
            ->actionId($actionId);

        $this->elements[] = $select->toArray();

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->elements;
    }
}
