<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       http://github.com/zendframework/zend-stratigility for the canonical source repository
 * @copyright Copyright (c) 2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-stratigility/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Stratigility;

use InvalidArgumentException;

class Template
{
    /**
     * @var string
     */
    protected $fileTemplate;

    /**
     * @param string $template
     */
    public function __construct($fileTemplate = null)
    {
        if (null !== $fileTemplate) {
            $this->setFileTemplate($fileTemplate);
        }
    }

    /**
     * Set the template file
     *
     * @param string $fileTemplate
     */
    public function setFileTemplate($fileTemplate)
    {
        if (!file_exists($fileTemplate)) {
            throw new InvalidArgumentException(sprintf(
                "The template file specified %s doesn't exist", $fileTemplate
            ));
        }
        $this->fileTemplate = $fileTemplate;
    }

    /**
     * Get the template file
     *
     * @return string
     */
    public function getFileTemplate()
    {
        return $this->fileTemplate;
    }

    /**
     * Render the template file to standard output
     *
     * @param  array $data
     * @return string
     */
    public function render(array $data = null)
    {
        $result = function($data) {
            if (!empty($data)) {
                extract($data);
            }
            try {
                ob_start();
                $includeReturn = include $this->fileTemplate;
                $result = ob_get_clean();
            } catch (\Exception $ex) {
                ob_end_clean();
                throw $ex;
            }
            return $result;
        };
        return $result($data);
    }
}
