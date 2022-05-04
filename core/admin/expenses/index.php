<?php
/*
 Copyright (c) 2018 [Glacies UG, Berlin, Germany] (http://glacies.de)
 Developer: Thilina Hasantha (http://lk.linkedin.com/in/thilinah | https://github.com/thilinah)
 */

$moduleName = 'expenses';
$moduleGroup = 'admin';
define('MODULE_PATH',dirname(__FILE__));
include APP_BASE_PATH.'header.php';
include APP_BASE_PATH.'modulejslibs.inc.php';

$options = array();
$options['setRemoteTable'] = 'true';

$moduleBuilder = new \Classes\ModuleBuilder\ModuleBuilder();
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'ExpensesCategory','ExpensesCategory','Expenses Categories','ExpensesCategoryAdapter','','',true
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'ExpensesPaymentMethod','ExpensesPaymentMethod','Payment Methods','ExpensesPaymentMethodAdapter','','',false
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'ExpensesBusinessPurpose','ExpensesBusinessPurpose','Business Purpose','ExpensesBusinessPurposeAdapter','','',false
));

$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'EmployeeExpense','EmployeeExpense','Employee Expenses','EmployeeExpenseAdminAdapter','','',false,$options
));
echo \Classes\UIManager::getInstance()->renderModule($moduleBuilder);

$itemName = 'Expense';
$moduleName = 'Expense Management';
$itemNameLower = strtolower($itemName);


?>
<?php
include APP_BASE_PATH.'footer.php';
