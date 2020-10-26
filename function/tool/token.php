<?php
/**
 * DateTime: 2020/8/25 16:09
 * @author: zhangshengji
 */

$source = <<<'code'
<?php

/**
 * @package A
 * DateTime: 2020/8/25 16:09
 * @author: zhangshengji
 */
class A
{
    /*
     * @var int
     */
    const PUBLIC = 1;
    
    private $data = "12345";
    
    /**
     * @param $a
     */
    public function getData() {
        return $this->data;
    }
}
?>
code;

$tokens = token_get_all($source, TOKEN_PARSE);

//var_dump($tokens);

foreach ($tokens as $key => $token) {
    if (is_array($token)) {
        echo $key.' ', token_name($token[0]) , PHP_EOL;
        if (token_name($token[0]) == 'T_DOC_COMMENT' || token_name($token[0]) == 'T_COMMENT') {
            var_dump($token);
        }
    }
}
