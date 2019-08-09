<?php

class ListingBasic
{
    private $id, $title, $website, $email, $twitter;
    protected $status = 'basic';

    /**
     * ListingBasic constructor.
     * @param array $data Initial data to set from user or database
     */
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->setValues($data);
        }
    }

    /**
     * Calls individual methods to set values for object properties.
     * @param array $data Data to set from user or database
     */
    public function setValues($data = []) {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['title'])) {
            $this->setTitle($data['title']);
        }
        if (isset($data['website'])) {
            $this->setWebsite($data['website']);
        }
        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
        if (isset($data['twitter'])) {
            $this->setTwitter($data['twitter']);
        }
        if (isset($data['status'])) {
            $this->setStatus($data['status']);
        }
    }

    /**
     * Gets the local property $id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Cleans up and sets the local property $id
     * @param int $value Data may be from database or user
     */
    public function setId($value)
    {
        $this->id = trim(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
    }

    /**
     * Gets the local property $title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Cleans up and sets the local property $title
     * @param string $value to set property
     */
    public function setTitle($value)
    {
        $this->title = trim(filter_var($value, FILTER_SANITIZE_STRING));
    }

    /**
     * Gets the local property $website
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Cleans up and sets the local property $website
     * @param string $value to set property
     */
    public function setWebsite($value)
    {
        $value = trim(filter_var($value, FILTER_SANITIZE_STRING));
        if (empty($value)) {
            $this->website = null;
            return;
        }
        if (substr($value, 0, 4) != 'http') {
            $value = 'http://' . $value;
        }
        $this->website = $value;
    }

    /**
     * Gets the local property $email
     * @return string email address
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Cleans up and sets the local property $email
     * @param string $value to set property
     */
    public function setEmail($value)
    {
        $this->email = trim(filter_var($value, FILTER_SANITIZE_STRING));
    }

    /**
     * Gets the local property $twitter
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Cleans up and sets the local property $twitter
     * @param string $value to set property
     */
    public function setTwitter($value)
    {
        $this->twitter = str_replace('@', '', trim(filter_var($value, FILTER_SANITIZE_STRING)));
    }

    /**
     * Gets the local property $status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Cleans up and sets the local property $status
     * @param string $value to set property
     */
    public function setStatus($value)
    {
        if (empty($value)) {
            $this->status = 'basic';
            return;
        }
        $this->status = trim(filter_var($value, FILTER_SANITIZE_STRING));
    }

    /**
     * Convert the current object to an associative array of parameters
     * @return array of object parameters
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}