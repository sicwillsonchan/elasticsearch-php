<?php
/**
 * User: zach
 * Date: 5/1/13
 * Time: 12:16 PM
 *
 * @category ElasticSearch
 * @package  ElasticSearch\Common\Exceptions
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
namespace ElasticSearch\Common\Exceptions;

/**
 * UnexpectedValueException
 * Denote a value that is outside the normally accepted values
 */
class UnexpectedValueException extends \UnexpectedValueException implements ElasticSearchException {}
