<?php
$i = 1;
st:                             //声明一个标记st,标记名称可以自定义,标记后面是冒号
echo "第{$i}次循环<br>\r\n";
if ($i++ == 10) {
    goto end;               //如果符合条件，goto跳到标记处end,离开循环
}
goto st;                        //如果符合条件，goto跳到标记处st

end:

echo "success<br>\r\n";
