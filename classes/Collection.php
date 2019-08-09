<?php

class Collection
{
    private $statuses = ['featured', 'premium', 'basic', 'inactive'];
    private $db;
    // array of listing objects
    public $listings = [];

    /**
     * Collection constructor.
     * @param PDO $db Connection to the Database
     */
    function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Select listings from the database
     * @param array $filter Associtive array of columns and values to filter
     * @return bool If listing inserted true/false
     */
    public function selectListings($filter = null)
    {
        $sql = "SELECT * FROM listings";
        if (!empty($filter)) {
            $sql .= " WHERE ";
            if (isset($filter['status']) && $filter['status'] === 'active') {
                $sql .= " status <> 'inactive' AND ";
                unset($filter['status']);
            }
            foreach (array_keys($filter) as $field) {
                $sql .= " $field = :$field AND ";
            }
            $sql = substr($sql, 0, -4);
        }
        //$sql .= ' ORDER BY status DESC, LOWER(title)';
        $sql .= ' ORDER BY CASE ';
        foreach ($this->statuses as $key=>$status) {
            $sql .= ' WHEN status=\'' . $status . '\' THEN ' . $key;
        }
        $sql .= ' END ASC, LOWER(title)';
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute($filter);
        } catch (Exception $e) {
            $this->setAlert('danger', 'Database Error: ' . $e->getMessage());
        }
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $this->addListing($data);
        }
        return $statement->rowCount();
    }

    /**
     * Add listing to collection
     * @param array $data User Data or null
     * @return object
     */
    public function addListing($data = null)
    {
        if (isset($data['status']) && $data['status'] === 'premium')
            $listing = new ListingPremium($data);
        elseif (isset($data['status']) && $data['status'] === 'featured')
            $listing = new ListingFeatured($data);
        elseif (isset($data['status']) && $data['status'] === 'inactive')
            $listing = new ListingInactive($data);
        else
            $listing = new ListingBasic($data);
        $this->listings[] = $listing;
        return $listing;
    }

    /**
     * Getter for local property $statuses
     * @return array Local property
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Insert listing
     * @param array $data User Data
     * @return bool If listing inserted true/false
     */
    public function insert($data)
    {
        $data = array_filter($this->addListing($data)->toArray());
        $sql = "INSERT INTO listings("
            . implode(', ', array_keys($data))
            . ") VALUES(:"
            . implode(', :', array_keys($data))
            . ")";
        $statement = $this->db->prepare($sql);
        $statement->execute($data);
        if ($statement->rowCount() > 0) {
            $this->setAlert(
                'success',
                '<strong>Add listing successful!</strong> ' . $data['title']
            );
            return true;
        } else {
            $this->setAlert('danger', 'Unable to update listing');
            return false;
        }
    }


    /**
     * Update listing
     * @param array $data User Data
     * @return integer Indicates the number of records updated
     */
    public function update($data)
    {
        $data = $this->addListing($data)->toArray();
        $sql = 'UPDATE listings SET ';
        foreach (array_keys($data) as $key) {
            if ($key != 'id') {
                $sql .= " $key = :$key, ";
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .= ' WHERE id = :id';
        
        // echo $sql;
        // exit;

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $count = $statement->rowCount();
        if ($count > 0) {
            $this->setAlert(
                'success',
                '<strong>Update listing successful!</strong> ' . $data['title']
            );
        } else {
            $this->setAlert('danger', 'Unable to update listing');
        }
        return $count;
    }

    /**
     * Delete a single listing
     * @param integer $id ID of the single listing to remove
     * @return bool true/false
     */
    public function delete($id)
    {
        $sql = "UPDATE listings SET status='inactive' WHERE id=?";
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindValue(1, $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        if ($statement->rowCount() > 0) {
            $this->setAlert(
                'danger',
                'Listing Deactivated'
            );
            return true;
        } else {
            $this->setAlert(
                'danger',
                '<strong>Unable to deactivate listing</strong>'
            );
            return false;
        }
    }

    /**
     * Set alerts to show user
     * @param string $type Options: primary/success/info/warning/danger
     * @param string $msg  Message to display
     * @return null sets super global $_SESSION
     */
    public function setAlert($type, $msg)
    {
        $_SESSION['alerts'][] = ['type' => $type, 'message' => $msg];
    }

    /**
     * Get alerts to show user
     * @return array
     */
    public function getAlert()
    {
        if (!isset($_SESSION['alerts'])) {
            return [];
        }
        $alerts = $_SESSION['alerts'];
        unset($_SESSION['alerts']);
        return $alerts;
    }
}
?>
