<?php

class ListingFeatured extends ListingPremium
{
    protected $status = 'featured';
    protected $coc;

    /**
     * Gets the local property $coc
     * @return string
     */
    public function getCoc()
    {
        return $this->coc;
    }

    /**
     * Cleans up and sets the local property $coc
     * @param string $value to set property
     */
    public function setCoc($value)
    {
        $this->coc = trim(strip_tags($value, self::$allowed_tags));
    }

    /**
     * Calls individual methods to set values for object properties.
     * @param array $data Data to set from user or database
     */
    public function setValues($data = []) {
        parent::setValues($data);
        if (isset($data['coc'])) {
            $this->setCoc($data['coc']);
        }
    }
}
