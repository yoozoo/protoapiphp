<?php
/**
 * @see  https://github.com/yoozoo/protoapiphp
 * @author  chenfang<crossfire1103@gmail.com>
 */

namespace Yoozoo\ProtoApi;
use Exception;

class InvalidMessageException extends Exception {}

class CommonErrorException extends Exception {}

class InternalServerErrorException extends Exception {}

class BizErrorException extends Exception {}
