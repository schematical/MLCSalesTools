<?php
MLCApplication::InitPackage('MLCMailChimp');
class MJaxPreSignupForm extends MLCForm{
    const PRESIGNUP_EVENT = "MST_PRESIGNUP_EVENT";
    protected $arrHeadline = array();
    protected $arrBody = array();
    protected $arrBackground = array();
    protected $arrButtonText = array();
    protected $txtEmail = null;
    protected $arrExtraFields = array();
    protected $btnSignup = null;
    protected $pnlSuccess = null;
    protected $arrFooterLinks = array();
    protected $blnSignUp = false;
    public function Form_Create(){
        $this->strTemplate = __MLC_SALESTOOLS_CORE_VIEW__ . '/launch/MJaxPreSignupForm.tpl.php';
        $this->txtEmail = new MJaxTextBox($this, 'txtEmail');
        $this->txtEmail->AddCssClass('input-block-level');
        $this->txtEmail->Attr('placeholder', 'Email');
        $this->btnSignup = new MJaxLinkButton($this, 'btnSignup');
        $this->btnSignup->AddCssClass('btn btn-large btn-primary pull-right');
        $this->btnSignup->AddClickEvent();
        $this->pnlSuccess = new MJaxPanel($this,'pnlSuccess');

    }
    public function AddExtraField($strDisplayAs, $mixField){
        if(
            (is_object($mixField)) &&
            ($mixField instanceof MJaxControl)
        ){
            $this->arrExtraFields[$strDisplayAs] = $mixField;
        }else{
            $txtField = new MJaxTextBox($this);
            $txtField->Name = $mixField;
            $this->arrExtraFields[$strDisplayAs] = $txtField;
        }
        $this->arrExtraFields[$strDisplayAs]->AddCssClass('input-block-level');
        $this->arrExtraFields[$strDisplayAs]->Attr('placeholder', $strDisplayAs);
        return $this->arrExtraFields[$strDisplayAs];
    }
    public function AddBackground($strSrc, $strKey = null){
        if(!is_null($strKey)){
            $this->arrBackground[$strKey] = $strSrc;
        }else{
            $this->arrBackground[] = $strSrc;
        }
    }
    public function AddButtonText($strText, $strKey = null){
        if(!is_null($strKey)){
            $this->arrButtonText[$strKey] = $strText;
        }else{
            $this->arrButtonText[] = $strText;
        }
    }
    public function AddHeadline($strHeadline, $strKey = null){
        if(!is_null($strKey)){
            $this->arrHeadline[$strKey] = $strHeadline;
        }else{
            $this->arrHeadline[] = $strHeadline;
        }
    }
    public function AddBody($strBody, $strKey = null){
        if(!is_null($strKey)){
            $this->arrBody[$strKey] = $strBody;
        }else{
            $this->arrBody[] = $strBody;
        }
    }
    public function RenderSignUpButton(){
        $strKey = MLCCookieDriver::GetCookie('btnSignup');
        if(is_null($strKey)){
            $arrKeys = array_keys($this->arrButtonText);
            $strKey = $arrKeys[rand(0, (count($arrKeys) - 1))];
            $this->TrackVariation('btnSignup', $strKey);
        }
        $this->btnSignup->Text = $this->arrButtonText[$strKey];
        return $this->btnSignup->Render();
    }
    public function RenderRandomHeadline(){
        $strKey = MLCCookieDriver::GetCookie('h2Headline');
        if(is_null($strKey)){
            $arrKeys = array_keys($this->arrHeadline);
            $strKey = $arrKeys[rand(0, (count($arrKeys) - 1))];
            $this->TrackVariation('h2Headline', $strKey);
        }
        echo $this->arrHeadline[$strKey];
    }
    public function RenderRandomBody(){
        $strKey = MLCCookieDriver::GetCookie('divBody');
        if(is_null($strKey)){
            $arrKeys = array_keys($this->arrBody);
            $strKey = $arrKeys[rand(0, (count($arrKeys) - 1))];
            $this->TrackVariation('divBody', $strKey);
        }
        echo $this->arrBody[$strKey];

    }
    public function RenderRandomBackground(){

        $strKey = MLCCookieDriver::GetCookie('imgBackground');
        if(is_null($strKey)){
            $arrKeys = array_keys($this->arrBackground);
            $strKey = $arrKeys[rand(0, (count($arrKeys) - 1))];
            $this->TrackVariation('imgBackground', $strKey);
        }
        echo $this->arrBackground[$strKey];

    }
    public function AddFooterLink($strHtml, $strUrl){
        $lnkFooter = new MJaxLinkButton($this);
        $lnkFooter->Text = $strHtml;
        $lnkFooter->Href = $strUrl;

        $this->arrFooterLinks[] = $lnkFooter;
        return $lnkFooter;
    }
    public function TrackVariation($strControlId, $strKey, $strEvent = MLCEvent::AB_TEST_DISP){
        $strKey = MLCCookieDriver::SetCookie($strControlId, $strKey);
        $objTrackingEvent = MLCEventTrackingDriver::Track($strEvent, $strKey, false);
        $objTrackingEvent->App = MLC_APPLICATION_NAME;
        $objTrackingEvent->Form = $this->FormId;
        $objTrackingEvent->ControlId = $strControlId;
        $objTrackingEvent->Name = $strEvent;
        $objTrackingEvent->Text = $strKey;
        $objTrackingEvent->Save();
    }
    public function btnSignup_click(){
        $blnValid = true;
        if(!filter_var($this->txtEmail->Text, FILTER_VALIDATE_EMAIL)){
           $blnValid = false;
        }
        foreach($this->arrExtraFields as $strKey => $txtField){
            if(strlen($txtField->Text) < 2){
                $blnValid = false;
            }
        }
        if(!$blnValid){
            return $this->Alert('Please fill out all fields');
        }
        $this->blnSignUp = true;

    //}
    //public function Form_Exit(){
        if(!$this->blnSignUp){
            return false;
        }
        error_log("Exit");
        $arrMergeData = array();
        foreach($this->arrExtraFields as $strDispalyAs => $ctlField){
            $arrMergeData[$ctlField->Name] = $ctlField->Text;
        }
        error_log("List Subscribe");//Some BS
        try{
            MLCMailChimpDriver::ListSubscribe(
                MAILCHIMP_LIST_ID,
                $this->txtEmail->Text,
                $arrMergeData
            );
        }catch(Exception $e){
            return $this->Alert($e->getMessage());
        }
        error_log("TV1");
        $this->TrackVariation(
            'imgBackground',
            MLCCookieDriver::GetCookie('imgBackground'),
            self::PRESIGNUP_EVENT
        );
        error_log("TV2");
        $this->TrackVariation(
            'h2Headline',
            MLCCookieDriver::GetCookie('h2Headline'),
            self::PRESIGNUP_EVENT
        );
        error_log("TV3");
        $this->TrackVariation(
            'divBody',
            MLCCookieDriver::GetCookie('divBody'),
            self::PRESIGNUP_EVENT
        );
        error_log("TV5");
        $this->TrackVariation(
            'btnSignup',
            MLCCookieDriver::GetCookie('btnSignup'),
            self::PRESIGNUP_EVENT
        );
        //asdf
        error_log("TriggerNotification");
        /*MSTDriver::TriggerNotification(
            'New User Signup: ' . $this->txtEmail->Text,
            $arrMergeData
        );*/
        error_log("Fin");
        $this->blnSignUp = false;
        $this->Success();
    }
    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName) {
        switch ($strName) {
            case "SuccessTemplate": return $this->pnlSuccess->Template;
            case "SuccessText": return $this->pnlSuccess->Text;
            default:
                return parent::__get($strName);
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue) {
        switch ($strName) {
            case "SuccessTemplate": return $this->pnlSuccess->Template = $mixValue;
            case "SuccessText": return $this->pnlSuccess->Text = $mixValue;
            default:
                return parent::__set($strName, $mixValue);

        }
    }

}