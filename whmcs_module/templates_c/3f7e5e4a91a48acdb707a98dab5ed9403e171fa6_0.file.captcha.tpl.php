<?php
/* Smarty version 3.1.48, created on 2026-09-01 10:00:26
  from '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/captcha.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6a96861a63f6a5_97777958',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f7e5e4a91a48acdb707a98dab5ed9403e171fa6' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/captcha.tpl',
      1 => 1713935288,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a96861a63f6a5_97777958 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['captcha']->value->isEnabled() && $_smarty_tpl->tpl_vars['captcha']->value->isEnabledForForm($_smarty_tpl->tpl_vars['captchaForm']->value)) {?>
    <div class="text-center<?php if ($_smarty_tpl->tpl_vars['containerClass']->value) {
echo $_smarty_tpl->tpl_vars['containerClass']->value;
} else { ?> row justify-content-center<?php }?>">
        <?php if ($_smarty_tpl->tpl_vars['templatefile']->value == 'homepage') {?>
            <div class="domainchecker-homepage-captcha">
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['captcha']->value == "recaptcha") {?>
            <div id="google-recaptcha-domainchecker" class="form-group recaptcha-container mx-auto"></div>
        <?php } elseif (!in_array($_smarty_tpl->tpl_vars['captcha']->value,array('invisible','recaptcha'))) {?>
            <div class="col-md-8 mx-auto mb-3 mb-sm-0">
                <div id="default-captcha-domainchecker" class="<?php if ($_smarty_tpl->tpl_vars['filename']->value == 'domainchecker') {?>input-group input-group-box <?php }?>text-center row pb-3">
                    <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"captchaverify"),$_smarty_tpl ) );?>
</p>

                    <div class="col-6 captchaimage">
                        <img id="inputCaptchaImage" data-src="<?php echo $_smarty_tpl->tpl_vars['systemurl']->value;?>
includes/verifyimage.php" src="<?php echo $_smarty_tpl->tpl_vars['systemurl']->value;?>
includes/verifyimage.php" align="middle" />
                    </div>

                    <div class="col-6">
                        <input id="inputCaptcha" type="text" name="code" maxlength="6" class="form-control <?php if ($_smarty_tpl->tpl_vars['filename']->value == 'register') {?>float-left<?php }?>"
                               data-toggle="tooltip" data-placement="right" data-trigger="manual" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>'orderForm.required'),$_smarty_tpl ) );?>
"/>
                    </div>
                </div>
            </div>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['templatefile']->value == 'homepage') {?>
            </div>
        <?php }?>
    </div>
<?php }
}
}
