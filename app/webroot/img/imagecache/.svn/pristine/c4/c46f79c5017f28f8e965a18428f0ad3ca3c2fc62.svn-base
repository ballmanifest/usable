<?php
/**
 * Image behavior class.
 * Enables a model object to act as a image based
 */
App::uses('Sanitize', 'Utility');
class ImageBehavior extends ModelBehavior {
    public function setup(Model $model, $config = array()) {}

    /**
     * Before save method. Called before all saves
     * Overridden to sets right image  variables
     * @param Model $Model Model instance
     * @return boolean true to continue, false to abort the save
     */
    public function beforeSave(Model $Model, $options = array()) {
        if(isset($Model->data[$Model->name]["file"]) && !isset($Model->data[$Model->name]["save"])) {
           $data = $Model->data[$Model->name]["file"];
           $replace = array(".jpg",".png",".gif",".bmp",".jpeg");
           $Model->data["Document"]["name"] =  Sanitize::html(str_replace($replace, "", strtolower($data["name"])));
           $Model->data["Document"]["type"] =  $data["type"];
           $Model->data["Document"]["size"] =  $data["size"];
           $Model->data["Document"]["ext"] =   $this->getLastExplode( $data["name"]);
           $Model->data["Document"]["file"] =  $data["name"];
           return true;
        }
        return false;
    }

    /**
     * After save method. Called after all saves
     * Updates file field  based on S3 settings file format
     *
     * @param Model $Model Model instance.
     * @param boolean $created indicates whether the node just saved was created or updated
     * @return boolean true on success, false on failure
     */
    public function afterSave(Model $Model, $created = "") {
        if(isset($Model->data[$Model->name]["file"])) {
            $newId = $Model->getLastInsertID();
            $folderId = $Model->data[$Model->name]["folder_id"];
            $Model->data[$Model->name]["save"] = true;
            $file = "$folderId-$newId." . $Model->data[$Model->name]["ext"];
            $Model->saveField("file", $file,array('validate' => true, 'callbacks' =>false));
            return true;
        }
        return false;
    }

    /**
     * Returns image filename ext
     *
     * @param string $field String that holds the filename
     * @param string $separator character that separates the string
     * @return string $pop
     */
    protected function getLastExplode($field, $separator = ".") {
        $output = explode($separator, $field);
        $pop = array_pop($output);
        return $pop;
    }

}
?>