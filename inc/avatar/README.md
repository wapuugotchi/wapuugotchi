# AVATAR

The 'Avatar' feature of the WordPress plugin 'Wapuugotchi' adds a small Wapuu to the bottom right corner of the screen.
Additionally, a speech bubble is implemented, allowing Wapuu to interact with the user.

## Filter

### apply_filters( 'wapuugotchi_avatar', false )

The 'AvatarHandler' class implements a filter that allows developers to customize the avatar itself. This filter
includes an SVG string that represents the current avatar.

### apply_filters( 'wapuugotchi_avatar_message', false )

The 'MessageHandler' class implements a filter that enables developers to issue notifications through the avatar. To
accomplish this, a 'Message' model must be passed to the filter.

#### Message Model

	new Message(
	 'my_first_message',  			// Identifier
	 'Thank you for using my plugin!!', 	// Message
	 'info', 				// Border color # info|success|warning|error
	 'My\Namespace\Message::is_active', 	// Display callback # true|false
	 'My\Namespace\Message::on_submit' 	// Disable message callback
	),

You can find a real-life example in the 'Wapuugotchi\Avatar\Messages.php' file.

#### Attention

It is important to note that the 'submit_handler callback' must ensure that the 'is_active callback' returns 'false'
after the user has submitted the message. Otherwise, the message will be displayed repeatedly.
