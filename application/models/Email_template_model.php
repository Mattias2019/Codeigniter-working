<?php
include ('Base_model.php');
/**
 * Class Email_template_model
 */
class Email_template_model extends Base_model
{
    /**
     * @return string
     */
    protected function table_name()
    {
        return 'email_templates';
    }

    /**
     * @return array
     */
    protected function primary_key()
    {
        return [
            'id'
        ];
    }

    /**
     * @param $parameters
     * @param $data
     * @return mixed
     */
    public function prepare_message($parameters, $data)
    {
        if (is_array($parameters))
        {
            foreach ($parameters as $key => $value)
            {
                $data['mail_subject'] = str_replace($key, $value, $data['mail_subject']);
                $data['mail_body'] = str_replace($key, $value, $data['mail_body']);
            }
        }

        return $data;
    }
}