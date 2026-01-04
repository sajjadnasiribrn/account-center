<?php

return [
    'sms' => [
        'badge' => 'Quick access',
        'title' => 'Verify mobile number',
        'verify_title' => 'Enter your code',
        'description' => 'Enter your mobile number to receive a short code.',
        'verify_description' => 'Type the code we sent to :phone.',
        'phone_label' => 'Mobile number',
        'phone_placeholder' => '09XXXXXXXXX',
        'code_label' => 'Verification code',
        'code_placeholder' => '0000',
        'send' => 'Send code',
        'verify' => 'Verify & continue',
        'change_phone' => 'Edit number',
        'privacy_note' => 'We only use this number to create your account - no extra name needed.',
    ],

    'google' => [
        'badge' => 'Google',
        'title' => 'Login or register',
        'description' => 'Continue with Google. No password needed.',
        'cta' => 'Continue with Google',
        'helper_text' => '',
    ],

    'otp' => [
        'sent' => 'We sent a verification code to your phone.',
        'expired' => 'The verification code has expired. Please request a new one.',
        'invalid' => 'The code you entered is not correct.',
        'default_name' => 'User :phone',
        'expires_in' => 'Code expires in :time',
        'resend' => 'Send again',
    ],

    'onboarding' => [
        'badge' => 'Finish signup',
        'title' => 'Add your email',
        'description' => 'We need an email to send order confirmations and receipts.',
        'email_label' => 'Email address',
        'email_placeholder' => 'you@example.com',
        'submit' => 'Save and continue',
        'helper' => 'All purchase details will be emailed to you.',
        'phone_hint' => 'Signed in with :phone.',
    ],
];
