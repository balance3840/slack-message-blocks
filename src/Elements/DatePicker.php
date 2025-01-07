<?php

namespace SlackMessage\Elements;

class DatePicker
{
    /** @var array<mixed> $datePicker */
    protected array $datePicker = [
        'type' => 'datepicker'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->datePicker['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->datePicker['action_id'] = $actionId;

        return $this;
    }

    public function initialDate(string $initialDate): self
    {
        $this->datePicker['initial_date'] = $initialDate;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->datePicker;
    }
}
