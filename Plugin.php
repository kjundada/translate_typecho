<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * translate everyday!
 * 
 * @package translate 
 * @author kjun
 * @version 0.0.1
 * @link http://blog.kjun.wang
 */
class translate_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('translate_Plugin', 'translate');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('translate_Plugin', 'translate');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 食用方法:<?php translate_Plugin::translate() ?>
     * @access public
     * @return void
     */
    public static function translate()
    {
        $url = $_SERVER['HTTP_REFERER'];
        include 'phpQuery.php'; 
        phpQuery::newDocumentFile('$url'); 
        $artlist = pq("article"); 
        $ch = curl_init();
        $api = 'http://fanyi.youdao.com/translate?&doctype=json&type=AUTO&i=$artlist';
        $options =  array
        (
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: text/json'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $obj = json_decode($result);
        $translate = $obj->{'tgt'};
        echo '<section class="widget">
                <h3 class="widget-title"><?php _e(\'translate to en\'); ?></h3>
                <div align="center">
                    <h5>$translate</h5>
                </div>
             </section>';
    }

}
