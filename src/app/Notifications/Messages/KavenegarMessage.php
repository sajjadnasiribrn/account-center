<?php

namespace App\Notifications\Messages;

class KavenegarMessage
{
    /**
     * Recipient phone number.
     */
    public ?string $receptor = null;

    /**
     * OTP token or lookup token value.
     */
    public string $token;

    /**
     * Template name configured in Kavenegar.
     */
    public ?string $template = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function lookup(string $token): self
    {
        return new self($token);
    }

    public function to(string $phone): self
    {
        $this->receptor = $phone;

        return $this;
    }

    public function usingTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
