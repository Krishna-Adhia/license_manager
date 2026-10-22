<?php
/* Smarty version 3.1.48, created on 2026-10-22 09:59:45
  from 'mailMessage:plaintext' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6ad9c271870601_48665951',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dac51ccee8dbecedf9afb805fb153d5c6bf41d7a' => 
    array (
      0 => 'mailMessage:plaintext',
      1 => 1792655985,
      2 => 'mailMessage',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6ad9c271870601_48665951 (Smarty_Internal_Template $_smarty_tpl) {
?>Dear <?php echo $_smarty_tpl->tpl_vars['client_name']->value;?>
,

Your order for <?php echo $_smarty_tpl->tpl_vars['service_product_name']->value;?>
 has now been activated. Please keep this message for your records.

Product/Service: <?php echo $_smarty_tpl->tpl_vars['service_product_name']->value;?>

Payment Method: <?php echo $_smarty_tpl->tpl_vars['service_payment_method']->value;?>

Amount: <?php echo $_smarty_tpl->tpl_vars['service_recurring_amount']->value;?>

Billing Cycle: <?php echo $_smarty_tpl->tpl_vars['service_billing_cycle']->value;?>

Next Due Date: <?php echo $_smarty_tpl->tpl_vars['service_next_due_date']->value;?>


Thank you for choosing us.

<?php echo $_smarty_tpl->tpl_vars['signature']->value;
}
}
