<?php
/**
 * @see  https://github.com/yoozoo/protoapiphp
 * @author  chenfang<crossfire1103@gmail.com>
 */

namespace Yoozoo\ProtoApi;

interface Message
{
    public function validate();
    public function init(array $arr);
    public function to_array();
}
