<?php


class Ban_model extends CI_Model
{
    const TYPE_USERNAME = 'username';
    const TYPE_EMAIL = 'email';
    const PARSE_EMAIL_LIKE = 'like';
    const PARSE_EMAIL_EQUAL = 'equal';
    const STATUS_BUN = 1;
    const STATUS_UNBUN = 0;

    function __construct()
    {
        parent::__construct();
        //Load Models
        $this->load->model('common_model');
    }

    /**
     *Set ban user for email or username
     */
    public function setUserBan($val, $type, $ban = self::STATUS_BUN)
    {
        $data = [
            'ban_status' => (string)$ban,// set status ban or unban
        ];

        if ($type == self::TYPE_EMAIL) {
            $emailType = self::parseEmail($val);
            if ($emailType == self::PARSE_EMAIL_EQUAL) {
                $this->db->where('email', $val);
                $this->db->update('users', $data);
            } elseif ($emailType == self::PARSE_EMAIL_LIKE) {
                $val = str_replace("*", "", $val);
                $this->db->like('email', $val, 'before');
                $this->db->update('users', $data);
            }
        } elseif ($type == self::TYPE_USERNAME) {
            $this->db->where('user_name', $val);
            $this->db->update('users', $data);
        }
    }

    private static function parseEmail($email)
    {
        $emailArr = explode("@", $email);
        if ($emailArr[0] == '*' OR empty($emailArr[0])) {
            return self::PARSE_EMAIL_LIKE;
        }
        return self::PARSE_EMAIL_EQUAL;
    }

    public function findEmailBan($email)
    {
        $emailArr = explode("@", $email);
        if (empty($emailArr[1])) {
            return false;
        }

        $this->db->select('*');
        $this->db->from('bans');
        $this->db->where('ban_type_id', EMAIL);
        $this->db->where("REPLACE(ban_value, '*', '') = ", '@' . $emailArr[1]);
        $result = $this->db->get()->row_array();
        if (!empty($result['id'])) {
            return false;
        }

        $this->db->select('*');
        $this->db->from('bans');
        $this->db->where('ban_type_id', EMAIL);
        $this->db->where("ban_value = ", $email);
        $result = $this->db->get()->row_array();
        if (!empty($result['id'])) {
            return false;
        }

        return true;
    }
}