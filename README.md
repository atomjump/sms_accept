# sms_accept

__WARNING: this project has now moved to https://src.atomjump.com/atomjump/sms_accept.git__

Accept SMS messages and post them to a forum

## Requirements

AtomJump Messaging Server > 0.6.0

Twilio or some other SMS receiving service with a phone number to receive.


## Installation

```
cd /your/messaging-server/plugins
git clone https://git.atomjump.com/sms_accept.git
```

Edit the js/config.json file as below.
Enter your URL as into e.g. Twilio's SMS notification URL on receiving an SMS.

```
http://your.messaging.server/plugins/sms_accept/
```

## Settings

```json
{
    "serverPath": "your_path/messaging-server/",
    "domain": "http://FORUM.ajmp.co",
    "forumPrename": "ajps_",
    "respond": true,
    "uniqueSenderName": "AccountSid",
    "uniqueSenderId": "ACc05c593319f12504bdd01b2cacf2f573",
    "fromField": "From",
    "bodyField": "Body"
}
```

**serverPath**  Your AtomJump Messaging server path, including the trailing slash.

**domain**  Include the code 'FORUM' where the forum name will appear. This is in the returned in a reply SMS after a user has sent their own in.

**forumPrename**  This text will be prepended to the user's entered forum, to create the true forum name.

**respond**  'True' to reply to each SMS with a confirmation SMS. 'False' does not reply.

**uniqueSenderName**  The field name parameter requested in the URL that defines who identifies the sender. In Twilio, this will be 'AccountSid'.

**uniqueSenderId**  The required value in the URL parameter defined by 'uniqueSenderName', for the message to be accepted.

**fromField**  The URL parameter sent from the SMS receiving software that defines the telephone number it is from. In Twilio, this will be 'From'.

**bodyField**  The URL parameter sent from the SMS receiving software that defines the message body. In Twilio, this will be 'Body'.

## Usage

Text a message to the phone number you set up, with 'forumName@' i.e. a trailing 'at' sign after the forum's name.
e.g. text

```
hello world travel@
```
