<?php

namespace SlackMessage\Elements;

use SlackMessage\CheckboxOption;

class Checkboxes
{
    /**
     * @var array<mixed> $checkboxes
     */
    protected array $checkboxes = [
        'type' => 'checkboxes'
    ];

    /**
     * @param array<CheckboxOption> $options
     */
    public function options(
        array $options
    ): self {
        $this->checkboxes['options'] = $options;

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->checkboxes['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->checkboxes;
    }
}
