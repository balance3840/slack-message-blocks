<?php

namespace SlackMessage\Elements;

class UserSelect
{
    /**
     * @var array<mixed> $userSelect
     */
    protected array $userSelect = [
        'type' => 'users_select'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->userSelect['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->userSelect['action_id'] = $actionId;

        return $this;
    }

    public function initialUser(string $initialUser): self
    {
        $this->userSelect['initial_user'] = $initialUser;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->userSelect;
    }
}
