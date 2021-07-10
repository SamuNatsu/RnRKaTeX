<?php

/**
 * Rainiar's Toolkit for Typecho - KaTeX
 * 
 * @package RnRKaTeX
 * @author Rainiar
 * @version 1.3.0
 * @link https://rainiar.top
 */
class RnRKaTeX_Plugin implements Typecho_Plugin_Interface {
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header_1961744881 = array('RnRKaTeX_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer_837390541 = array('RnRKaTeX_Plugin', 'footer');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {
        $cssKatex = new Typecho_Widget_Helper_Form_Element_Text('cssKatex', NULL, _t('https://cdn.jsdelivr.net/npm/katex/dist/katex.min.css'), _t('KaTeX样式表CDN'), _t('默认值为：https://cdn.jsdelivr.net/npm/katex/dist/katex.min.css'));
        $form->addInput($cssKatex);
        $jsKatex = new Typecho_Widget_Helper_Form_Element_Text('jsKatex', NULL, _t('https://cdn.jsdelivr.net/npm/katex/dist/katex.min.js'), _t('KaTeX脚本CDN'), _t('默认值为：https://cdn.jsdelivr.net/npm/katex/dist/katex.min.js'));
        $form->addInput($jsKatex);
        $jsAutorender = new Typecho_Widget_Helper_Form_Element_Text('jsAutorender', NULL, _t('https://cdn.jsdelivr.net/npm/katex/dist/contrib/auto-render.min.js'), _t('KaTeX自动渲染脚本CDN'), _t('默认值为：https://cdn.jsdelivr.net/npm/katex/dist/contrib/auto-render.min.js'));
        $form->addInput($jsAutorender);
        $delimiter = new Typecho_Widget_Helper_Form_Element_Text('delimiter', NULL, _t('$$'), _t('公式标识符'), _t('默认值为：$$'));
        $form->addInput($delimiter);
        $ignoredTag = new Typecho_Widget_Helper_Form_Element_Text('ignoredTag', NULL, _t('"script", "noscript", "style", "textarea", "pre", "code"'), _t('忽略标签'), _t('KaTex不会在这些标签内渲染<br/>使用双引号括起标签并使用逗号分隔<br/>默认值为："script", "noscript", "style", "textarea", "pre", "code"'));
        $form->addInput($ignoredTag);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}
    
    public static function header() {
        $settings = Helper::options()->plugin('RnRKaTeX');
        echo '<link rel="stylesheet" href="' . $settings->cssKatex . '"><script src="' . $settings->jsKatex . '"></script><script src="' . $settings->jsAutorender . '"></script>';
    }
    
    public static function footer() {
        $settings = Helper::options()->plugin('RnRKaTeX');
?>
<script defer>
    function katexRender() {
        renderMathInElement(document.body,
            {
                delimiters: [
                    {
                        left: "<?php echo $settings->delimiter; ?>",
                        right: "<?php echo $settings->delimiter; ?>",
                        display: false
                    }
                ],
                ignoredTags: [<?php echo $settings->ignoredTag; ?>]
            });
    }
    katexRender();
</script>
<?php
    }
}
