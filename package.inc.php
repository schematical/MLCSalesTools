<?php
define('__MLC_SALESTOOLS__', dirname(__FILE__));
define('__MLC_SALESTOOLS_CORE__', __MLC_SALESTOOLS__ . '/_core');
if(!defined('__MLC_HIGHRISE__')){
	MLCApplication::InitPackage('MLCHighrise');
}

define('__MLC_SALESTOOLS_CORE_CTL__', __MLC_SALESTOOLS_CORE__ . '/ctl');
define('__MLC_SALESTOOLS_CORE_VIEW__', __MLC_SALESTOOLS_CORE__ . '/view');
define('__MLC_SALESTOOLS_CORE_MODEL__', __MLC_SALESTOOLS_CORE__ . '/model');
define('__MLC_SALESTOOLS_BATCH__', __MLC_SALESTOOLS_CORE__ . '/batch');
define('__MLC_SALESTOOLS_CG__', __MLC_SALESTOOLS__ . '/_codegen');
MLCApplicationBase::$arrClassFiles['MSTDriver'] = __MLC_SALESTOOLS_CORE__ . '/MSTDriver.class.php';
//Notification
MLCApplicationBase::$arrClassFiles['MLCSTNotification'] = __MLC_SALESTOOLS_CORE_MODEL__ . '/MLCSTNotification.class.php';



//Batch
MLCApplicationBase::$arrClassFiles['MSTTwitterSearchBatch'] = __MLC_SALESTOOLS_BATCH__ . '/MSTTwitterSearchBatch.class.php';
MLCApplicationBase::$arrClassFiles['MSTAddSignUpUserToHiriseRecivedBatch'] = __MLC_SALESTOOLS_BATCH__ . '/MSTAddSignUpUserToHiriseRecivedBatch.class.php';
MLCApplicationBase::$arrClassFiles['MSTEmailRecivedBatch'] = __MLC_SALESTOOLS_BATCH__ . '/MSTEmailRecivedBatch.class.php';

//Control
MLCApplicationBase::$arrClassFiles['MJaxFreeMediaSearchPanel'] = __MLC_SALESTOOLS_CORE_CTL__ . '/MJaxFreeMediaSearchPanel.class.php';
MLCApplicationBase::$arrClassFiles['MJaxPreSignupForm'] = __MLC_SALESTOOLS_CORE_CTL__ . '/launch/MJaxPreSignupForm.class.php';



require_once(__MLC_SALESTOOLS_CORE__ . '/_enum.inc.php');

MSTDriver::Init();
