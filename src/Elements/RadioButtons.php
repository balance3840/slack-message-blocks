<?php

namespace SlackMessage\Elements;

use SlackMessage\RadioButtonOption;

class RadioButtons
{
    /**
     * @var array<mixed> $radioButtons
     */
    protected array $radioButtons = [
        'type' => 'radio_buttons'
    ];

    /**
     * @param array<RadioButtonOption> $options
     */
    public function options(
        array $options
    ): self {
        $this->radioButtons['options'] = $options;

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->radioButtons['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->radioButtons;
    }
}
