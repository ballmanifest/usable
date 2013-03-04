<?php

class Rest_AppsController extends Zend_Controller_Action {

    private $_Debug = 0;
    private $_Apps = array("dropbox" => "1.0.4.0", "officeplugin" => "1.0.0.0", "outlookplugin" => "0");
    private $_ReleaseLinks = array("dropbox" => "http://www.filocity.com/app-downloads/Filocity-Dropbox-1.0.4.0.zip", "officeplugin" => "http://www.filocity.com", "outlookplugin" => "http://www.filocity.com");
    private $_ReleaseNotes = array("dropbox" => "Splash Screen, Better load timings, Performance enhancements & Guest role implementation.", "officeplugin" => "http://www.filocity.com", "outlookplugin" => "http://www.filocity.com");

    public function init() {
        $this->_Debug = $this->_request->getParam("debug", 0);
    }

    public function needupgradeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $app = $this->_request->getParam("id", "");
        $version = $this->_request->getParam("v", "0");

        if (trim($app) == "") {
            $this->_returnError("Please identify your request with app id.");
            return;
        }

        if ($version == "0") {
            $this->_returnError("Inappropriate version.");
            return;
        }

        if (!isset($this->_Apps[$app])) {
            $this->_returnError("Inappropriate app id.");
            return;
        }

        if ($version != $this->_Apps[$app]) {
            $this->_returnArrayResponse(array("Upgrade" => "YES", "ReleaseLink" => $this->_ReleaseLinks[$app], "ReleaseNotes" => $this->_ReleaseNotes[$app]));
        } else {
            $this->_returnArrayResponse(array("Upgrade" => "NO"));
        }
    }

    // Private data

    private function _returnError($error) {
        $this->_Result["status"] = "FAIL";
        $this->_Result["result"] = array("message" => $error);

        if ($this->_Debug == 1)
            print Zend_Json::prettyPrint(Zend_Json::encode($this->_Result));
        else
            print Zend_Json::encode($this->_Result);
    }

    private function _returnArrayResponse(array $response) {
        $this->_Result["status"] = "OKAY";
        $this->_Result["result"] = $response;

        if ($this->_Debug == 1)
            print Zend_Json::prettyPrint(Zend_Json::encode($this->_Result));
        else
            print Zend_Json::encode($this->_Result);

        exit;
    }

}

?>