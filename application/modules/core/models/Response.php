<?php

namespace Application\Modules\Core\Models;


/**
 * Response
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Represents a response object
 */
class Response extends Base
{
    /**
     * Response code (200 -> request successful , anything else -> request failed)
     *
     * @var int
     * @access public
     */
    public $code;

    /**
     * Represents response body
     *
     * @var mixed
     * @access public
     */
    public $body;

    /**
     * Returns the value of response code
     *
     * @param N/A
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the value of response code
     *
     * @param int $code Response code
     * @return N/A
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Returns the value of response body
     *
     * @param N/A
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the value of response body
     *
     * @param mixed $body Response body
     * @return N/A
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Coverts the response body into json and sends it as requst response
     *
     * @param N/A
     * @return N/A
     */
    public function sendResponse()
    {
        $response = array(
            'code' => $this->code,
            'body' => $this->body
        );
        echo json_encode($response);
    }

}