<?php

namespace SlackMessage\Elements;

class TimePicker
{
    /** @var array<mixed> $timePicker */
    protected array $timePicker = [
        'type' => 'timepicker'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->timePicker['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->timePicker['action_id'] = $actionId;

        return $this;
    }

    public function initialTime(string $initialTime): self
    {
        $this->timePicker['initial_time'] = $initialTime;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->timePicker;
    }
}
