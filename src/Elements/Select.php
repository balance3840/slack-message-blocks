<?php

namespace SlackMessage\Elements;

use SlackMessage\SelectOption;

class Select
{
    /**
     * @var array<mixed> $select
     */
    protected array $select = [
        'type' => 'static_select'
    ];

    /**
     * @param array<SelectOption> $options
     */
    public function options(
        array $options
    ): self {
        $this->select['options'] = $options;

        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        $this->select['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->select['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->select;
    }
}
