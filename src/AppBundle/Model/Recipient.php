<?php


namespace AppBundle\Model;


class Recipient
{
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $email;

    public function __construct($data)
    {
        if (is_array($data)) {
            if (isset($data['password'])) {
                $this->password = $data['password'];
            }
            if (isset($data['email'])) {
                $this->email = $data['email'];
            }
        } else {
            $this->email = $data;
        }
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
}
