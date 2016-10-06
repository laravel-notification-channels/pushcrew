<?php

namespace NotificationChannels\PushCrew;

class PushCrewMessage
{
    /**
     * Notification url.
     *
     * @var string
     */
    protected $url;

    /**
     * Notification message.
     *
     * @var string
     */
    protected $body;

    /**
     * Notification icon.
     *
     * @var string
     */
    protected $icon;

    /**
     * Notification title.
     *
     * @var string
     */
    protected $subject;

    public function __construct($body = '')
    {
        $this->body = $body;
    }

    /**
     * Create a message.
     *
     * @param string $body
     * @return static
     */
    public static function create($body = '')
    {
        return new static($body);
    }

    /**
     * Set the message body.
     *
     * @param string $value
     * @return $this
     */
    public function body($value)
    {
        $this->body = $value;

        return $this;
    }

    /**
     * Set the message subject.
     *
     * @param string $value
     * @return $this
     */
    public function subject($value)
    {
        $this->subject = $value;

        return $this;
    }

    /**
     * Set the message url.
     *
     * @param string $value
     * @return $this
     */
    public function url($value)
    {
        $this->url = $value;

        return $this;
    }

    /**
     * Set the message icon.
     *
     * @param string $value
     * @return $this
     */
    public function icon($value)
    {
        $this->icon = $value;

        return $this;
    }

    /**
     * Get message as array.
     *
     * @return array
     */
    public function toArray()
    {
        $message = [
            'url' => $this->url,
            'title' => $this->subject,
            'message' => $this->body,
        ];

        if ($this->icon) {
            $message['image_url'] = $this->icon;
        }

        return $message;
    }
}
