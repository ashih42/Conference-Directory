<?php

class ListingInactive extends ListingBasic
{
    protected $status = 'inactive';

    public function getTitle()
    {
        return "<strike>" . parent::getTitle() . "</strike>";
    }

    public function getWebsite()
    {
        return;
    }

    public function getEmail()
    {
        return;
    }

    public function getTwitter()
    {
        return;
    }


}
