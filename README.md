<h1 align="center"> Arkesel API Laravel Package</h1> <br>


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [Feedback](#feedback)
- [Contributors](#contributors)
- [Getting Started](#getting-started)
    - [Installation](#installation)
    - [Arkesel v1 API](#arkesel-v1-api)
        - [Send Sms](#send-sms)
        - [Schedule Sms](#schedule-sms)
        - [Contact](#contacts)
        - [Check balance](#check-balance)
    - [Arkesel v2 API](#arkesel-v2-api)
        - [Send Sms](#send-sms-v2)
            - [Send sms with callback url](#send-sms-with-callback-url)
            - [Send sms with template](#send-sms-with-template)
        - [Schedule Sms](#schedule-sms-v2)
            - [with template](#with-template)
            - [without template](#without-template)
        - [Check balance](#check-balance-1)
        - [Get Sms Details](#get-sms-details)
        - [Contact](#contact)
            - [Create conatct](#create-conatct)
            - [Add contacts to a group](#add-contacts-to-a-group)
            - [Send SMS to group or contacts](#send-sms-to-group-or-contacts)
        - [Voice](#voice)
- [Credits](#credits)



## Feedback

Feel free to send us feedback on [file an issue](https://github.com/Freddywhest/arkesel-laravel/issues). Feature requests are always welcome. If you wish to contribute, please take a quick look at the [guidelines](./CONTRIBUTING.md)!

If there's anything you'd like to chat about, please feel free to join our [Gitter chat](https://gitter.im/git-point)!

## Contributors

This project is brought to you by [Alfred Nti](#https://github.com/Freddywhest) | [@mr_freddy59](https://twitter.com/mr_freddy59).


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- GETTING STARTED -->
## Getting Started
### Installation

1. Get a your API Key at [Arkesel](https://developers.arkesel.com/#section/Get-Started/API-Key)

2. Install this package using composer
   ```sh
   composer require roddy/arkesel
   ```

3. Copy and paste this to your .env file and replace ``xxxxxxxxxxx`` with your API key from [Arkesel](https://developers.arkesel.com/#section/Get-Started/API-Key).
   ```bash
   ARKESEL_API_KEY="xxxxxxxxxxx'
   ```

### Arkesel v1 API
#### Send Sms
1. Single receipient.

``` php
    use Roddy\Arkesel\v1\Sms;
    $sms = Sms::recipient("233501217124") // required
            ->from("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->send();
```
2. Multiple recipients

``` php
    use Roddy\Arkesel\v1\Sms;
    $sms = Sms::recipients(["233501217124", "233560001000"]) // required and should be array
            ->from("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->send();
 ```

#### Schedule sms
1. Single receipient.

``` php
    use Roddy\Arkesel\v1\Sms;
    $sms = Sms::recipient("233501217124") // required
            ->from("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->schedule();
```
2. Multiple recipients

``` php
    use Roddy\Arkesel\v1\Sms;
    $sms = Sms::recipients(["233501217124", "233560001000"]) // required and should be array
            ->from("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->schedule();
```

***Note:*** ``$sms`` will return array of object;
```php
    //$sms will return the following array of object
    [
        "code" => "ok",
        "message" => "Successfully Sent",
        "balance" => 1234, // your balance in your arkesel account
        "main_balance" => 1.12, // your main balance in your arkesel account
        "user" => "Roddy", // your arkesel account name
    ]

    $sms->code; // this will return the code
    $sms->message; // this will return the message
    $sms->balance; // this will return the balance
    $sms->main_balance; // this will return your main balance
    $sms->user; // this will return the user
```
<br />

---

<br />

#### Check Balance

``` php
    use Roddy\Arkesel\v1\Sms;
    $balace = Sms::balance();
```

***Note:*** ``$balace`` will return array object;
```php
    //$balance will return the following array object
    [
        "balance" => 5000, // your balance in your arkesel account
        "user" => "Roddy", // your arkesel account name
        "country" => "country" // country of your arkesel account
    ]
    $balance->balance; // this will return the balance
    $balance->user; // this will return the user
    $balance->country; // this will return the user
```

<br />

---

<br />

#### Contacts

``` php
    use Roddy\Arkesel\v1\Contact;
    $contact = Contact::phoneBook("Roddy Phonebook") // required
            ->phoneNumber("233501217124")// required
            ->firstName("Roddy") // not required
            ->lastName("Fred") // not required
            ->email("email@email.com") // not required
            ->company("Roddy Ltd") // not required
            ->save();
```
***Note:*** ``$contact`` will return array object;
```php
    //$contact will return the following array object
    [
        "code" => "105", 
        "message" => "You already subscribed"
    ]
    $contact->code; // this will return the code
    $contact->message; // this will return the message
```
<br />

---

### Arkesel v2 API

#### Send Sms v2

``` php
    use Roddy\Arkesel\v2\Sms;
    $sms = Sms::recipients(["233501217124"]) // required and should be array
            ->sender("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->sandBox(true) // remove if you don't use sandbox
            ->send();
 ```

##### Send sms with callback url
 ``` php
    use Roddy\Arkesel\v2\Sms;
    $sms = Sms::recipients(["233501217124"]) // required and should be array
            ->sender("Roddy") // required
            ->message("Hello, I'm using Arkesel Laravel") // required
            ->callbackUrl("https://callback_url.com") // required
            ->sandBox(true) // remove if you don't use sandbox
            ->send();
 ```

##### Send sms with template
``` php
    use Roddy\Arkesel\v2\Sms;
    $sms = Sms::recipients([
            "233501217124" => ["name" => "Roddy two", "what" => "Roddy Arkesel Laravel"],
            "233544919953" => ["name" => "Adam", "what" => "Arkesel Laravel"],
        ])->sender("Roddy") // required
        ->message("Hello <%name%>, I'm using <%what%>") // required
        ->sandBox(true) // remove if you don't use sandbox
        ->callbackUrl("https://callback_url.com") // remove if you don't use callback url
        ->sendWithTemplate();
 ```

[Click here to read more about sms template](#https://developers.arkesel.com/#tag/SMS-V2/operation/send_template_sms)
<br />
    **OR**
<br />
 <a href="https://developers.arkesel.com/#tag/SMS-V2/operation/send_template_sms"> Click here to read more about sms template </a>

---

#### Schedule Sms v2
##### with template
``` php
    use Roddy\Arkesel\v2\Sms;
    $sms = Sms::recipients([
            "233501217124" => ["name" => "Roddy two", "what" => "Roddy Arkesel Laravel"],
            "233544919953" => ["name" => "Adam", "what" => "Arkesel Laravel"],
        ])->sender("Roddy") // required
        ->message("Hello <%name%>, I'm using <%what%>") // required
        ->sandBox(true) // remove if you don't use sandbox
        ->callbackUrl("https://callback_url.com") // remove if you don't use callback url
        ->schedule();
 ```

##### without template
``` php
    use Roddy\Arkesel\v2\Sms;
    $sms = Sms::recipients(["233501217124"])
        ->sender("Roddy") // required
        ->message("Hello, I'm using Arkesel Laravel") // required
        ->sandBox(true) // remove if you don't use sandbox
        ->callbackUrl("https://callback_url.com") // remove if you don't use callback url
        ->schedule();
 ```

```php
    // $sms will  return the following array
    [
        "status" => "success",
        "data" => [
            [
                "recipient" => "233544919953",
                "id" => "9b752841-7ee7-4d40-b4fe-768bfb1da4f0"
            ],
            [
                "recipient" => "233544919953",
                "id" => "7ea01acd-485c-4df3-b646-e9e24430e145"
            ]
        ]
    ]

    $sms->status; // will return "success"
    $sms->data; // will return the following

    [
        "recipient" => "233544919953",
        "id" => "9b752841-7ee7-4d40-b4fe-768bfb1da4f0"
    ],
    [
        "recipient" => "233544919953",
        "id" => "7ea01acd-485c-4df3-b646-e9e24430e145"
    ]
```

---

#### Check balance 

``` php
    use Roddy\Arkesel\v2\Sms;
    $balance = Sms::balance();

    // $balance will  return the following array
    [
        "status" => "success",
        "data" => [
            "sms_balance" => "2003",
            "main_balance" => "GHS 20.99"
        ]
    ]

    $balance->status; // will return "success"
    $balance->data->sms_balance; // will return "2003"
    $balance->data->main_balance; // will return "GHS 20.99"
```
---

#### Get Sms Details
``` php
    use Roddy\Arkesel\v2\Sms;
    // id required
    $smsDetails = Sms::id("f3be70c1-3545-4677-b607-6b5f32202652")->get();

    // $smsDetails will  return the following array
    [
        "status" => "success",
        "data" => [
            "ID" => "f3be70c1-3545-4677-b607-6b5f32202652",
            "status" => "DELIVERED",
            "sender" => "Arkesel",
            "recipient" => "233544919953",
            "message" => "Welcome to version 2 of our API!",
            "message_count" => 1,
            "sent_at_time" => "2021-04-09 18:44:05"
        ]
    ]

    $smsDetails->status; // will return "success"
    $smsDetails->data->ID; // will return "f3be70c1-3545-4677-b607-6b5f32202652"
    $smsDetails->data->status; // will return "DELIVERED"
    $smsDetails->data->sender; // will return "Arkesel"
    $smsDetails->data->recipient; // will return "233544919953"
    $smsDetails->data->message; // will return "Welcome to version 2 of our API!"
    $smsDetails->data->message_count; // will return 1
    $smsDetails->data->sent_at_time; // will return "2021-04-09 18:44:05"
```

#### Contact
##### Create conatct
Visit [Arkesel Contact API](#https://developers.arkesel.com/#tag/SMS-V2/operation/create_contact_group) for more understanding.
```php
    use Roddy\Arkesel\v2\Conatct;
    $contact = Contact::groupName("Roddy Group") //required
                ->create()

    // $contact will return
    [
        "status" => "success",
        "message" => "Contact group has been created successfully!"
    ]

    $contact->status; // will return "success"
    $contact->message; // will return "Contact group has been created successfully!"
```
---

##### Add contacts to a group
Visit [Arkesel Add Contact API](#https://developers.arkesel.com/#tag/SMS-V2/operation/create_contacts) for more understanding.
```php
    use Roddy\Arkesel\v2\Conatct;
    $addContact = Contact::contacts([
            [
                "phone_number" => "233544919953"
            ],
            [
                "phone_number" => "233544919953",
                "first_name" => "Arkesel",
                "last_name" => "Dev",
                "company" => "Arkesel",
                "email_address" => "support@arkesel.com",
                "user_name" => "kadzam"
            ]
         ])->add()

    // $addContact will return
    [
        "status" => "success",
        "message" => "Contact group has been created successfully!"
    ]

    $addContact->status; // will return "success"
    $addContact->message; // will return "Contact group has been created successfully!"
```

---

##### Send SMS to group or contacts
Visit [Arkesel Send Message to Contact API](#https://developers.arkesel.com/#tag/SMS-V2/operation/send_sms_to_contact_group) for more understanding.
```php
    use Roddy\Arkesel\v2\Conatct;
    $sendMessage = Contact::groupName("Roddy Group") //required
                ->sender("Roddy") // required
                ->message("Hello world. Spreading peace and joy only.") // required
                ->create()

    // $contact will return
    [
        "status" => "success",
        "message" => "SMS request sent successfully!"
    ]

    $sendMessage->status; // will return "success"
    $sendMessage->message; // will return "SMS request sent successfully!"
```

---

#### Voice
This hasn't been tested yet, so if you get any issue report it [here](https://github.com/Freddywhest/arkesel-laravel/issues) for immediate fix.

Visit [Arkesel Voice API](#https://developers.arkesel.com/#tag/Voice/operation/send_voice_sms) for more understanding.
```php
    use Roddy\Arkesel\v2\Voice;
    $sendMessage = Voice::file("/C:/files/voice_message.mp3") // location of your voice file or you can use url and it's required
                ->recipients(["233501217124"]) // required and should be array
                ->send()

    // $contact will return
    [
        "status" => "success",
        "message": "SMS request sent successfully!"
    ]

    $sendMessage->status; // will return "success"
    $sendMessage->message; // will return "SMS request sent successfully!"
```
---

## Credits

- [Alfred Nti](https://github.com/Freddywhest)
- [Arkesel Docs](https://developers.arkesel.com/) (API Documentation)
- [All Contributors](https://github.com/Freddywhest/arkesel-laravel/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
