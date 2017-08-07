<?php
namespace Home\Controller;
use Think\Controller;

class XdebugTestController extends Controller{
    
    public function basicUse(){
        var_dump(xdebug_is_enabled());
        
        $this->dumpDepthTest();
        
        ob_clean();
        
        /*
         * return the current memory usage。
         */
        var_dump(xdebug_memory_usage());
        var_dump(memory_get_usage());
        
        /**
         * return the peak memory usage.
         */
        var_dump(xdebug_peak_memory_usage());
        var_dump(memory_get_peak_usage());
        
    }
    
    /**
     * 代码覆盖率测试
     */
    public function codeCoverageTest(){
//         xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        xdebug_start_code_coverage();
        $User = D('Users');
        $User->test();
        
        var_dump(xdebug_get_code_coverage());
    }
    
    /**
     * 堆栈跟踪测试
     * 跟踪已执行的方法
     * xdebug_get_function_stack()
     */
    public function functionStackTraceTest(){
        $this->fix_string(array('Hello'));
    }
    
    /**
     * 跟踪指定方法出现的位置
     */
    public function monitoredFunctionStatcTraceTest(){
        /* Start the function monitor for strrev and array_push: */
        xdebug_start_function_monitor( [ 'strrev', 'array_push' ] );
        
        /* Run some code: */
        $str = $this->reverseStr('hello!');
        var_dump($str);
        
        var_dump(xdebug_get_monitored_functions(), xdebug_get_stack_depth());
        xdebug_stop_function_monitor();
        
        /*
         * display current function stack
         * 打印方法执行流程
         */
        xdebug_print_function_stack();
    }
    
    /**
     * effect of settings on var_dump();
     */
    public function dumpDepthTest(){
//         ini_set('xdebug.var_display_max_children', 3 );

//         ini_set('xdebug.var_display_max_depth', 5);
//         ini_set('xdebug.var_display_max_data', 1000);
        $data = array(
                'one' => 'a somewhat long string!',
                'two' => array(
                        'two.one' => array(
                                'two.one.zero' => 210,
                                'two.one.one' => array(
                                        'two.one.one.zero' => 3.141592564,
                                        'two.one.one.one'  => 2.7,
                                ),
                        ),
                ),
                'three' => array(
                        1,2,4
                ),
                'four' => range(0, 5),
        );
        var_dump($data);
    }
    
    private function reverseStr($str){
        return strrev($str);
    }
    
    private function fix_string($a)
    {
        var_dump(xdebug_get_function_stack());
    }
}