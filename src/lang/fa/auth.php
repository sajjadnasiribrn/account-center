<?php

return [
    'sms' => [
        'badge' => 'ورود/ثبت نام',
        'title' => 'ورود/ثبت نام',
        'verify_title' => 'کد تایید را وارد کنید',
        'description' => 'لطفا شماره موبایل خود را وارد کنید',
        'verify_description' => 'کد ارسال شده به :phone را وارد کنید.',
        'phone_label' => 'شماره موبایل',
        'phone_placeholder' => 'مثلا ۰۹۱۲۳۴۵۶۷۸۹',
        'code_label' => 'کد تایید',
        'code_placeholder' => '••••',
        'send' => 'دریافت کد',
        'verify' => 'تایید و ورود',
        'change_phone' => 'تغییر شماره',
        'privacy_note' => '',
    ],

    'google' => [
        'badge' => 'گوگل',
        'title' => 'ورود یا ثبت نام',
        'description' => 'بدون رمز عبور با حساب گوگل ادامه دهید.',
        'cta' => 'ورود با گوگل',
        'helper_text' => 'فقط نام و ایمیل شما برای ساخت حساب استفاده می شود.',
    ],

    'otp' => [
        'sent' => 'کد تأیید برای شما ارسال شد.',
        'expired' => 'مهلت کد به پایان رسیده است. لطفا دوباره درخواست دهید.',
        'invalid' => 'کد وارد شده صحیح نیست.',
        'default_name' => 'کاربر :phone',
        'expires_in' => 'اعتبار کد: :time',
        'resend' => 'ارسال دوباره',
    ],

    'onboarding' => [
        'badge' => 'تکمیل حساب',
        'title' => 'ایمیل خود را وارد کنید',
        'description' => 'برای ارسال رسید و اطلاعات خرید، ایمیل لازم است.',
        'email_label' => 'ایمیل',
        'email_placeholder' => 'مثلا you@example.com',
        'submit' => 'ذخیره و ادامه',
        'helper' => 'تمام جزئیات خرید و رسید به این ایمیل ارسال می شود.',
        'phone_hint' => 'با شماره :phone وارد شده اید.',
    ],
];
