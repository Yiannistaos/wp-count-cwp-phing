<?php
/* ======================================================
 # [EXTENSION_REAL_NAME] for [CMS] - v[VERSION] ([FREE_PRO_VERSION] version)
 # -------------------------------------------------------
 # [FOR_CMS]
 # Author: [AUTHOR]
 # [COPYRIGHT]
 # License: [LICENSE]
 # Website: [WEBSITE]
 # Demo: [DEMO]
 # Support: [SUPPORT_EMAIL]
 # Last modified: [LAST_MODIFIED]
 ========================================================= */
// Settings page
?>
<div class="wrap">
	<h1><?php echo esc_attr($this->plugin_name ); ?> v<?php echo esc_attr($this->version); ?></h1>
    <div class="count-cwp-settings">
        <div class="count-cwp-about">
            <h2>
                <?php echo esc_html__( 'About Count CWP', 'count-cwp' ); ?>[SHOW_PRO_ONLY_IF_IS_PRO]
            </h2>

            <div style="margin-top: 20px; overflow:hidden;">
                <!-- <img class="count-cwp-product-img" src="<?php echo esc_url( plugins_url( 'img', (__FILE__) ) ); ?>/count-cwp-wordpress-plugin-120x200.png" alt="Count CWP WordPress plugin by Web357" /> -->
                <p>This WordPress plugin displays the count of Characters, Spaces, Words and Paragraphs while writing in posts/pages editor, and in other custom textarea fields, as an Editor, Author or Admin. <a href="https://www.web357.com/product/count-words-characters-paragraphs-wordpress-plugin?utm_source=SettingsPage&utm_medium=ReadMoreLink&utm_content=loginasuserwp&utm_campaign=read-more" target="_blank">Read more &raquo;</a></p>
                
            </div>

            <div style="margin-top: 20px;">
            <hr> 
                <h4><?php echo esc_html__( 'Need support?', 'count-cwp'); ?></h4>
                <?php
                echo sprintf(
                    __( '<p>If you are having problems with this plugin, please <a href="%1$s">contact us</a> and we will reply as soon as possible.</p>', 'count-cwp' ),
                    esc_url( 'https://www.web357.com/support' )
                );
                ?>
            </div>

            <div style="margin-top: 20px;" class="count-cwp-developed-by">
            <hr> 
                <span><?php echo __('Developed by', 'count-cwp'); ?></span>
                <a href="<?php echo esc_url('https://www.web357.com/'); ?>" target="_blank">
                    <img src="<?php echo esc_url( plugins_url( 'img', (__FILE__) ) ); ?>/web357-logo.png" alt="Web357 logo" />
                </a>
            </div>

        </div>
        <div class="count-cwp-form">
            <h2>
                <?php echo esc_html__( 'How it works?', 'count-cwp' ); ?>
            </h2>
            <?php echo wp_kses( __( '<p>You have to navigate to the <strong>Posts/Page page</strong> and then you will see a section under the editor with three strings `Characters`, `Words` and `Paragraphs`. If you start typing on the textarea field (editor) you will see that the counts will be increasing while typing.</p>', 'count-cwp' ), array( 'strong' => array(), 'br' => array(), 'p' => array(), 'a' => array('href'=>array()) ) ); ?>

            <h2 style="margin-top: 40px;">
                <?php echo esc_html__( 'Settings', 'count-cwp' ); ?>
            </h2>
            <form action="options.php" method="post">
                <?php settings_fields( 'count-cwp' ); ?>
                <?php do_settings_sections( 'count-cwp' ); ?>
                <?php submit_button( esc_html__( 'Save Settings', 'count-cwp' ) ); ?>
            </form>
        </div>
    </div>
</div>