<?php

namespace SlackMessage\Elements;

class MultiUsersSelect
{
    /**
     * @var array<mixed> $multiUsersSelect
     */
    protected array $multiUsersSelect = [
        'type' => 'multi_users_select'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->multiUsersSelect['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->multiUsersSelect['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->multiUsersSelect;
    }
}
