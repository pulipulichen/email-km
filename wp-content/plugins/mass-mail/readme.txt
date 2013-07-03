=== Mass Mail ===
Tags: mass, mail, email, mailer
Contributors: codestips
Requires at least: 2.7
Tested up to: 2.7


Mass Mail allows to wp bloggers to send mass mails to users groups.

== Description ==

Mass Mail is a very flexible plugin that helps bloggers to mass e-mails to users groups that he wants. You can configure the plugin to send mails to users that registered to your website, people that made a donation for you, people that subscribed to your blog or many other groups, there is no limit you should only configure the plugin.

== Installation ==

1. Put massmail.php into [wordpress_dir]/wp-content/plugins/
2. Go into the WordPress admin interface and activate the plugin
3. Optional: Go to Settings panel and click on Mass Mail, fill the group you wanna send emails and your email detail.

== Frequently Asked Questions ==

= How can I be sure that is working correctly?

Check your smtp server and see if it is started.

= How can I configure it?

1. Make sure your smtp server is started.
2. Go in the Mass Mail Setup panel of the script and fill in your details about your group. 
Table name - the table where the users are stored
Table email field - the Email field from the table you put in Table name
Sender email - the sender email that will arrive in the mails of users.

= How can I configure Sender email?

You can put in Sender email field an usual email like myemail@domain.com or you can use something like    My Name <myemail@domain.com>, so that the sender of the email look more friendly to the user.


= How can I change to what group I send?

You should check you wordpress database and select the table you wanna send mass email, put the name of the table and the name of the table email field and click Save & Send Mails ->