<?php
/* Smarty version 3.1.48, created on 2026-09-01 10:00:36
  from '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/flashmessage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6a96862422f0a0_78748970',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea69d6ec439f719b8aa79332a1d83de0b9f8265b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/flashmessage.tpl',
      1 => 1713935288,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a96862422f0a0_78748970 (Smarty_Internal_Template $_smarty_tpl) {
$_prefixVariable1 = get_flash_message();
$_smarty_tpl->_assignInScope('message', $_prefixVariable1);
if ($_prefixVariable1) {?>
    <div class="alert alert-<?php if ($_smarty_tpl->tpl_vars['message']->value['type'] == "error") {?>danger<?php } elseif ($_smarty_tpl->tpl_vars['message']->value['type'] == 'success') {?>success<?php } elseif ($_smarty_tpl->tpl_vars['message']->value['type'] == 'warning') {?>warning<?php } else { ?>info<?php }
if ((isset($_smarty_tpl->tpl_vars['align']->value))) {?> text-<?php echo $_smarty_tpl->tpl_vars['align']->value;
}?>">
        <?php echo $_smarty_tpl->tpl_vars['message']->value['text'];?>

    </div>
<?php }
}
}
